<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Multitenancy\Tenant;
use App\Models\Landlord\Package;
use App\Models\Landlord\Subscription;
use Illuminate\Support\Facades\DB;

class SyncPackageModules extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'package:sync-modules 
                            {--tenant_id= : ID del tenant a sincronizar}
                            {--package_id= : ID del paquete (opcional, si no se especifica usa el paquete actual del tenant)}
                            {--all : Sincronizar todos los tenants}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sincroniza los módulos de un paquete con la base de datos del tenant';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('=== SINCRONIZACIÓN DE MÓDULOS DE PAQUETES ===');
        $this->newLine();

        // Si se especifica --all, sincronizar todos los tenants
        if ($this->option('all')) {
            return $this->syncAllTenants();
        }

        // Obtener tenant_id
        $tenantId = $this->option('tenant_id');
        
        if (!$tenantId) {
            $this->error('   ❌ Debes especificar --tenant_id=<id> o usar --all para sincronizar todos');
            $this->warn('   Ejemplo: php artisan package:sync-modules --tenant_id=1');
            return 1;
        }

        // Obtener el tenant desde la base de datos landlord
        $tenant = Tenant::on('landlord')->where('tenant_id', $tenantId)->first();
        
        if (!$tenant) {
            $this->error("   ❌ No se encontró el tenant con ID: {$tenantId}");
            return 1;
        }

        $this->line("   Tenant: {$tenant->tenant_name} (ID: {$tenant->tenant_id})");

        // Obtener el paquete
        $packageId = $this->option('package_id');
        
        if ($packageId) {
            // Usar el paquete especificado
            $package = Package::on('landlord')->where('package_id', $packageId)->first();
            
            if (!$package) {
                $this->error("   ❌ No se encontró el paquete con ID: {$packageId}");
                return 1;
            }
            
            $this->line("   Usando paquete especificado: {$package->package_name} (ID: {$package->package_id})");
        } else {
            // Obtener el paquete del tenant desde la suscripción
            $subscription = Subscription::on('landlord')
                ->where('subscription_customerid', $tenantId)
                ->where('subscription_archived', 'no')
                ->first();
            
            if (!$subscription) {
                $this->error("   ❌ El tenant no tiene una suscripción activa");
                $this->warn("   → Usa --package_id=<id> para especificar un paquete manualmente");
                return 1;
            }
            
            $package = Package::on('landlord')->where('package_id', $subscription->subscription_package_id)->first();
            
            if (!$package) {
                $this->error("   ❌ No se encontró el paquete de la suscripción (ID: {$subscription->subscription_package_id})");
                return 1;
            }
            
            $this->line("   Paquete del tenant: {$package->package_name} (ID: {$package->package_id})");
        }

        // Sincronizar módulos
        return $this->syncModules($tenant, $package);
    }

    /**
     * Sincroniza los módulos de un paquete con un tenant
     */
    private function syncModules($tenant, $package)
    {
        $this->newLine();
        $this->info('   Sincronizando módulos...');

        try {
            // Hacer el tenant actual
            Tenant::forgetCurrent();
            $tenant->makeCurrent();

            // Preparar los datos de actualización
            $updates = [
                'settings_saas_package_id' => $package->package_id,
                'settings_modules_projects' => ($package->package_module_projects == 'yes') ? 'enabled' : 'disabled',
                'settings_modules_tasks' => ($package->package_module_tasks == 'yes') ? 'enabled' : 'disabled',
                'settings_modules_invoices' => ($package->package_module_invoices == 'yes') ? 'enabled' : 'disabled',
                'settings_modules_leads' => ($package->package_module_leads == 'yes') ? 'enabled' : 'disabled',
                'settings_modules_knowledgebase' => ($package->package_module_knowledgebase == 'yes') ? 'enabled' : 'disabled',
                'settings_modules_estimates' => ($package->package_module_estimates == 'yes') ? 'enabled' : 'disabled',
                'settings_modules_expenses' => ($package->package_module_expense == 'yes') ? 'enabled' : 'disabled',
                'settings_modules_subscriptions' => ($package->package_module_subscriptions == 'yes') ? 'enabled' : 'disabled',
                'settings_modules_tickets' => ($package->package_module_tickets == 'yes') ? 'enabled' : 'disabled',
                'settings_modules_calendar' => ($package->package_module_calendar == 'yes') ? 'enabled' : 'disabled',
                'settings_modules_timetracking' => ($package->package_module_timetracking == 'yes') ? 'enabled' : 'disabled',
                'settings_modules_reminders' => ($package->package_module_reminders == 'yes') ? 'enabled' : 'disabled',
                'settings_modules_proposals' => ($package->package_module_proposals == 'yes') ? 'enabled' : 'disabled',
                'settings_modules_contracts' => ($package->package_module_contracts == 'yes') ? 'enabled' : 'disabled',
                'settings_modules_messages' => ($package->package_module_messages == 'yes') ? 'enabled' : 'disabled',
            ];

            // Actualizar en la base de datos del tenant
            $updated = DB::connection('tenant')
                ->table('settings')
                ->where('settings_id', 1)
                ->update($updates);

            if ($updated) {
                $this->info('   ✅ Módulos sincronizados correctamente');
                $this->newLine();
                
                // Mostrar resumen de módulos habilitados
                $this->line('   Módulos habilitados:');
                $enabledModules = [];
                foreach ($updates as $key => $value) {
                    if (strpos($key, 'settings_modules_') === 0 && $value === 'enabled') {
                        $moduleName = str_replace('settings_modules_', '', $key);
                        $enabledModules[] = $moduleName;
                    }
                }
                
                if (empty($enabledModules)) {
                    $this->warn('      Ningún módulo habilitado');
                } else {
                    foreach ($enabledModules as $module) {
                        $this->line("      - {$module}");
                    }
                }
                
                // Verificar específicamente Leads
                if ($updates['settings_modules_leads'] === 'enabled') {
                    $this->info('   ✅ Módulo Leads está HABILITADO');
                } else {
                    $this->warn('   ⚠️  Módulo Leads está DESHABILITADO');
                }
                
                return 0;
            } else {
                $this->error('   ❌ No se pudo actualizar la configuración');
                return 1;
            }

        } catch (\Exception $e) {
            $this->error('   ❌ Error al sincronizar: ' . $e->getMessage());
            return 1;
        } finally {
            // Olvidar el tenant actual
            Tenant::forgetCurrent();
        }
    }

    /**
     * Sincroniza todos los tenants
     */
    private function syncAllTenants()
    {
        $this->info('   Sincronizando todos los tenants...');
        $this->newLine();

        $tenants = Tenant::on('landlord')->get();
        
        if ($tenants->isEmpty()) {
            $this->error('   ❌ No se encontraron tenants');
            return 1;
        }

        $this->line("   Se encontraron {$tenants->count()} tenant(s)");
        $this->newLine();

        $successCount = 0;
        $errorCount = 0;

        foreach ($tenants as $tenant) {
            $this->line("   Procesando: {$tenant->tenant_name} (ID: {$tenant->tenant_id})");
            
            // Obtener la suscripción del tenant
            $subscription = Subscription::on('landlord')
                ->where('subscription_customerid', $tenant->tenant_id)
                ->where('subscription_archived', 'no')
                ->first();
            
            if (!$subscription) {
                $this->warn("      ⚠️  Sin suscripción activa, saltando...");
                $errorCount++;
                continue;
            }
            
            $package = Package::on('landlord')->where('package_id', $subscription->subscription_package_id)->first();
            
            if (!$package) {
                $this->warn("      ⚠️  Paquete no encontrado, saltando...");
                $errorCount++;
                continue;
            }
            
            if ($this->syncModules($tenant, $package) === 0) {
                $successCount++;
            } else {
                $errorCount++;
            }
            
            $this->newLine();
        }

        $this->info("=== RESUMEN ===");
        $this->line("   ✅ Exitosos: {$successCount}");
        $this->line("   ❌ Errores: {$errorCount}");
        $this->line("   📊 Total: {$tenants->count()}");

        return $errorCount > 0 ? 1 : 0;
    }
}

