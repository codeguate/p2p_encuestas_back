<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Encuestas;
use Response;
use Validator;
class EncuestasController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        return Response::json(Encuestas::with('vendedores','imgs','comentarios','marcas','usuarios')->get(), 200);
    }
    
    public function getThisByFilter(Request $request, $id,$state)
    {
        if($request->get('filter')){
            switch ($request->get('filter')) {
                case 'proximos':{
                    $objectSee = Encuestas::whereRaw('fecha_inicio>?',[$id])->with('vendedores','imgs','comentarios','marcas','usuarios')->get();
                    break;
                }
                case 'buscar':{
                    $objectSee = Encuestas::whereRaw('fecha_inicio=? and titulo=?',[$state,$id])->with('vendedores','imgs','comentarios','marcas','usuarios')->first();
                    break;
                }
                case 'proximos-principales':{
                    $objectSee = Encuestas::whereRaw('fecha_inicio>? and tipo=2',[$id])->with('vendedores','imgs','comentarios','marcas','usuarios')->get();
                    break;
                }
                case 'actuales':{
                    $objectSee = Encuestas::whereRaw('inicio<? and fin>?',[$id])->with('vendedores','imgs','comentarios','marcas','usuarios')->get();
                    break;
                }
                case 'user':{
                    $objectSee = Encuestas::whereRaw('user=?',[$id])->with('vendedores','imgs','comentarios','marcas','usuarios')->get();
                    break;
                }
                case 'marca':{
                    $objectSee = Encuestas::whereRaw('marca=?',[$id])->with('vendedores','imgs','comentarios','marcas','usuarios')->get();
                    break;
                }
                case 'pasados':{
                    $objectSee = Encuestas::whereRaw('fecha_fin<?',[$id,$state])->with('vendedores','imgs','comentarios','marcas','usuarios')->get();
                    break;
                }
                case 'proximos_eventos':{
                    $objectSee = Encuestas::whereRaw('inicio>? and evento=?',[$state,$id])->with('eventos','areas','vendedores')->get();
                    break;
                }
                case 'actuales_eventos':{
                    $objectSee = Encuestas::whereRaw('fin>? and evento=?',[$state,$id])->with('eventos','areas','vendedores')->get();
                    break;
                }
                case 'pasados_eventos':{
                    $objectSee = Encuestas::whereRaw('fin<? and evento=?',[$state,$id])->with('eventos','areas','vendedores')->get();
                    break;
                }
                case 'evento':{
                    $objectSee = Encuestas::whereRaw('evento=?',[$id])->with('vendedores','imgs','comentarios','marcas','usuarios')->get();
                    break;
                }
                default:{
                    $objectSee = Encuestas::with('vendedores','imgs','comentarios','marcas','usuarios')->get();
                    break;
                }
    
            }
        }else{
            $objectSee = Encuestas::whereRaw('evento=? and state=?',[$id,$state])->with('vendedores','imgs','comentarios','marcas','usuarios')->get();
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
            'fecha_inicio'          => 'required',
            'user'          => 'required',
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
                $newObject = new Encuestas();
                $newObject->titulo            = $request->get('titulo');
                $newObject->imagen            = $request->get('imagen');
                $newObject->descripcion            = $request->get('descripcion');
                $newObject->direccion            = $request->get('direccion');
                $newObject->asistentes            = $request->get('asistentes');
                $newObject->ventas            = $request->get('ventas');
                $newObject->hora_inicio            = $request->get('hora_inicio');
                $newObject->hora_fin            = $request->get('hora_fin');
                $newObject->fecha_inicio            = $request->get('fecha_inicio');
                $newObject->edades            = $request->get('edades');
                $newObject->generos            = $request->get('generos');
                $newObject->fecha_fin            = $request->get('fecha_fin');
                $newObject->inicio            = $request->get('fecha_inicio')." ".$request->get('hora_inicio');
                $newObject->fin            = $request->get('fecha_fin')." ".$request->get('hora_fin');
                $newObject->latitud            = $request->get('latitud');
                $newObject->longitud            = $request->get('longitud');
                $newObject->tipo            = $request->get('tipo');
                $newObject->marca            = $request->get('marca');
                $newObject->state            = $request->get('state');
                $newObject->user            = $request->get('user');
                $newObject->save();

                $newObject->imgs;
                $newObject->vendedores;
                $newObject->comentarios;
                $newObject->marcas;
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
        $objectSee = Encuestas::with('imgs','comentarios','marcas','usuarios')->whereRaw("id=?",[$id])->first();
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
        $objectUpdate = Encuestas::find($id);
        if ($objectUpdate) {
            try {
                $objectUpdate->titulo = $request->get('titulo', $objectUpdate->titulo);
                $objectUpdate->imagen = $request->get('imagen', $objectUpdate->imagen);
                $objectUpdate->descripcion = $request->get('descripcion', $objectUpdate->descripcion);
                $objectUpdate->direccion = $request->get('direccion', $objectUpdate->direccion);
                $objectUpdate->hora_inicio = $request->get('hora_inicio', $objectUpdate->hora_inicio);
                $objectUpdate->hora_fin = $request->get('hora_fin', $objectUpdate->hora_fin);
                $objectUpdate->fecha_inicio = $request->get('fecha_inicio', $objectUpdate->fecha_inicio);
                $objectUpdate->fecha_fin = $request->get('fecha_fin', $objectUpdate->fecha_fin);
                $objectUpdate->edades = $request->get('edades', $objectUpdate->edades);
                $objectUpdate->generos = $request->get('generos', $objectUpdate->generos);
                $objectUpdate->inicio = $request->get('inicio', $objectUpdate->inicio);
                $objectUpdate->fin = $request->get('fin', $objectUpdate->fin);
                $objectUpdate->latitud = $request->get('latitud', $objectUpdate->latitud);
                $objectUpdate->longitud = $request->get('longitud', $objectUpdate->longitud);
                $objectUpdate->tipo = $request->get('tipo', $objectUpdate->tipo);
                $objectUpdate->state = $request->get('state', $objectUpdate->state);
                $objectUpdate->evento = $request->get('evento', $objectUpdate->evento);
                $objectUpdate->asistentes = $request->get('asistentes', $objectUpdate->asistentes);
                $objectUpdate->ventas = $request->get('ventas', $objectUpdate->ventas);
                $objectUpdate->marca = $request->get('marca', $objectUpdate->marca);
    
                $objectUpdate->save();
                $objectUpdate->imgs;
                $objectUpdate->vendedores;
                $objectUpdate->comentarios;
                $objectUpdate->marcas;
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
        $objectDelete = Encuestas::find($id);
        if ($objectDelete) {
            try {
                Encuestas::destroy($id);
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