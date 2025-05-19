@extends('layouts.main')
@section('title', 'Tambah Data Movie')
@section('navMovie', 'active')

@section('content')
    <div class="row">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <div class="col-12">
                <h1 class="h2">Input Data Movie</h1>

                <form action="/movie" method="post">
                    @csrf

                    {{-- title --}}
                    <div class="row mb-3">
                        <label for="title" class="col-sm-2 col-form-label">title</label>
                        <div class="col-sm-10">
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                id="title" value="{{ old('title') }}">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- slug --}}
                    <div class="row mb-3">
                        <label for="slug" class="col-sm-2 col-form-label">Slug</label>
                        <div class="col-sm-10">
                            <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror"
                                id="slug" value="{{ old('slug') }}">
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- synopsis --}}
                    <div class="row mb-3">
                        <label for="synopsis" class="col-sm-2 col-form-label">synopsis</label>
                        <div class="col-sm-10">
                            <input type="text" name="synopsis"
                                class="form-control @error('synopsis') is-invalid @enderror" id="synopsis"
                                value="{{ old('synopsis') }}">
                            @error('synopsis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- category --}}
                    <div class="mb-3 row">
                        <label for="category_id" class="col-sm-2 col-form-label">Category</label>
                        <div class="col-sm-10">
                            <select name="category_id" id="category_id"
                                class="form-control @error('category_id') is-invalid @enderror">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($category as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('category_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->category_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>


                    {{-- year --}}
                    <div class="row mb-3">
                        <label for="year" class="col-sm-2 col-form-label">Year</label>
                        <div class="col-sm-10">
                            <input type="number" name="year" class="form-control @error('year') is-invalid @enderror"
                                id="year" value="{{ old('year') }}">
                            @error('year')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- actors --}}
                    <div class="mb-3 row">
                        <label for="actors" class="col-sm-2 col-form-label">Actors</label>
                        <div class="col-sm-10">
                            <textarea name="actors" id="actors" rows="4" class="form-control @error('actors') is-invalid @enderror">{{ old('actors') }}</textarea>
                            @error('actors')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- cover_image --}}
                    <div class="row mb-3">
                        <label for="cover_image" class="col-sm-2 col-form-label">Cover Image</label>
                        <div class="col-sm-10">
                            <input type="file" name="cover_image"
                                class="form-control @error('cover_image') is-invalid @enderror" id="cover_image"
                                value="{{ old('cover_image') }}">
                            @error('cover_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection
