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
                                'id' => 'slug',
                                'onkeyup' => 'ChangeToSlug()',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('slug', 'Slug', []) !!}
                            {!! Form::text('slug', isset($listMovieById) ? $listMovieById->slug : null, [
                                'class' => 'form-control',
                                'placeholder' => 'Input slug',
                                'id' => 'convert_slug',
                            ]) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('originalTitle', 'Original Title', []) !!}
                            {!! Form::text('original_title', isset($listMovieById) ? $listMovieById->original_title : null, [
                                'class' => 'form-control',
                                'placeholder' => 'Input original title',
                                'id' => 'original_title',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('trailer', 'Trailer', []) !!}
                            {!! Form::text('trailer', isset($listMovieById) ? $listMovieById->trailer : null, [
                                'class' => 'form-control',
                                'placeholder' => 'Input trailer',
                                'id' => 'trailer',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('duration', 'Duration', []) !!}
                            {!! Form::text('duration', isset($listMovieById) ? $listMovieById->duration : null, [
                                'class' => 'form-control',
                                'placeholder' => 'Input duration',
                                'id' => 'duration',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('tags', 'Tag', []) !!}
                            {!! Form::textarea('tags', isset($listMovieById) ? $listMovieById->description : null, [
                                'style' => 'resize:none',
                                'class' => 'form-control',
                                'placeholder' => 'Input tags',
                                'id' => 'tags',
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
                            {!! Form::label('subtitle', 'Subtitle', []) !!}
                            {!! Form::select(
                                'subtitle',
                                ['1' => 'Thuyết minh', '0' => 'ViệtSub'],
                                isset($listMovieById) ? $listMovieById->subtitle : null,
                                [],
                            ) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('resolution', 'Resolution', []) !!}
                            {!! Form::select(
                                'resolution',
                                ['1' => 'HD', '0' => 'SD'],
                                isset($listMovieById) ? $listMovieById->resolution : null,
                                [],
                            ) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('hot', 'Movie Hot', []) !!}
                            {!! Form::select(
                                'movie_hot',
                                ['1' => 'Active', '0' => 'Inactive'],
                                isset($listMovieById) ? $listMovieById->hot : null,
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
                            {!! Form::label('genre', 'Genre', []) !!} <br />
                            {{-- {!! Form::select('genre_id', $listGenres, isset($listMovieById) ? $listMovieById->genre_id : null, []) !!} --}}
                            @foreach ($listGenres as $genre)
                                @if (isset($listMovieById))
                                    {!! Form::checkbox(
                                        'genre[]',
                                        $genre->id,
                                        isset($listMovieGenre) && $listMovieGenre->contains($genre->id) ? true : false,
                                    ) !!}
                                    {!! Form::label('genre', $genre->title) !!}
                                @else
                                    {!! Form::checkbox('genre[]', $genre->id) !!}
                                    {!! Form::label('genre', $genre->title) !!}
                                @endif
                            @endforeach
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
                    <th scope="col">Original Title</th>
                    <th scope="col">Trailer</th>
                    <th scope="col">Duration</th>
                    <th scope="col">Description</th>
                    <th scope="col">Tag</th>
                    <th scope="col">Image</th>
                    <th scope="col">Category</th>
                    <th scope="col">Genre</th>
                    <th scope="col">Country</th>
                    <th scope="col">Status</th>
                    <th scope="col">Resolution</th>
                    <th scope="col">Subtitle</th>
                    <th scope="col">Hot</th>
                    <th scope="col">Year</th>
                    <th scope="col">Season</th>
                    <th scope="col">Manage</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($listMovies as $key => $movie)
                    <tr id="{{ $movie->id }}">
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $movie->title }}</td>
                        <td>{{ $movie->original_title }}</td>
                        <td>{{ $movie->trailer }}</td>
                        <td>{{ $movie->duration }}</td>
                        <td>{{ $movie->description }}</td>
                        <td>{{ $movie->tags }}</td>
                        <td>
                            <img width="20%" src="{{ asset('uploads/movies/' . $movie->image) }}" />
                        </td>
                        <td>
                            {{ $movie->category->title }}
                        </td>
                        <td>
                            @foreach ($movie->movieGenre as $item)
                                <span class="badge badge-dark">{{ $item->title }}</span>
                            @endforeach
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
                            @if ($movie->resolution == 0)
                                SD
                            @else
                                HD
                            @endif
                        </td>
                        <td>
                            @if ($movie->subtitle == 0)
                                Thuyết minh
                            @else
                                Việt Sub
                            @endif
                        </td>
                        <td>
                            @if ($movie->movie_hot == 1)
                                Active
                            @else
                                Inactive
                            @endif
                        </td>
                        <td>
                            {!! Form::selectYear('year', 2000, 2023, isset($movie) ? $movie->year : '', [
                                'class' => 'select-year',
                                'id' => $movie->id,
                            ]) !!}
                        </td>
                        <td>
                            {!! Form::selectYear('season', 1, 10, isset($movie) ? $movie->season : '', [
                                'class' => 'select-season',
                                'id' => $movie->id,
                            ]) !!}
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
