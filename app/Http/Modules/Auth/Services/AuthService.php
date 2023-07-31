<?php

namespace App\Http\Modules\Auth\Services;

use App\Http\Modules\Auth\Requests\LoginRequest;
use App\Http\Modules\Users\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function __construct()
    {
    }

    /**
     * Function to login a user.
     *
     * @param LoginRequest $request
     * @return Array
     */
    public function login(LoginRequest $request): array
    {
        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            $token = $user->createToken('Laravel')->accessToken;

            return [
                'res' => true,
                'message' => 'Usuario logeado con éxito',
                'data' => [
                    'token' => $token,
                    'user' => $user,
                    'tenant' => tenancy()
                ],
                'code' => Response::HTTP_OK,
            ];
        } else {
            return [
                'res' => false,
                'message' => 'Credenciales incorrectas',
                'code' => Response::HTTP_UNAUTHORIZED,
            ];
        }
    }

    /**
     * Function to logout user.
     *
     * @param Request $request
     * @return Array
     */
    public function logout(Request $request) //: array
    {
        //Obtenemos usuario logeado
        $user = Auth::user();
        //Busca todos los token del usuario en la base de datos y los eliminamos;
        $user->tokens->each(function ($token) {
            $token->delete();
        });
        return response()->json([
            'res' => true,
            'message' => 'Hasta la vista Baby',
        ], 200);
    }
}
