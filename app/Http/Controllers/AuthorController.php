<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Author;
use App\Book;

class AuthorController extends Controller
{
    public function getAuthorsList()
    {
        $authors = Author::all();

        return response()->json(compact('authors'));
    }

    public function getBooksList($author)
    {
        $books = Book::where('author_name' , $author)->get();

        return response()->json(compact('books'));
    }
}
