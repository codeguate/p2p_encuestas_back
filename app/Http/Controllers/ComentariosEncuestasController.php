<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\ComentariosEncuestas;
use Response;
use Validator;
class ComentariosEncuestasController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        return Response::json(ComentariosEncuestas::all(), 200);
    }
    
    public function getThisByFilter(Request $request, $id,$state)
    {
        if($request->get('filter')){
            switch ($request->get('filter')) {
                case 'encuesta':{
                    $objectSee = ComentariosEncuestas::whereRaw('encuesta=?',[$id])->get();
                    break;
                }
                case 'type':{
                    $objectSee = ComentariosEncuestas::whereRaw('user=? and tipo=?',[$id,$state])->get();
                    break;
                }
                default:{
                    $objectSee = ComentariosEncuestas::whereRaw('user=? and state=?',[$id,$state])->get();
                    break;
                }
    
            }
        }else{
            $objectSee = ComentariosEncuestas::whereRaw('user=? and state=?',[$id,$state])->get();
        }
    
        if ($objectSee) {
            return Response::json($objectSee, 200);
    
        }
        else {
            $returnData = array (
                'status' => 404,
                'message' => 'No record found'
            );
            return Response::json($returnData, 404);
        }
    }
    
    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        //
    }
    
    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'comentario'          => 'required',
            'encuesta'          => 'required',
        ]);
        if ( $validator->fails() ) {
            $returnData = array (
                'status' => 400,
                'message' => 'Invalid Parameters',
                'validator' => $validator
            );
            return Response::json($returnData, 400);
        }
        else {
            try {
                $newObject = new ComentariosEncuestas();
                $newObject->titulo            = $request->get('titulo');
                $newObject->nombre            = $request->get('nombre');
                $newObject->comentario            = $request->get('comentario');
                $newObject->imagen            = $request->get('imagen');
                $newObject->url            = $request->get('url');
                $newObject->state            = $request->get('state');
                $newObject->encuesta            = $request->get('encuesta');
                $newObject->save();
                return Response::json($newObject, 200);
    
            } catch (Exception $e) {
                $returnData = array (
                    'status' => 500,
                    'message' => $e->getMessage()
                );
                return Response::json($returnData, 500);
            }
        }
    }
    
    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        $objectSee = ComentariosEncuestas::find($id);
        if ($objectSee) {
            return Response::json($objectSee, 200);
    
        }
        else {
            $returnData = array (
                'status' => 404,
                'message' => 'No record found'
            );
            return Response::json($returnData, 404);
        }
    }
    
    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        //
    }
    
    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id)
    {
        $objectUpdate = ComentariosEncuestas::find($id);
        if ($objectUpdate) {
            try {
                $objectUpdate->titulo = $request->get('titulo', $objectUpdate->titulo);
                $objectUpdate->nombre = $request->get('nombre', $objectUpdate->nombre);
                $objectUpdate->comentario = $request->get('comentario', $objectUpdate->comentario);
                $objectUpdate->comentario = $request->get('comentario', $objectUpdate->comentario);
                $objectUpdate->url = $request->get('url', $objectUpdate->url);
                $objectUpdate->state = $request->get('state', $objectUpdate->state);
    
                $objectUpdate->save();
                return Response::json($objectUpdate, 200);
            } catch (Exception $e) {
                $returnData = array (
                    'status' => 500,
                    'message' => $e->getMessage()
                );
                return Response::json($returnData, 500);
            }
        }
        else {
            $returnData = array (
                'status' => 404,
                'message' => 'No record found'
            );
            return Response::json($returnData, 404);
        }
    }
    
    
    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {
        $objectDelete = ComentariosEncuestas::find($id);
        if ($objectDelete) {
            try {
                ComentariosEncuestas::destroy($id);
                return Response::json($objectDelete, 200);
            } catch (Exception $e) {
                $returnData = array (
                    'status' => 500,
                    'message' => $e->getMessage()
                );
                return Response::json($returnData, 500);
            }
        }
        else {
            $returnData = array (
                'status' => 404,
                'message' => 'No record found'
            );
            return Response::json($returnData, 404);
        }
    }
}
