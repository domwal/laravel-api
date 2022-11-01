<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Eletrodomestico;
use App\Models\Marca;
use App\Http\Requests\EletroDomesticoRequest;
use App\Http\Resources\Eletrodomestico as EletrodomesticoResource;

class EletroDomesticoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rs = Eletrodomestico::paginate(15);
        return EletrodomesticoResource::collection($rs);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EletroDomesticoRequest $request)
    {
        $eletrodomestico = new Eletrodomestico;
        $eletrodomestico->nome = $request->input('nome');
        $eletrodomestico->descricao = $request->input('descricao');
        $eletrodomestico->tensao = $request->input('tensao');
        $eletrodomestico->preco = $request->input('preco');
        $eletrodomestico->cor = $request->input('cor');
        $eletrodomestico->marca_id = $request->input('marca_id');

        if( $eletrodomestico->save() ){
          return new EletrodomesticoResource( $eletrodomestico );
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
        // $rs = Eletrodomestico::findOrFail( $id );
        $rs = Eletrodomestico::with('marca')->findOrFail($id);
        return new EletrodomesticoResource( $rs );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function edit($id)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EletroDomesticoRequest $request, $id)
    {
        $eletrodomestico = Eletrodomestico::findOrFail( $request->id );
        $eletrodomestico->nome = $request->input('nome');
        $eletrodomestico->descricao = $request->input('descricao');
        $eletrodomestico->tensao = $request->input('tensao');
        $eletrodomestico->preco = $request->input('preco');
        $eletrodomestico->cor = $request->input('cor');
        $eletrodomestico->marca_id = $request->input('marca_id');

        if( $eletrodomestico->save() ){
          return new EletrodomesticoResource( $eletrodomestico );
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
        $eletrodomestico = Eletrodomestico::findOrFail( $id );
        if( $eletrodomestico->delete() ){
          return new EletrodomesticoResource( $eletrodomestico );
        }
    }
}
