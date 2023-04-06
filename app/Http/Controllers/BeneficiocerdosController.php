<?php

namespace App\Http\Controllers;

use App\Models\Beneficiocerdo;
use App\Models\Book;
use App\Models\Third;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;


class BeneficiocerdosController extends Controller
{
  



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index(Request $request)
    {
      
       $beneficiocerdos = Beneficiocerdo::latest()->get();   
       if ($request->ajax()) {
         $data = Beneficiocerdo::latest()->get();

         return Datatables::of($data)
         ->addIndexColumn()
         ->addColumn('action', function($row){
            
            $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editBook">Edit</a>';
            
            $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteBook">Delete</a>';
            
            return $btn;
         })
         ->rawColumns(['action'])
         ->make(true);
      }
      
      return view('beneficiocerdo',compact('beneficiocerdos'));
   }
   
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       Book::updateOrCreate(['id' => $request->book_id],
        ['title' => $request->title, 'author' => $request->author]);        
       
       return response()->json(['success'=>'Book saved successfully.']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $book = Book::find($id);
       return response()->json($book);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       Book::find($id)->delete();
       
       return response()->json(['success'=>'Book deleted successfully.']);
    }
 }