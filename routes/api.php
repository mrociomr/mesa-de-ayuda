<?php

use App\Http\Controllers\VerificateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware(['auth:sanctum'])->group(function () {

});


// Route::middleware('auth:sanctum')->get('/user/permissions', function (Request $request) {
//     $user = $request->user();
//     $roles = $user->getRoleNames();
//     $permissions = $user->getAllPermissions()->pluck('name');
//     return response()->json([
//         'roles' => $roles,
//         'permissions' => $permissions,
//     ]);
// });
