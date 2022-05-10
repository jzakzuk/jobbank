<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Helpers\JwtHelper;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class UserController extends Controller
{

    /**
    * @OA\Post(
    *     path="/api/login",
    *     summary="Autenticar usuarios",
    *     @OA\Parameter(
    *         name="email",
    *         in="query",
    *         description="user email",
    *         required=true,
    *     ),
    *     @OA\Parameter(
    *         name="password",
    *         in="query",
    *         description="user password",
    *         required=true,
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Retorna el token jwt."
    *     ),
    *     @OA\Response(
    *         response=400,
    *         description="Credenciales invalidas."
    *     ),
    *     @OA\Response(
    *         response=500,
    *         description="Error desconocido."
    *     )
    * )
    */
    public function login( request $request ){
        return JwtHelper::authenticate($request);
    }

    /**
    * @OA\Post(
    *     path="/api/users/create",
    *     summary="Crear usuarios",
    *     @OA\Parameter(
    *         name="name",
    *         in="query",
    *         description="nombre del usuario",
    *         required=true,
    *     ),
    *     @OA\Parameter(
    *         name="email",
    *         in="query",
    *         description="email del usuario",
    *         required=true,
    *     ),
    *     @OA\Parameter(
    *         name="document",
    *         in="query",
    *         description="Numero de documento del usuario",
    *         required=true,
    *     ),
    *     @OA\Parameter(
    *         name="doc_type_id",
    *         in="query",
    *         description="Tipo de documento del usuario",
    *         required=true,
    *     ),
    *     @OA\Response(
    *         response=201,
    *         description="Retorna el usuario creado."
    *     ),
    *     @OA\Response(
    *         response=400,
    *         description="Parametros invalidas."
    *     ),
    *     @OA\Response(
    *         response=500,
    *         description="Error desconocido."
    *     ),
    *     security={
    *         {
    *             "bearerAuth": {},
    *         }
    *     },
    * )
    */
    public function create( Request $request ){

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'document' => 'required|unique:users',
            'doc_type_id' => 'required',
        ]);

        if($validator->fails()) return response()->json($validator->errors()->toJson(), 400);

        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'document' => $request->get('document'),
            'doc_type_id' => $request->get('doc_type_id'),
            'password' => Hash::make($request->get('document')),
        ]);

        return response()->json(compact('user'),201);

    }


}
