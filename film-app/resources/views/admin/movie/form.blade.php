@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Movie Management</div>

                    <div class="card-body">
                        @if (!isset($listMovieById))
                            {!! Form::open(['method' => 'POST', 'route' => 'movie.store', 'enctype' => 'multipart/form-data']) !!}
                        @else
                            {!! Form::open([
                                'method' => 'PUT',
                                'route' => ['movie.update', $listMovieById->id],
                                'enctype' => 'multipart/form-data',
                            ]) !!}
                        @endif
                        <div class="form-group">
                            {!! Form::label('title', 'Title', []) !!}
                            {!! Form::text('title', isset($listMovieById) ? $listMovieById->title : null, [
                                'class' => 'form-control',
                                'placeholder' => 'Input title',
                                'id' => 'title',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('description', 'Description', []) !!}
                            {!! Form::textarea('description', isset($listMovieById) ? $listMovieById->description : null, [
                                'style' => 'resize:none',
                                'class' => 'form-control',
                                'placeholder' => 'Input description',
                                'id' => 'description',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('image', 'Image', []) !!}
                            {!! Form::file('image', [
                                'class' => 'form-control',
                                'id' => 'image',
                            ]) !!}
                            @if (isset($listMovieById))
                                <img width="15%" src="{{ asset('uploads/movies/' . $listMovieById->image) }}" />
                            @endif

                        </div>
                        <div class="form-group">
                            {!! Form::label('status', 'Status', []) !!}
                            {!! Form::select(
                                'status',
                                ['1' => 'Active', '0' => 'Inactive'],
                                isset($listMovieById) ? $listMovieById->status : null,
                                [],
                            ) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('category', 'Category', []) !!}
                            {!! Form::select('category_id', $listCategories, isset($listMovieById) ? $listMovieById->category_id : null, []) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('country', 'Movie', []) !!}
                            {!! Form::select('country_id', $listCountries, isset($listMovieById) ? $listMovieById->country_id : null, []) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('genre', 'Genre', []) !!}
                            {!! Form::select('genre_id', $listGenres, isset($listMovieById) ? $listMovieById->genre_id : null, []) !!}
                        </div>
                        @if (!isset($listMovieById))
                            {!! Form::submit('Save Movie', ['class' => 'btn btn-success']) !!}
                        @else
                            {!! Form::submit('Update Movie', ['class' => 'btn btn-success']) !!}
                        @endif
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>

        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">STT</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Image</th>
                    <th scope="col">Category</th>
                    <th scope="col">Genre</th>
                    <th scope="col">Country</th>
                    <th scope="col">Status</th>
                    <th scope="col">Manage</th>
                </tr>
            </thead>
            <tbody >
                @foreach ($listMovies as $key => $movie)
                    <tr id="{{ $movie->id }}">
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $movie->title }}</td>
                        <td>{{ $movie->description }}</td>
                        <td>
                            <img width="20%" src="{{ asset('uploads/movies/' . $movie->image) }}" />
                        </td>
                        <td>
                            {{ $movie->category->title }}
                        </td>
                        <td>
                            {{ $movie->genre->title }}
                        </td>
                        <td>
                            {{ $movie->country->title }}
                        </td>
                        <td>
                            @if ($movie->status == 1)
                                Active
                            @else
                                Inactive
                            @endif
                        </td>
                        <td>
                            {!! Form::open([
                                'method' => 'DELETE',
                                'route' => ['movie.destroy', $movie->id],
                                'onsubmit' => 'return confirm("Do you want to delete?")',
                            ]) !!}
                            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                            {!! Form::close() !!}

                            <a href="{{ route('movie.edit', $movie->id) }}" class="btn btn-warning">
                                Edit
                            </a>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
@endsection
