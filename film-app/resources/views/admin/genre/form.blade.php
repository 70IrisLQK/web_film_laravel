@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Genre Management</div>

                    <div class="card-body">
                        @if (!isset($listGenreById))
                            {!! Form::open(['method' => 'POST', 'route' => 'genre.store']) !!}
                        @else
                            {!! Form::open(['method' => 'PUT', 'route' => ['genre.update', $listGenreById->id]]) !!}
                        @endif
                        <div class="form-group">
                            {!! Form::label('title', 'Title', []) !!}
                            {!! Form::text('title', isset($listGenreById) ? $listGenreById->title : null, [
                                'class' => 'form-control',
                                'placeholder' => 'Input title',
                                'id' => 'slug',
                                'onkeyup' => 'ChangeToSlug()',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('slug', 'Slug', []) !!}
                            {!! Form::text('slug', isset($listGenreById) ? $listGenreById->slug : null, [
                                'class' => 'form-control',
                                'placeholder' => 'Input slug',
                                'id' => 'convert_slug',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('description', 'Description', []) !!}
                            {!! Form::textarea('description', isset($listGenreById) ? $listGenreById->description : null, [
                                'style' => 'resize:none',
                                'class' => 'form-control',
                                'placeholder' => 'Input description',
                                'id' => 'description',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('status', 'Status', []) !!}
                            {!! Form::select(
                                'status',
                                ['1' => 'Active', '0' => 'Inactive'],
                                isset($listGenreById) ? $listGenreById->status : null,
                                [],
                            ) !!}
                        </div>
                        @if (!isset($listGenreById))
                            {!! Form::submit('Save Genre', ['class' => 'btn btn-success']) !!}
                        @else
                            {!! Form::submit('Update Genre', ['class' => 'btn btn-success']) !!}
                        @endif
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">STT</th>
                        <th scope="col">Title</th>
                        <th scope="col">Slug</th>
                        <th scope="col">Description</th>
                        <th scope="col">Status</th>
                        <th scope="col">Manage</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($listGenres as $key => $genre)
                        <tr>
                            <th scope="row">{{ $key + 1 }}</th>
                            <td>{{ $genre->title }}</td>
                            <td>{{ $genre->slug }}</td>
                            <td>{{ $genre->description }}</td>
                            <td>
                                @if ($genre->status == 1)
                                    Active
                                @else
                                    Inactive
                                @endif
                            </td>
                            <td>
                                {!! Form::open([
                                    'method' => 'DELETE',
                                    'route' => ['genre.destroy', $genre->id],
                                    'onsubmit' => 'return confirm("Do you want to delete?")',
                                ]) !!}
                                {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                {!! Form::close() !!}

                                <a href="{{ route('genre.edit', $genre->id) }}" class="btn btn-warning">
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection
