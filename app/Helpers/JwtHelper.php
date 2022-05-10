<?php 

namespace App\Helpers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class JwtHelper{

    public static function authenticate(Request $request){

        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
        }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));
    }

    public static function getAuthenticatedUser(){

        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) 
                return response()->json(['user_not_found'], 404);

        } catch (TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }

        return response()->json(compact('user'));
    }

}