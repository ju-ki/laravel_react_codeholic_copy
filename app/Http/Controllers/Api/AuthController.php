<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignupRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credential = $request->validated();
        if (!Auth::attempt($credential)) {
            return response([
                "message" => "Provided email address or password is incorrect"
            ]);
        }

        $user = Auth::user();
        $token = $user->createToken("main")->plainTextToken;
        return response(compact("user", "token"));
    }


    public function signup(SignupRequest $request)
    {
        dd("something");
        $data = $request->validated();
        $user = User::create([
            "name" => $data["name"],
            "email" => $data["email"],
            "password" => bcrypt($data["password"]),

        ]);

        $token = $user->createToken("main")->plainTextToken;
        return response(compact("user", "token"));
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();
        return response('', 204);
    }
}
