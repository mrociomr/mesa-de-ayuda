<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;

class VerificateController extends Controller
{
    //
    public function index(Request $request)
    {
        $user = Auth::user();

        // Obtener roles y permisos del usuario
        //$userRoles = $user->getRoleNames();
        //$userPermissions = $user->getAllPermissions()->toArray(); // Convierte a una matriz

        return [
            //'userRoles' => $userRoles,
            //'userPermissions' => $userPermissions,
        ];
    }


}
