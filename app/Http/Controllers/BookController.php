<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    //

    // BookController.php
public function store(Request $request)
{
    // dd($request->input());
    $book = new Book();
    $book->title = $request->title;
    $book->slug = $request->title;
    $book->slug = strtolower( str_replace(' ','_',$request->slug));
    // dd($book->slug);
    $book->about = $request->about;
    $extension = $request->file('cover')->extension();
//   dd($request->input());
   $fileName = date('YmdHis').'.'.$extension;
    //  dd($fileName);
     $request->file('cover')->move(public_path('uploads/'), $fileName);
     $request-> cover = $fileName;
     $book->save();
}
}
