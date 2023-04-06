<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\Category;
use Illuminate\Http\Request;


class TodosController extends Controller
{
   
 /**
     * index para mostrar todos los todos
     * store para guardar un todo
     * update para actualizar un todo
     * destroy para eliminar un todo
     * edit para mostrar el formulario de edicion      * 
     */

    public function index()
    {
        $todos = Todo::all();
        //$categories = Category::all();
        return view('todos.index', ['todos' => $todos]);
    }

    public function store(Request $request){

        $request->validate([
            'title' => 'required|min:3',
        ]);
    
        $todo = new Todo;
        $todo->title = $request->title;
        //$todo->category_id = $request->category_id;
        $todo->save();
    
        return redirect()->route('todos')->with('success', 'Todo created successfully');
    }
    
    public function destroy($id){
        $todo = Todo::find($id);
        $todo->delete();
        return redirect()->route('todos')->with('success', 'Tarea borrada');
    }


    public function show($id){
        $todo = Todo::find($id);
        $categories = Category::all();
        return view('todos.show', ['todo' => $todo, 'categories' => $categories]);
    }

    public function update(Request $request, $id){
        $todo = Todo::find($id);
        
        $todo->title = $request->title;

    //  dd($request);
    //  dd($todo);

        $todo->save();

        return redirect()->route('todos')->with('success', 'Tarea Actilizada');
    }

}
