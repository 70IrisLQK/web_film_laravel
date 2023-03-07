@extends('layouts.admin_layout')
@section('content')
    <section class="wrapper">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    @if (isset($listEpisodeById))
                        Update Episode
                    @else
                        Create Episode
                    @endif
                </header>
                <div class="panel-body">
                    <div class="position-center">
                        @if ($errors->any())
                            <div class="alert alert-danger" role="alert">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </div>
                        @endif
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
                            @if (!isset($listEpisodeById))
                                {!! Form::select(
                                    'movie_id',
                                    ['0' => 'Choose Movie', 'New Movie' => $listMovies],
                                    isset($listEpisodeById) ? $listEpisodeById->movie_id : '',
                                    [
                                        'class' => 'form-control select-movie',
                                    ],
                                ) !!}
                            @else
                                {!! Form::select(
                                    'movie_id',
                                    ['0' => 'Choose Movie', 'New Movie' => $listMovies],
                                    isset($listEpisodeById) ? $listEpisodeById->movie_id : '',
                                    [
                                        'class' => 'form-control select-movie',
                                        'disabled',
                                    ],
                                ) !!}
                            @endif
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
            </section>
        </div>
    </section>
@endsection
