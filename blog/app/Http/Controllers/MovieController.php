<?php

namespace App\Http\Controllers;


use App\Models\Movie;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MovieController extends Controller
{
    //
    public function index(Request $request)
    {
        try {
            $token = $request->bearerToken();

            //? Validasi token
            if (!$token || !Auth::guard('api')->check()) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            $movies = Movie::where([
                [function ($query) use ($request) {
                    if (($search = $request->search)) {
                        # code...
                        $query->orWhere('title', 'LIKE', '%' . $search . '%')
                            ->get();
                    }
                    if ($rating = $request->rating) {
                        # code...
                        $query->orWhere('rating', 'LIKE', '%' . $rating . '%')
                            ->get();
                    }
                }]
            ])
                ->with('genres')
                ->paginate(6);

            if ($movies->isEmpty()) {
                # code...
                return response()->json(['error' => 'Movies Not Found'], 404);
            }

            $response = [
                'movies' => $movies,
            ];


            // Encode output

            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function show(Request $request, $id)
    {
        try {
            //code...
            $token = $request->bearerToken();

            //? Validasi token
            if (!$token || !Auth::guard('api')->check()) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            //? Eager load the `genre` & 'favorite' relationship 
            $movie = Movie::with('genres', 'favorite')->find($id);

            if (!$movie) {
                # code...
                return response()->json(['error' => 'Movie Not Found'], 400);
            }

            return response()->json([
                'movies' => $movie,
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        # code...
        try {
            //code...
            $token = $request->bearerToken();

            //? Validasi token
            if (!$token || !Auth::guard('api')->check()) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            //? Memeriksa apakah ada instance Movie dengan properti title yang sama di basis data
            if (Movie::where('title', $request->title,)->exists()) {
                return response()->json(['error' => 'Movie with the same title already exists'], 400);
            }

            $validator = Validator::make(
                $request->all(),
                [
                    'title' => 'required|string|max:255',
                    'synopsis' => 'required|string|max:1000',
                    'trailerUrl' => 'required|string|max:1000',
                    'imgUrl' => 'required|string|max:1000',
                    'rating' => 'required|integer',
                    'genreId' => 'required|integer',

                ]
            );

            if ($validator->fails()) {
                # code...
                return response()->json([$validator->errors()], 401);
            }

            $movie = new Movie();
            $movie->title = $request->title;
            $movie->synopsis = $request->synopsis;
            $movie->trailerUrl = $request->trailerUrl;
            $movie->imgUrl = $request->imgUrl;
            $movie->rating = $request->rating;
            $movie->genreId = $request->genreId;
            $movie->save();

            return response()->json([
                'success' => true,
                'message' => 'Movie added successfully',
                'title' => $movie->title
            ], 201);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json($th->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        # code...
        try {
            $token = $request->bearerToken();

            //? Validasi token
            if (!$token || !Auth::guard('api')->check()) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }


            $movie = Movie::find($id);
            $movie->title = $request->title;
            $movie->synopsis = $request->synopsis;
            $movie->trailerUrl = $request->trailerUrl;
            $movie->imgUrl = $request->imgUrl;
            $movie->rating = $request->rating;
            $movie->genreId = $request->genreId;
            $movie->save();

            return response()->json([
                'success' => true,
                'message' => 'Movie Updated successfully',
            ], 201);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json($th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            //code...
            $genre = Movie::find($id);

            if (!$genre) {
                # code...
                return response()->json([
                    'success' => false,
                    'message' => 'Movie Not found'
                ]);
            }

            $del = $genre->delete();
            return response()->json(array(
                'success' => true,
                'message' => 'Movie deleted'
            ), 201);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json($th->getMessage());
        }
    }


    public function addFavorite(Request $request, $movieId)
    {
        # code...

        try {
            //code...
            $findMovie = Movie::findOrFail($movieId);


            if (!$findMovie) {
                return response()->json(['message' => 'Movie not found'], 400);
            }

            $findFavorite = Favorite::where('movieId', $movieId)->first();

            if ($findFavorite) {
                return response()->json(['message' => 'Movie already added to favorites'], 400);
            }


            $favorite = new Favorite();
            $favorite->movieId = $movieId;
            $favorite->save();

            return response()->json([
                'message' => 'Successfully added movie to favorites',
                'favorite' => $favorite,
            ], 201);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json($th->getMessage());
        }
    }
}
