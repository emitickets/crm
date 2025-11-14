<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Settings;
use App\Models\User;
use App\Models\Role;

class DiagnoseLeadsMenu extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'leads:diagnose-menu {user_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Diagnostica por qué el menú de Leads no aparece en el sidebar';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('=== DIAGNÓSTICO DEL MENÚ DE LEADS ===');
        $this->newLine();

        // Cargar configuración del sistema (simula BootSystem middleware)
        if (env('SETUP_STATUS') == 'COMPLETED') {
            if (function_exists('middlewareBootSettings')) {
                middlewareBootSettings();
                $this->line('   ✅ Configuración del sistema cargada');
            }
        }

        // 1. Verificar configuración del módulo en la base de datos
        $this->info('1. Verificando configuración del módulo...');
        $settings = Settings::find(1);
        
        if (!$settings) {
            $this->error('   ❌ No se encontró la configuración en la base de datos');
            return 1;
        }

        $moduleEnabled = $settings->settings_modules_leads ?? 'not_set';
        $this->line("   Módulo Leads en BD: {$moduleEnabled}");
        
        if ($moduleEnabled === 'enabled') {
            $this->info('   ✅ El módulo está habilitado en la base de datos');
        } else {
            $this->error('   ❌ El módulo NO está habilitado en la base de datos');
            $this->warn('   → Solución: Ve a Configuración > Módulos y habilita "Leads"');
        }
        $this->newLine();

        // 2. Verificar configuración del módulo en config (simula Status middleware)
        $this->info('2. Verificando configuración del módulo en config...');
        
        // Simular la lógica del middleware Status
        $systemModuleValue = config('system.settings_modules_leads');
        $this->line("   config('system.settings_modules_leads'): " . ($systemModuleValue ?? 'null'));
        
        // Aplicar la lógica del middleware Status
        $configModule = false;
        if ($systemModuleValue && $systemModuleValue == 'enabled') {
            $configModule = true;
            config(['modules.leads' => true]);
        }
        
        $this->line("   config('modules.leads'): " . ($configModule ? 'true' : 'false'));
        
        if ($configModule) {
            $this->info('   ✅ El módulo está habilitado en la configuración');
        } else {
            $this->error('   ❌ El módulo NO está habilitado en la configuración');
            if (!$systemModuleValue) {
                $this->warn('   → La configuración del sistema no está cargada (middleware BootSystem)');
            } elseif ($systemModuleValue != 'enabled') {
                $this->warn('   → El valor en config es: ' . $systemModuleValue . ' (debe ser "enabled")');
            }
        }
        $this->newLine();

        // 3. Verificar usuario y permisos
        $userId = $this->argument('user_id');
        
        if ($userId) {
            $user = User::with('role')->find($userId);
            
            if (!$user) {
                $this->error("   ❌ No se encontró el usuario con ID: {$userId}");
                return 1;
            }
        } else {
            // Obtener el primer usuario del equipo
            $user = User::with('role')->where('type', 'team')->first();
            
            if (!$user) {
                $this->error('   ❌ No se encontró ningún usuario del equipo');
                return 1;
            }
            
            $this->warn("   Usando el primer usuario del equipo encontrado (ID: {$user->id})");
        }

        $this->info("3. Verificando usuario: {$user->firstname} {$user->lastname} (ID: {$user->id})");
        $this->line("   Tipo de usuario: {$user->type}");
        
        if ($user->is_team) {
            $this->info('   ✅ El usuario es del equipo');
        } else {
            $this->error('   ❌ El usuario NO es del equipo');
            $this->warn('   → Solo los usuarios del equipo pueden ver el menú de Leads');
            return 1;
        }
        $this->newLine();

        // 4. Verificar rol y permisos
        $this->info('4. Verificando permisos del rol...');
        
        if (!$user->role) {
            $this->error('   ❌ El usuario no tiene un rol asignado');
            return 1;
        }

        $this->line("   Rol: {$user->role->role_name} (ID: {$user->role->role_id})");
        $roleLeads = $user->role->role_leads ?? null;
        $this->line("   role_leads: " . ($roleLeads !== null ? $roleLeads : 'null'));
        
        if ($roleLeads >= 1) {
            $this->info('   ✅ El usuario tiene permisos para ver Leads (role_leads >= 1)');
        } else {
            $this->error('   ❌ El usuario NO tiene permisos para ver Leads (role_leads < 1)');
            $this->warn('   → Solución: Ve a Configuración > Roles y permisos y asigna permisos de Leads');
        }
        $this->newLine();

        // 5. Verificar visibilidad final
        $this->info('5. Verificando visibilidad final...');
        
        // Simular la lógica del middleware Visibility
        $visibilityLeads = false;
        if ($user->is_team && $user->role->role_leads >= 1 && config('modules.leads')) {
            $visibilityLeads = true;
        }
        
        $this->line("   config('visibility.modules.leads'): " . ($visibilityLeads ? 'true' : 'false'));
        
        if ($visibilityLeads) {
            $this->info('   ✅ El menú de Leads DEBERÍA estar visible');
        } else {
            $this->error('   ❌ El menú de Leads NO debería estar visible');
            $this->newLine();
            $this->warn('   RESUMEN DE PROBLEMAS:');
            if ($moduleEnabled !== 'enabled') {
                $this->line('   - Módulo deshabilitado en la base de datos');
            }
            if (!$configModule) {
                $this->line('   - Módulo no configurado correctamente');
            }
            if (!$user->is_team) {
                $this->line('   - Usuario no es del equipo');
            }
            if ($roleLeads < 1) {
                $this->line('   - Usuario no tiene permisos (role_leads < 1)');
            }
        }
        $this->newLine();

        // 6. Recomendaciones
        $this->info('6. Recomendaciones:');
        $this->line('   - Verifica que el middleware Modules\Visibility esté registrado en bootstrap/app.php o Kernel.php');
        $this->line('   - Verifica que el middleware Modules\Status esté registrado');
        $this->line('   - Limpia la caché: php artisan config:clear && php artisan cache:clear');
        $this->line('   - Recarga la página después de hacer cambios');
        $this->newLine();

        return 0;
    }
}

