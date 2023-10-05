<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class RoleSeeder extends Seeder
{
 
    public function run(): void
    {
        $role1 = Role::create(['name' => 'Administrador']);
        $role2 = Role::create(['name' => 'Practicante']);

        Permission::create(['name' => 'dashboard'])->syncRoles([$role1, $role2]);

        Permission::create(['name' => 'user.index'])->syncRoles([$role1]);
        Permission::create(['name' => 'user.create'])->syncRoles([$role1]);
        Permission::create(['name' => 'user.edit'])->syncRoles([$role1]);
        Permission::create(['name' => 'user.destroy'])->syncRoles([$role1]);

        Permission::create(['name' => 'dependencia.index'])->syncRoles([$role1]);
        Permission::create(['name' => 'dependencia.create'])->syncRoles([$role1]);
        Permission::create(['name' => 'dependencia.edit'])->syncRoles([$role1]);
        Permission::create(['name' => 'dependencia.destroy'])->syncRoles([$role1]);

        Permission::create(['name' => 'incidencia.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'incidencia.create'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'incidencia.edit'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'incidencia.destroy'])->syncRoles([$role1, $role2]);

        Permission::create(['name' => 'tipo-problema.index'])->syncRoles([$role1]);
        Permission::create(['name' => 'tipo-problema.create'])->syncRoles([$role1]);
        Permission::create(['name' => 'tipo-problema.edit'])->syncRoles([$role1]);
        Permission::create(['name' => 'tipo-problema.destroy'])->syncRoles([$role1]);

        Permission::create(['name' => 'tipo-solucion.index'])->syncRoles([$role1]);
        Permission::create(['name' => 'tipo-solucion.create'])->syncRoles([$role1]);
        Permission::create(['name' => 'tipo-solucion.edit'])->syncRoles([$role1]);
        Permission::create(['name' => 'tipo-solucion.destroy'])->syncRoles([$role1]);

        Permission::create(['name' => 'sede.index'])->syncRoles([$role1]);
        Permission::create(['name' => 'sede.create'])->syncRoles([$role1]);
        Permission::create(['name' => 'sede.edit'])->syncRoles([$role1]);
        Permission::create(['name' => 'sede.destroy'])->syncRoles([$role1]);

        Permission::create(['name' => 'oficina.index'])->syncRoles([$role1]);
        Permission::create(['name' => 'oficina.create'])->syncRoles([$role1]);
        Permission::create(['name' => 'oficina.edit'])->syncRoles([$role1]);
        Permission::create(['name' => 'oficina.destroy'])->syncRoles([$role1]);

        Permission::create(['name' => 'solucion.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'solucion.create'])->syncRoles([$role1]);
        Permission::create(['name' => 'solucion.edit'])->syncRoles([$role1]);
        Permission::create(['name' => 'solucion.destroy'])->syncRoles([$role1]);
    }
}
