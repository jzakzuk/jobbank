<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobOffer as JobOfferModel;
use Illuminate\Support\Facades\Validator;

class JobOfferController extends Controller
{

    /**
    * @OA\Get(
    *     path="/api/job-offers",
    *     summary="Listado de ofertas con sus usuarios asociados, retorna solo las ofertas que tienen usuarios asociados",
    *     @OA\Response(
    *         response=200,
    *         description="Retorna el listado de ofertas d etrabajo."
    *     ),
    *     @OA\Response(
    *         response=401,
    *         description="No autorizado."
    *     ),
    *     security={
    *         {
    *             "bearerAuth": {},
    *         }
    *     },
    * )
    */
    public function list(){

        $offers =  JobOfferModel::has('users')->with('users')->get();
        return response()->json(compact('offers'),200);

    }

    /**
    * @OA\Post(
    *     path="/api/job-offers/create",
    *     summary="Crear ofertas de empleo",
    *     @OA\Parameter(
    *         name="name",
    *         in="query",
    *         description="nombre de la oferta de empleo",
    *         required=true,
    *     ),
    *     @OA\Parameter(
    *         name="status",
    *         in="query",
    *         description="Estado de la oferta 0=inactiva, 1=Activa",
    *         required=true,
    *     ),
    *     @OA\Parameter(
    *         name="users[]",
    *         in="query",
    *         description="Listado de Ids de usuarios existentes",
    *         required=true,
    *           @OA\Schema( 
    *              type="array", 
    *              @OA\Items(type="enum", enum={1,2,3}),
    *              example={1,2} 
    *          )
    *     ),
    *     @OA\Response(
    *         response=201,
    *         description="La oferta fue creada."
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
            'name' => 'required',
            'status' => 'required',
            'users' => 'required|array|min:1',
        ]);

        if($validator->fails()) return response()->json($validator->errors()->toJson(), 400);

        $offer = JobOfferModel::create([
            'name' => $request->get('name'),
            'status' => $request->get('status'),
        ]);

        $users = $request->users;

        $offer->users()->attach($users);

        return response()->json(compact('offer'),201);

    }
}
