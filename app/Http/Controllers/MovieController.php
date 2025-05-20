<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Http\Controllers\Controller;
use App\Models\Movie;

class MovieController extends Controller
{
    public function homePage()
    {
        $movies = Movie::latest()->paginate(6);
        return view('homepage', compact('movies'));
    }

    public function index()
    {
        $movies = Movie::latest()->paginate(10);
        return view('movie.movie_list', data: ['movies' => $movies]);
    }

    public function add()
    {
        $category = DB::table('categories')->get(); // Ambil semua kategori
        return view('movie.movie_add', ['category' => $category]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required',
            'slug' => 'required',
            'synopsis' => 'required',
            'category_id' => 'required',
            'year' => 'required|digits:4|integer|min:1901|max:2155',
            'actors' => 'required',
            'cover_image' => 'required',
        ]);

        Movie::create($validated);

        return redirect('/movie');
    }
}
