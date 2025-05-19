@extends('layouts.main')
@section('title')
@section('navMovie','active')
@section('content')

    <h1>Daftar Movie</h1>
    <a href="/movie_add" class="btn btn-primary mb-3">Tambah Data Movie</a>
    <table class="table table-bordered">

        <tr>
            <th>No</th>
            <th>Cover Image</th>
            <th>Title</th>
            <th>Year</th>
        </tr>
        @foreach ($movies as $item )
        <tr>
            <td>{{ $movies->firstItem()+$loop->index }}</td>
            <td><img src="{{ $item->cover_image }}" alt="" width="100"></td>
            <td>{{ $item->title }}</td>
            <td>{{ $item->year }}</td>

            {{-- <td>
                <a href="/item/{{ $item->id }}/edit" class="btn btn-warning btn-sm">
                    <i class="bi bi-pencil-square"></i>edit
                </a>

                <form action="/item/{{ $item->id }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm">
                        <i class="bi bi-trash"></i>hapus
                    </button>
                </form>
            </td> --}}


        </tr>

        @endforeach

    </table>
    {{ $movies->links() }}

@endsection
