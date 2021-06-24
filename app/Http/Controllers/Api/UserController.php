<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{

    /**
     * Authenticate User by email, and return Api Token
     * 
     * @param Request $request
     * @return type
     */
    public function index(Request $request)
    {

        /**
         * fetch user for requested email
         */
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'message' => ['The provided credentials are incorrect.'],
            ], '404');
        }

        $token = $user->createToken('my_api_token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }
}
