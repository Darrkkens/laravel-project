<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Cria o usuário administrador padrão da primeira instalação.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@salas.com'],
            [
                'name' => 'Administrador',
                'password' => '123456',
                'perfil' => 'admin',
            ]
        );
    }
}
