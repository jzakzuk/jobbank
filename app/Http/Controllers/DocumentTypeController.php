<?php

namespace App\Http\Controllers;

use App\Models\DocumentType;
use App\Models\JobOffer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;



class DocumentTypeController extends Controller
{

    /**
    * @OA\Get(
    *     path="/api/document-types",
    *     summary="Listado de tipos de documentos",
    *     @OA\Response(
    *         response=200,
    *         description="Retorna el listado d edocumentos."
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
        $documents =  DocumentType::all();
        return response()->json(compact('documents'),200);
    }

    /**
    *
    * @OA\Post(
    *     path="/api/document-types/create",
    *     summary="Crear un tipo de documento",
    *     @OA\Parameter(
    *         name="name",
    *         in="query",
    *         description="nombre dle tipo de documento",
    *         required=true,
    *     ),
    *     @OA\Response(
    *         response=201,
    *         description="Retorna el documento creado."
    *     ),
    *     @OA\Response(
    *         response=401,
    *         description="No autorizado."
    *     ),
    *     @OA\Response(
    *         response=400,
    *         description="Campos invalidos."
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
            'name' => 'required'
        ]);

        if($validator->fails()) return response()->json($validator->errors()->toJson(), 400);

        $document = DocumentType::create([
            'name' => $request->get('name')
        ]);

        return response()->json(compact('document'),201);

    }
}
