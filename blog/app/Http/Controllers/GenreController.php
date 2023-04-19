<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Genre;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class GenreController extends Controller
{
    //

    public function index(Request $request)
    {
        try {
            $var = $request->input('datasend');
            $token = $request->bearerToken();

            // Validasi token
            if (!$token || !Auth::guard('api')->check()) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            // Decode input
            $decodedVar = json_decode($var, true);


            $genres = Genre::all();

            // Encode output
            $response = [
                'genres' => $genres,
                'var' => $decodedVar,
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show(Request $request, $id)
    {
        try {
            //code...
            $var = $request->input('datasend');
            $token = $request->bearerToken();

            // Validasi token
            if (!$token || !Auth::guard('api')->check()) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            $model = Genre::find($id);

            return response()->json($model);
        } catch (\Throwable $th) {
            //throw $e;
            return response()->json($th->getMessage());
        }
    }

    public function store(Request $request)
    {
        # code...
        try {
            //code...
            $token = $request->bearerToken();

            // Validasi token
            if (!$token || !Auth::guard('api')->check()) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            // Memeriksa apakah ada instance Genre dengan properti name yang sama di basis data
            if (Genre::where('name', $request->name)->exists()) {
                return response()->json(['error' => 'Genre with the same name already exists'], 400);
            }

            $genre = new Genre();
            $genre->name = $request->name;
            $genre->save();

            return response()->json([
                'success' => true,
                'message' => 'Genre added successfully',
            ], 201);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json($th->getMessage());
        }
    }


    public function update(Request $request, $id)
    {
        //code...
        $token = $request->bearerToken();

        // Validasi token
        if (!$token || !Auth::guard('api')->check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }


        $genre = Genre::find($id);

        if (!$genre) {
            # code...
            return response()->json([
                'success' => false,
                'message' => 'Genre Not found'
            ]);
        }

        if (!$genre) {
            return response()->json(['error' => 'Genre not found'], 404);
        }

        $genre->name = $request->name;
        $genre->save();

        return response()->json([
            'success' => true,
            'message' => 'Data updated successfully'
        ]);
    }

    public function destroy($id)
    {
        $genre = Genre::find($id);

        if (!$genre) {
            # code...
            return response()->json([
                'success' => false,
                'message' => 'Genre Not found'
            ]);
        }

        $del = $genre->delete();
        return response()->json(array(
            'success' => true,
            'message' => 'Genre deleted'
        ), 201);
    }
}
