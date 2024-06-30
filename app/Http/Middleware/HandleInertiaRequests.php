<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Session;
use App\Models\Oficina;


class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */

    public function share(Request $request): array
    {

        // Obtén el usuario autenticado
        $user = auth()->user();

        // Verifica si el usuario existe y si no es una instancia de "Oficina"
        if ($user && !($user instanceof Oficina)) {
            // Aquí puedes realizar acciones que no se aplicarán a usuarios autenticados como "Oficina"
            $userRoles = $user->getRoleNames();
            $userPermissions = $user ? $user->getPermissionsViaRoles() : [];

            // Resto del código
        }

        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $user,
                'roles' => $userRoles ?? [],
                'permissions' => $userPermissions ?? [],

            ],
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                ]);
            },

            'flash' => function () use ($request) {
                return [
                    'mesActual' => Session::get('mesActual'),
                ];
            },
        ]);
    }
}
