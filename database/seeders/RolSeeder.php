<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rol1 = Role::create(["name" => 'Super Usuario']);

        /*Permission::create(["name" => "usuario.index", "description" => "Ver registros de todos los usuarios", "module" => "Usuarios"])->assignRole($rol1);
        Permission::create(["name" => "usuario.create", "description" => "Crear usuario", "module" => "Usuarios"])->assignRole($rol1);
        Permission::create(["name" => "usuario.destroy", "description" => "Eliminar usuario", "module" => "Usuarios"])->assignRole($rol1);
        Permission::create(["name" => "usuario.edit", "description" => "Editar usuario", "module" => "Usuarios"])->assignRole($rol1);

        Permission::create(["name" => "rol.index", "description" => "Ver registros de todos los roles", "module" => "Roles"])->assignRole($rol1);
        Permission::create(["name" => "rol.create", "description" => "Crear rol", "module" => "Roles"])->assignRole($rol1);
        Permission::create(["name" => "rol.destroy", "description" => "Eliminar rol", "module" => "Roles"])->assignRole($rol1);
        Permission::create(["name" => "rol.edit", "description" => "Editar rol", "module" => "Roles"])->assignRole($rol1);*/
    }
}
