<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->can('user.index')) {


            $query = User::query();

            if ($request->has('nombre')) {
                $nombreFilter = $request->input('nombre');
                $query->where('nombre', 'like', '%' . $nombreFilter . '%');
            }

            $query->where('id', '>', 1);

            $user = $query->get();

            $tableColumns = [
                ['key' => 'id', 'label' => 'ID'],
                ['key' => 'name', 'label' => 'Nombre'],
                ['key' => 'email', 'label' => 'Email'],
                ['key' => 'role_id', 'label' => 'Rol']
            ];

            return Inertia::render('User/Table', [
                'tableColumns' => $tableColumns,
                'user' => $user,
            ]);
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function create()
    {
        if (Auth::user()->can('user.create')) {

            $roles = Role::all();
            return Inertia::render('User/Create', [
                'roles' => $roles,
            ]);
        } else {
            return redirect()->route('dashboard');
        }

    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:users|max:100',
            'email' => 'required|unique:users|email',
            'password' => 'required',
        ]);

        $rolName = $request->input('rolName');

        $data = $request->all();
        $data['password'] = Hash::make($request->input('password'));

        $user = User::create($data);
        $role = Role::where('name', $rolName)->first();

        $user->assignRole($role);

        return redirect()->route('users.index')->with('message', 'Usuario creado');
    }

    public function show($id)
    {
        $user = User::find($id);

        $data = [
            $user,
        ];

        return Inertia::render(
            'User/Show',
            ['data' => $data]
        );
    }

    public function edit(User $user)
    {
        if (Auth::user()->can('user.edit')) {
            $roles = Role::all();
            $userRoles = $user->getRoleNames();

            if ($user->id == 1) {
                return redirect()->back()->with('error', 'No se permite editar al usuario con ID 1.');
            }
            
            return Inertia::render('User/Edit', [
                'user' => $user,
                'roles' => $roles,
                'userRoles' => $userRoles,

            ]);
        } else {
            return redirect()->route('dashboard');
        }
    }


    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|max:100|unique:users,name,' . $user->id,
            'email' => 'required|unique:users,email,' . $user->id,
        ]);

        $rolName = $request->input('rolName');

        if ($request->has('password')) {
            $request->merge(['password' => Hash::make($request->input('password'))]);
        } else {
            $request->offsetUnset('password'); // Elimina el campo de contraseña de la solicitud si no se proporciona.
        }

        $user->update($request->all());

        $role = Role::where('name', $rolName)->first();

        $user->syncRoles($role); // Utiliza syncRoles para asignar el rol al usuario (reemplaza los roles existentes).

        return redirect()->route('users.index')->with('message', 'Usuario actualizado');
    }

    public function destroy($id)
    {
        if (Auth::user()->can('user.destroy')) {
            $user = User::find($id);
            $user->delete();
            return redirect()->route('users.index');
        } else {
            return redirect()->route('dashboard');
        }
    }
}
