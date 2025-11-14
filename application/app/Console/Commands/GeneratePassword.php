<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class GeneratePassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'password:generate {password?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genera un hash de contraseña para usar en la base de datos';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $password = $this->argument('password');

        // Si no se proporciona contraseña, generar una aleatoria
        if (!$password) {
            $password = $this->generateRandomPassword();
            $this->info('Contraseña generada automáticamente: ' . $password);
        }

        // Generar el hash
        $hashedPassword = Hash::make($password);

        // Mostrar resultados
        $this->newLine();
        $this->info('═══════════════════════════════════════════════════════');
        $this->info('Hash de contraseña generado:');
        $this->info('═══════════════════════════════════════════════════════');
        $this->line('');
        $this->line('Contraseña original: ' . $password);
        $this->line('');
        $this->line('Hash (para base de datos):');
        $this->line($hashedPassword);
        $this->line('');
        $this->info('═══════════════════════════════════════════════════════');

        return Command::SUCCESS;
    }

    /**
     * Genera una contraseña aleatoria segura
     *
     * @return string
     */
    private function generateRandomPassword($length = 16)
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*';
        $password = '';
        $max = strlen($characters) - 1;

        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[random_int(0, $max)];
        }

        return $password;
    }
}

