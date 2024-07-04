<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plataforma;

class PlataformasController extends Controller
{
    public function view(){
        return view('cruds.plataformas');
    }

    public function index()
    {
        return response()->json(Plataforma::all(), 200);
    }

    public function show($id)
    {
        return response()->json(Plataforma::find($id), 200);
    }

    public function store(Request $request)
    {
        $plataforma = Plataforma::create($request->all());
        return response()->json($plataforma, 201);
    }

    public function update(Request $request, $id)
    {
        $plataforma = Plataforma::findOrFail($id);
        $plataforma->update($request->all());
        return response()->json($plataforma, 200);
    }

    public function destroy($id)
    {
        Plataforma::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}