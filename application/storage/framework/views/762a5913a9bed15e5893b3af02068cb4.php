
<?php $__env->startSection('settings_content'); ?>

<!--form-->
<div class="card">
    <div class="card-body" id="landlord-settings-form">

        <!--settings-->
        <form class="form">
            <!--form text tem-->
            <div class="form-group row">
                <label class="col-12 control-label col-form-label"><?php echo e(cleanLang(__('lang.cron_job_command'))); ?>

                    &nbsp; ( 1 )</label>
                <div class="col-12">
                    <input type="text" class="form-control form-control-sm" id="settings_company_name"
                        name="settings_company_name" value="<?php echo e(config('cronjob_path')); ?>">
                </div>
            </div>

            <!--form text tem-->
            <div class="form-group row">
                <label class="col-12 control-label col-form-label"><?php echo e(cleanLang(__('lang.cron_job_command'))); ?>

                    &nbsp; ( 2 )</label>
                <div class="col-12">
                    <input type="text" class="form-control form-control-sm" id="settings_company_name"
                        name="settings_company_name" value="<?php echo e(config('cronjob_path_2')); ?>">
                </div>
            </div>

            <!--instructions-->
            <?php if(config('system.settings_cronjob_has_run') == 'no' ||
            config('system.settings_cronjob_has_run_tenants') == 'no'): ?>
            <div id="fx-settings-cronjob-instructions">
                <?php echo e(cleanLang(__('lang.cronjob_instructions_saas'))); ?>

            </div>
            <div id="fx-settings-cronjob-instructions">
                <?php echo e(cleanLang(__('lang.cron_jobs_info'))); ?>

            </div>
            <?php endif; ?>

            <!--cronjob (1) has run-->
            <?php if(config('system.settings_cronjob_has_run') == 'yes'): ?>
            <div class="alert alert-info">
                <h4 class="text-info"><?php echo app('translator')->get('lang.cronjob'); ?> ( 1 ) - <?php echo app('translator')->get('lang.active'); ?></h4>
                <?php echo e(cleanLang(__('lang.cronjob_last_executed'))); ?>:
                (<?php echo e(runtimeDateAgo(config('system.settings_cronjob_last_run'))); ?>)
            </div>
            <?php endif; ?>



            <!--cronjob (1) has not run-->
            <?php if(config('system.settings_cronjob_has_run') == 'no'): ?>
            <div class="alert alert-danger">
                <h4 class="text-danger"><?php echo app('translator')->get('lang.cronjob'); ?> ( 1 ) - <?php echo app('translator')->get('lang.status'); ?></h4>
                <?php echo e(cleanLang(__('lang.cronjob_inactive_saas'))); ?>

            </div>
            <?php endif; ?>



            <!--cronjob (2) has not run-->
            <?php if(config('system.settings_cronjob_has_run_tenants') == 'no'): ?>
            <div class="alert alert-danger">
                <h4 class="text-danger"><?php echo app('translator')->get('lang.cronjob'); ?> ( 2 ) - <?php echo app('translator')->get('lang.status'); ?></h4>
                <?php echo e(cleanLang(__('lang.cronjob_inactive_saas'))); ?>

            </div>
            <?php endif; ?>

            <!--cronjob (2) has run-->
            <?php if(config('system.settings_cronjob_has_run_tenants') == 'yes'): ?>
            <div class="alert alert-info">
                <h4 class="text-info"><?php echo app('translator')->get('lang.cronjob'); ?> ( 2 ) - <?php echo app('translator')->get('lang.active'); ?></h4>
                <?php echo e(cleanLang(__('lang.cronjob_last_executed'))); ?>:
                (<?php echo e(runtimeDateAgo(config('system.settings_cronjob_last_run_tenants'))); ?>)
            </div>
            <?php endif; ?>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('landlord.settings.wrapper', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/gilberto/Development/crm/grow/application/resources/views/landlord/settings/sections/cronjob/page.blade.php ENDPATH**/ ?>