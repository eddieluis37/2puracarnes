<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Listaprecio;
use App\Models\Listapreciodetalle;

class DragDropController extends Controller
{
    public function handleDragDrop(Request $request)
    {
        // Obtén los datos del arrastrar y soltar desde la solicitud
        $listaprecioId = $request->input('listaprecio_id');
        $listapreciodetalleId = $request->input('listapreciodetalle_id');

        // Actualiza el listapreciodetalle con el nuevo listaprecio_id
        $listapreciodetalle = Listapreciodetalle::findOrFail($listapreciodetalleId);
        $listapreciodetalle->listaprecio_id = $listaprecioId;
        $listapreciodetalle->save();

        // Retorna una respuesta exitosa
        return response()->json(['message' => 'Drag and drop successful']);
    }

    public function showDragView()
    {
     
        $listaprecios = Listaprecio::with('centrocosto')->get();

        return view('listadeprecio.drag', compact('listaprecios'));
    }
}
