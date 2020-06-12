<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Storage;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Book;
use App\User;
use App\Http\Controllers\UserController;

class BookController extends Controller
{
    // Returns image name
    // Stores image in public Storage
    private function saveImage($image_64)
    {
        $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf
        $replace = substr($image_64, 0, strpos($image_64, ',')+1); 
      
        // find substring fro replace here eg: data:image/png;base64,
        $image = str_replace($replace, '', $image_64);
        $image = str_replace(' ', '+', $image); 
        $imageName = Str::random(10).'.'.$extension;
        
        Storage::disk('public')->put($imageName, base64_decode($image));
        return $imageName;
    }

    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:books',
            'pages_number' => 'required|string',
            'annotation' => 'required|string|unique:books',
            'author_name' => 'required|string',
            'image' => 'required|base64image',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        // Save image to file
        $image = $this->saveImage($request->get('image'));

        // Get current user
        $user = JWTAuth::toUser();

        $book = Book::create([
            'user_id' => $user['id'],
            'name' => $request->get('name'),
            'pages_number' => $request->get('pages_number'),
            'annotation' => $request->get('annotation'),
            'image' => $image,
            'author_name' => $request->get('author_name'),
        ]);

        return response()->json(compact('book'));
    }

    public function getBooksList()
    {
        $books = Book::all();

        return response()->json(compact('books'));
    }
}
