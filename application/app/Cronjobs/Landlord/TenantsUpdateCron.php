<?php

/** -------------------------------------------------------------------------------------------------
 * TenantsCronStatus
 * This cronjob is just used to record whether the tenant cronjobs have executed
 * This cron actually executes during the 'tenants' cron jobs run
 * @package    Grow CRM
 * @author     NextLoop
 *---------------------------------------------------------------------------------------------------*/

namespace App\Cronjobs\Landlord;
use DB;
use Illuminate\Support\Facades\Schema;
use Log;

class TenantsUpdateCron {

    public function __invoke() {

        //[MT] - landlord only
        if (env('MT_TPYE')) {
            if (\Spatie\Multitenancy\Models\Tenant::current()) {
                return;
            }
        }

        //[MT] - run config settings for landlord
        runtimeLandlordCronConfig();

        //only do this if the landord database is updated to v1.3 and above
        if (Schema::connection('landlord')->hasColumn('tenants', 'tenant_updating_current_version')) {
            $this->updateTenantsDB();
        }

    }

    /**
     * Update each tenant database
     */
    public function updateTenantsDB() {

        Log::info("tenants updating process has started. Looking for tenants to update - started", ['process' => '[update-tenant-databases]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);

        //current version
        $target_system_version = config('system.settings_version');

        //check if we have an x.sql file to match this version
        $filepath = BASE_DIR . "/updates/$target_system_version.sql";

        //only do the update if the file exists
        if (!file_exists($filepath)) {
            //log as info and not error
            Log::info("tenants updating process halted. The sql file ($target_system_version.sql) could not be found.It may not be required for this version ($target_system_version)", ['process' => '[update-tenant-databases]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
            return;
        }

        //counts
        $count_passed = 0;
        $count_failed = 0;

        //get all customers with a version less than the system version and are not in (failed) or (processing) status
        $limit = 5;
        $customers = \App\Models\Landlord\Tenant::on('landlord')
            ->where('tenant_updating_status', 'completed')
            ->where(function ($query) use ($target_system_version) {
                $query->where('tenant_updating_current_version', '<', $target_system_version)
                    ->orWhereNull('tenant_updating_current_version');
            })
            ->take($limit)
            ->get();

        //count
        $count = $customers->count();

        //count how many we are updating
        if ($count == 0) {
            Log::info("no tenants were found that are eligable for an update to version ($target_system_version)", ['process' => '[update-tenant-databases]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
            return;
        } else {
            Log::info("found ($count) tenants that are eligable for an update to version ($target_system_version)", ['process' => '[update-tenant-databases]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
        }

        //mark each tenant as updating
        foreach ($customers as $customer) {
            $customer->update([
                'tenant_updating_status' => 'processing',
                'tenant_updating_target_version' => $target_system_version,
            ]);
        }

        //update each tenant
        foreach ($customers as $customer) {

            \Spatie\Multitenancy\Models\Tenant::forgetCurrent();

            Log::info("updating database for tenant id (" . $customer->tenant_id . ") - domain (" . $customer->domain . ") - started", ['process' => '[update-tenant-databases]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);

            //get the customer from landlord db
            if ($tenant = \Spatie\Multitenancy\Models\Tenant::Where('tenant_id', $customer->tenant_id)->first()) {
                try {
                    //swicth to this tenants DB
                    $tenant->makeCurrent();

                    /** -------------------------------------------------------------------------------------------------------------
                     * [FORCED MODE] [CONTINUE IMPORTING SQL ON ERRORS] - January 2024
                     *
                     * Breakdown the SQL file into query by query and execute them 1 by one
                     * Catch any error but continue to the end of the file
                     *
                     * [DEVELOPER NOTES]
                     *
                     * Unisng this mode is usually needed if there are problems updating and requires manual action as follows
                     *
                     *    (1) Edit the /config/settings.php and add a setting
                     *              'force_sql_update' =>  true,
                     *    (2) Be 100% certain that the sql file in the /updates/ folder is the version you want to force importing
                     *    (2) Update all 'processing' updates in the landlord 'tenants' table as 'completed'
                     *    (3) Remvoe the /config/settings.php after done
                     *
                     * ------------------------------------------------------------------------------------------------------------*/
                    if (config('settings.force_sql_update') === true) {

                        // Read the contents of the SQL file
                        $sql_content = file_get_contents($filepath);

                        // Split the SQL content into individual queries
                        $sql_queries = explode(';', $sql_content);

                        // Loop through each query and execute it
                        $force_count_all = 0;
                        $force_count_failed = 0;
                        foreach ($sql_queries as $sql_query) {

                            $force_count_all++;

                            try {
                                // Skip empty queries
                                if (trim($sql_query) === '') {
                                    continue;
                                }

                                // Execute the query
                                DB::connection('tenant')->unprepared($sql_query);

                            } catch (\Exception $e) {
                                $force_count_failed++;
                            }
                        }

                        //update tenant record (in landlord db)
                        $customer->tenant_updating_status = 'completed';
                        $customer->tenant_updating_current_version = $target_system_version;
                        $customer->save();

                        //log this event
                        $log = new \App\Models\Landlord\Updatelog();
                        $log->setConnection('landlord');
                        $log->updateslog_tenant_id = $customer->tenant_id;
                        $log->updateslog_tenant_database = $customer->database;
                        $log->updateslog_current_version = $customer->tenant_updating_current_version;
                        $log->updateslog_target_version = $target_system_version;
                        $log->updateslog_status = 'completed';
                        $log->save();

                        //log
                        Log::critical("[forced tenant sql update] [info]: tenant database (" . $tenant->database . ") - total queries ($force_count_all) - failed queries($force_count_failed)", ['process' => '[permissions]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);

                    } else {

                        //EXECUTE THE WHOLE FILE. THIS WILL STOP ON ERRORS
                        DB::connection('tenant')->unprepared(file_get_contents($filepath));

                        //forget tenant
                        \Spatie\Multitenancy\Models\Tenant::forgetCurrent();

                        $count_passed++;

                        //update tenant record (in landlord db)
                        $customer->tenant_updating_status = 'completed';
                        $customer->tenant_updating_current_version = $target_system_version;
                        $customer->save();

                        //log this event
                        $log = new \App\Models\Landlord\Updatelog();
                        $log->setConnection('landlord');
                        $log->updateslog_tenant_id = $customer->tenant_id;
                        $log->updateslog_tenant_database = $customer->database;
                        $log->updateslog_current_version = $customer->tenant_updating_current_version;
                        $log->updateslog_target_version = $target_system_version;
                        $log->updateslog_status = 'completed';
                        $log->save();

                        Log::info("updating database for tenant id (" . $customer->tenant_id . ") - domain (" . $customer->domain . ") - to version ($target_system_version) completed", ['process' => '[update-tenant-databases]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
                    }

                } catch (Exception $e) {

                    //update tenant record (in landlord db)
                    $customer->tenant_updating_status = 'failed';
                    $customer->tenant_updating_log = $e->getMessage();
                    $customer->save();

                    //log this error
                    $log = new \App\Models\Landlord\Updatelog();
                    $log->setConnection('landlord');
                    $log->updateslog_tenant_id = $customer->tenant_id;
                    $log->updateslog_tenant_database = $customer->database;
                    $log->updateslog_current_version = $customer->tenant_updating_current_version;
                    $log->updateslog_target_version = $target_system_version;
                    $log->updateslog_status = 'failed';
                    $log->updateslog_notes = $e->getMessage();
                    $log->save();

                    $count_failed++;
                    Log::error("updating database for tenant id (" . $customer->tenant_id . ") - domain (" . $customer->domain . ") - failed - see crm log table", ['process' => '[update-tenant-databases]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
                }
            }

        }

        Log::info("tenants updating process has finshed. passed ($count_passed) - failed ($count_failed)", ['process' => '[update-tenant-databases]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);

    }

}