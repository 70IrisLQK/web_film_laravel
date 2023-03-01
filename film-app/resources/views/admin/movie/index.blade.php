@extends('layouts.admin_layout')
@section('content')
    <section class="wrapper">
        <div class="table-agile-info">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Movie Management
                </div>
                <div class="row w3-res-tb">
                    <div class="col-sm-5 m-b-xs">
                    </div>
                    <div class="col-sm-4">
                    </div>
                    <div class="col-sm-3">
                        <div class="input-group">
                            <input type="text" class="input-sm form-control" placeholder="Search">
                            <span class="input-group-btn">
                                <button class="btn btn-sm btn-default" type="button">Go!</button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped b-t b-light">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Title</th>
                                <th>Original Title</th>
                                <th>Trailer</th>
                                <th>Duration</th>
                                <th colspan="5">Description</th>
                                <th colspan="5">Tag</th>
                                <th>Image</th>
                                <th>Category</th>
                                <th>Genre</th>
                                <th>Country</th>
                                <th>Status</th>
                                <th>Resolution</th>
                                <th>Subtitle</th>
                                <th>Hot</th>
                                <th>Year</th>
                                <th>Season</th>
                                <th>Create at</th>
                                <th>Update at</th>
                                <th style="width:30px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($listMovies as $key => $movie)
                                <tr id="{{ $movie->id }}">
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $movie->title }}</td>
                                    <td>{{ $movie->original_title }}</td>
                                    <td>
                                        <div class="videoWrapper">
                                            {!! $movie->trailer !!}
                                        </div>
                                    </td>
                                    <td>{{ $movie->duration }}</td>
                                    <td colspan="5">{{ $movie->description }}</td>
                                    <td colspan="5">{{ $movie->tags }}
                                    </td>
                                    <td>
                                        <img width="200px" src="{{ asset('uploads/movies/' . $movie->image) }}" />
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
                                            FULL HD
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
                                    <td>{{ $movie->created_at }}
                                    <td>{{ $movie->updated_at }}
                                    <td>
                                        <a href="{{ route('movie.edit', [$movie->id]) }}" class="active"
                                            ui-toggle-class=""><i class="fa fa-edit text-success text"></i>
                                        </a>
                                        <a href="{{ route('movie.destroy', [$movie->id]) }}" class="active"
                                            ui-toggle-class="" onclick="return confirm('Do you want to delete?')"><i
                                                class="fa fa-times text-danger text"></i>
                                        </a>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <footer class="panel-footer">
                    <div class="row">

                        <div class="col-sm-5 text-center">
                            <small class="text-muted inline m-t-sm m-b-sm">showing {{ count($listMovies) }} of
                                {{ count($listMovies) }} items</small>
                        </div>
                        <div class="col-sm-7 text-right text-center-xs">
                            {{ $listMovies->links() }}
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <!--main content end-->
    </section>
@endsection
