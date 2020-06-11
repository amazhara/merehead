<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Book;
use App\User;
use App\Http\Controllers\UserController;

class BookController extends Controller
{
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'user_id' => 'required|unique:users',
            'name' => 'required|string|max:255|unique:books',
            'pages_number' => 'required|string',
            'annotation' => 'required|string|unique:books',
            'author_id' => 'required|unique:authors',
            // 'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // if ($validator->fails()) {
        //     return response()->json($validator->errors()->toJson(), 400);
        // }

        $r = Http::withToken('eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9tZXJlaGVhZC50ZXN0XC9hcGlcL2xvZ2luIiwiaWF0IjoxNTkxODU1Mjg5LCJleHAiOjE1OTE4NTg4ODksIm5iZiI6MTU5MTg1NTI4OSwianRpIjoiZ0U1ZEQzVVhOT1dpam5rbSIsInN1YiI6MSwicHJ2IjoiODdlMGFmMWVmOWZkMTU4MTJmZGVjOTcxNTNhMTRlMGIwNDc1NDZhYSJ9.Re6dJUPLSJcOi0DpOx8QRH0aP32d8cSNBH7lC-k295Y')
        ->get('merehead.test/api/user')->throw()->json();

        return response()->json($r);
    }
}
