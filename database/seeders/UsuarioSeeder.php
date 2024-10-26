<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            "name" => "Administrador",
            "email" => "admin@admin.com",
            "cargo" => "Administrador",
            "telefono" => "0",
            "estado" => "Operativo",
            "admin_maestro" => true,
            "password" => "123",
        ]);
    }
}
