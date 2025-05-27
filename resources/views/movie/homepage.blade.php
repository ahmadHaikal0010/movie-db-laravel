@extends('layouts.template')
@section('title', 'Homepage Movies')
@section('navHome', 'active')

@section('content')
    <h1>Latest Movies</h1>
    <?php if (session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row">
        {{-- looping data movies --}}
        @foreach ($movies as $movie)
            <div class="col-lg-6">
                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="{{ asset('storage/' . $movie->cover_image) }}" class="img-fluid rounded-start" alt="...">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">{{ $movie->title }}</h5>
                                <p class="card-text">{{ Str::words($movie->synopsis, 20, '...') }}</p>
                                <a href="/movie/{{ $movie->id }}/{{ $movie->slug }}" class="btn btn-success">Read
                                    More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        {{-- end loop --}}
        {{ $movies->links() }}
    </div>
@endsection
