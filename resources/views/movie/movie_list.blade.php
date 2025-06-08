@extends('layouts.template')
@section('title', 'List Movie Data')
@section('navData', 'active')
@section('content')

    <?php if (session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php elseif (session('failed')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Failed!</strong> {{ session('failed') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <h1>Daftar Movie</h1>
    <a href="{{ route('movie_add') }}" class="btn btn-success mb-3">Tambah Data Movie</a>
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Title</th>
            <th>Category</th>
            <th>Year</th>
            <th>Action</th>
        </tr>
        @foreach ($movies as $item)
            <tr>
                <td>{{ $movies->firstItem() + $loop->index }}</td>
                <td>{{ $item->title }}</td>
                <td>
                    @foreach ($categories as $category)
                        {{ $category->id == $item->category_id ? $category->category_name : null }}
                    @endforeach
                </td>
                <td>{{ $item->year }}</td>
                <td>
                    <a href="/movie/{{ $item->id }}/{{ $item->slug }}" class="btn btn-primary">Detail</a>
                    <a href="/movie_edit/{{ $item->id }}" class="btn btn-warning">Edit</a>
                    <form action="/delete_data/{{ $item->id }}" method="post">
                        @csrf
                        <button class="btn btn-danger" type="submit"
                            onclick="alert('Are you sure to delete?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
    {{ $movies->links() }}

@endsection
