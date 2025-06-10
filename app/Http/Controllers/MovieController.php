<?php

namespace App\Http\Controllers;

use App\Models\Movie;
// use Illuminate\Support\Facades\DB;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
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

    public function add()
    {
        $categories = Category::all();
        return view('movie.movie_add', compact('categories'));
    }

    public function edit($id)
    {
        $categories = Category::all();
        $movie = Movie::find($id);
        return view('movie.movie_edit', compact('categories', 'movie'));
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

    public function delete($id): RedirectResponse
    {
        if (Gate::allows('delete')) {
            $data = Movie::find($id);
            if ($data) {
                $data->delete();
                return redirect(route('movie_data'))->with('success', 'Movie Delete Successfully');
            } else {
                return redirect(route('movie_data'))->with('failed', 'Movie Delete Failed');
            }
        } else {
            abort(403);
        }
    }

    public function update(Request $request, $id): RedirectResponse
    {
        // Validasi input
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'synopsis' => 'nullable',
            'category_id' => 'required|exists:categories,id',
            'year' => 'required|digits:4|integer|min:1901|max:' . date('Y'),
            'actors' => 'required',
            'cover_image' => 'nullable|image',
        ]);

        $movie = Movie::findOrFail($id); // cari movie berdasarkan ID

        $slug = Str::slug($validated['title']);

        // Cek apakah ada file baru yang diupload
        if ($request->hasFile('cover_image')) {
            $cover = $request->file('cover_image')->store('covers', 'public');
            $movie->cover_image = $cover;
        }

        // Update data
        $movie->title = $validated['title'];
        $movie->slug = $slug;
        $movie->synopsis = $validated['synopsis'];
        $movie->category_id = $validated['category_id'];
        $movie->year = $validated['year'];
        $movie->actors = $validated['actors'];

        $movie->save(); // simpan ke database

        return redirect(route('movie_data'))->with('success', 'Movie updated successfully');
    }

    public function dataMovie()
    {
        $movies = Movie::latest()->paginate(10);
        $categories = Category::all();
        return view('movie.movie_list', compact('movies', 'categories'));
    }
}
