<?php

namespace App\Http\Controllers;

use App\Models\Movie;
// use Illuminate\Support\Facades\DB;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class MovieController extends Controller
{
    public function homePage()
    {
        $movies = Movie::latest()->paginate(6);
        return view('movie.homepage', compact('movies'));
    }

    public function detail($id, $slug)
    {
        $movie = Movie::find($id);
        return view('movie.movie_detail', compact('movie'));
    }

    public function index()
    {
        $movies = Movie::latest()->paginate(10);
        return view('movie.movie_list', data: ['movies' => $movies]);
    }

    public function add()
    {
        $categories = Category::all();
        return view('movie.movie_add', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        // ambil semua input dari form
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'synopsis' => 'nullable',
            'category_id' => 'required|exists:categories,id',
            'year' => 'required|digits:4|integer|min:1901|max:' . date('Y'),
            'actors' => 'required',
            'cover_image' => 'nullable|image',
        ]);

        $slug = Str::slug($request->title);

        // ambil input file dan simpan ke storage
        $cover = null;
        if ($request->hasFile('cover_image')) {
            $cover = $request->file('cover_image')->store('covers', 'public');
        }

        // simpan ke database

        Movie::create(
            [
                'title' => $validated['title'],
                'slug' => $slug,
                'synopsis' => $validated['synopsis'],
                'category_id' => $validated['category_id'],
                'year' => $validated['year'],
                'actors' => $validated['actors'],
                'cover_image' => $cover
            ]
        );

        return redirect('/')->with('success', 'Movie Saved Successfully');
    }
}
