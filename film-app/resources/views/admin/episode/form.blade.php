@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Episode Management</div>

                    <div class="card-body">
                        @if (!isset($listEpisodeById))
                            {!! Form::open(['method' => 'POST', 'route' => 'episode.store', 'enctype' => 'multipart/form-data']) !!}
                        @else
                            {!! Form::open([
                                'method' => 'PUT',
                                'route' => ['episode.update', $listEpisodeById->id],
                                'enctype' => 'multipart/form-data',
                            ]) !!}
                        @endif
                        <div class="form-group">
                            {!! Form::label('movie', 'Choose Movie', []) !!}
                            {!! Form::select(
                                'movie_id',
                                ['0' => 'Choose Movie', 'New Movie' => $listMovies],
                                isset($listEpisodeById) ? $listEpisodeById->movie_id : '',
                                [
                                    'class' => 'form-control select-movie',
                                ],
                            ) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('link', 'Link movie', []) !!}
                            {!! Form::text('link', isset($listEpisodeById) ? $listEpisodeById->link : null, [
                                'class' => 'form-control',
                                'placeholder' => 'Input link film',
                            ]) !!}
                        </div>
                        @if (!isset($listEpisodeById))
                            <div class="form-group">
                                {!! Form::label('movie', 'Choose Episode', []) !!}
                                <select name="episode" class="form-control" id="show-movie">

                                </select>
                            </div>
                        @else
                            {!! Form::label('episode', 'Episode', []) !!}
                            {!! Form::text('episode', isset($listEpisodeById) ? $listEpisodeById->episode : null, [
                                'class' => 'form-control',
                                'readonly',
                            ]) !!}
                        @endif
                        @if (!isset($listEpisodeById))
                            {!! Form::submit('Save Episode', ['class' => 'btn btn-success']) !!}
                        @else
                            {!! Form::submit('Update Episode', ['class' => 'btn btn-success']) !!}
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
                    <th scope="col">Movie Title</th>
                    <th scope="col">Episode</th>
                    <th scope="col">Link</th>
                    <th scope="col">Manage</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($listEpisodes as $key => $episode)
                    <tr id="{{ $episode->id }}">
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $episode->movie->title }}</td>
                        <td>{{ $episode->episode }}</td>
                        <td>{!! $episode->link !!}</td>
                        <td>
                            {!! Form::open([
                                'method' => 'DELETE',
                                'route' => ['episode.destroy', $episode->id],
                                'onsubmit' => 'return confirm("Do you want to delete?")',
                            ]) !!}
                            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                            {!! Form::close() !!}

                            <a href="{{ route('episode.edit', $episode->id) }}" class="btn btn-warning">
                                Edit
                            </a>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
@endsection
