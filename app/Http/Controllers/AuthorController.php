<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Author;

class AuthorController extends Controller
{
    public function getAuthorsList()
    {
        $authors = Author::all();

        return response()->json(compact('authors'));
    }
}
