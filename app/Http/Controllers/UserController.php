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
     
        $query = User::query();

        if($request->has('nombre')){
            $nombreFilter = $request->input('nombre');
            $query->where('nombre', 'like', '%'. $nombreFilter .'%');
        }

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
        
    }
 
    public function create()
    {
        $roles = Role::all();
        return Inertia::render('User/Create', [
            'roles' => $roles,
        ]);

    }

 
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:users|max:100',
            'email' => 'required|unique:users|email',
            'password' => 'required',
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($request->input('password'));
    
        User::create($data);

        return redirect()->route('users.index')->with('message', 'Usuario creado');
    }

    public function show($id)
    {   
        $user = User::find($id);

        $data = [
            $user,
        ];

        return Inertia::render('User/Show', 
            ['data' => $data]    
        );
    }

    public function edit(User $user)
    {
        $roles = Role::all();

        return Inertia::render('User/Edit', [
            'user' => $user,
            'roles' => $roles,
        ]);
    }

 
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|unique:users|max:100',
            'email' => 'required|unique:users',
            'password' => 'required',
        ]);

        if ($request->has('password')){
            $request->merge(['password' => Hash::make($request->input('password'))]);
        }

        $user->update($request->all());

        return redirect()->route('users.index')->with('message', 'Usuario actualizado');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect()->route('users.index');
    }
}
