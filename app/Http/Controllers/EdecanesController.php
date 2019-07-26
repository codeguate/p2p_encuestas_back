<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Edecanes;
use Response;
use Validator;
class EdecanesController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        return Response::json(Edecanes::all(), 200);
    }
    
    public function getThisByFilter(Request $request, $id,$state)
    {
        if($request->get('filter')){
            switch ($request->get('filter')) {
                case 'edecan':{
                    $objectSee = Edecanes::whereRaw('edecan=? and state=?',[$id,$state])->get();
                    break;
                }
                case 'promotor':{
                    $objectSee = Edecanes::whereRaw('promotor=? and state=?',[$id,$state])->get();
                    break;
                }
                default:{
                    $objectSee = Edecanes::whereRaw('state=?',[$state])->get();
                    break;
                }
    
            }
        }else{
            $objectSee = Edecanes::whereRaw('state=?',[$state])->get();
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
            'url'          => 'required',
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
                $newObject = new Edecanes();
                $newObject->titulo            = $request->get('titulo');
                $newObject->imagen            = $request->get('imagen');
                $newObject->url            = $request->get('url');
                $newObject->state            = $request->get('state');
                $newObject->promotor            = $request->get('promotor');
                $newObject->edecan            = $request->get('edecan');
                $newObject->evento            = $request->get('evento');
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
        $objectSee = Edecanes::find($id);
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
        $objectUpdate = Edecanes::find($id);
        if ($objectUpdate) {
            try {
                $objectUpdate->titulo = $request->get('titulo', $objectUpdate->titulo);
                $objectUpdate->imagen = $request->get('imagen', $objectUpdate->imagen);
                $objectUpdate->url = $request->get('url', $objectUpdate->url);
                $objectUpdate->state = $request->get('state', $objectUpdate->state);
                $objectUpdate->promotor = $request->get('promotor', $objectUpdate->promotor);
                $objectUpdate->edecan = $request->get('edecan', $objectUpdate->edecan);
                $objectUpdate->evento = $request->get('evento', $objectUpdate->evento);
    
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
        $objectDelete = Edecanes::find($id);
        if ($objectDelete) {
            try {
                Edecanes::destroy($id);
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
