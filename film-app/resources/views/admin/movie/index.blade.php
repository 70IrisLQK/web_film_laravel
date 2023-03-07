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
                                <th scope="col" colspan="2">STT</th>
                                <th scope="col" colspan="2">Title</th>
                                <th scope="col" colspan="2">Tập phim</th>
                                <th scope="col" colspan="2">Total Episode</th>
                                <th scope="col" colspan="2">Original Title</th>
                                <th scope="col" colspan="2">Trailer</th>
                                <th scope="col" colspan="2">Time</th>
                                <th scope="col" colspan="2">Type</th>
                                <th scope="col" colspan="5">Description</th>
                                <th scope="col" colspan="5">Tag</th>
                                <th scope="col" colspan="3">Actor</th>
                                <th scope="col" colspan="3">Director</th>
                                <th scope="col" colspan="2">Image</th>
                                <th scope="col" colspan="10">Category</th>
                                <th scope="col">Genre</th>
                                <th scope="col" colspan="3">Country</th>
                                <th scope="col" colspan="2">Status</th>
                                <th scope="col" colspan="2">Movie Status</th>
                                <th scope="col" colspan="2">Most view</th>
                                <th scope="col" colspan="2">Quality</th>
                                <th scope="col" colspan="2">Language</th>
                                <th scope="col" colspan="2">Hot Movie</th>
                                <th scope="col" colspan="2">Year</th>
                                <th scope="col" colspan="2">Season</th>
                                <th scope="col" colspan="2">Create at</th>
                                <th scope="col" colspan="2">Update at</th>
                                <th scope="col" colspan="2"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (empty($listMovies))
                                <span>Empty Movie</span>
                            @else
                                @foreach ($listMovies as $key => $movie)
                                    <tr id="{{ $movie->id }}">
                                        <td scope="row" colspan="2">{{ $key + 1 }}</td>
                                        <td scope="row" colspan="2">{{ $movie->title }}</td>
                                        <td scope="row" colspan="2">
                                            @foreach ($movie->episodes as $item)
                                                <span class="badge badge-info">
                                                    {{ $item->name }}
                                                </span>
                                            @endforeach
                                        </td>
                                        <td scope="row" colspan="2">
                                            {{ $movie->episodes_count }}/{{ $movie->episode_total }}
                                            tập
                                        </td>
                                        <td scope="row" colspan="2">{{ $movie->origin_name }}</td>
                                        <td scope="row" colspan="2">
                                            <div class="videoWrapper">
                                                {!! $movie->trailer_url !!}
                                            </div>
                                        </td>
                                        <td scope="row" colspan="2">{{ $movie->time }}</td>
                                        <td scope="row" colspan="2">
                                            {!! Form::select(
                                                'type',
                                                ['0' => 'single', '1' => 'series', '2' => 'cartoon', '3' => 'tvshows'],
                                                isset($movie) ? $movie->tpye : '',
                                                [
                                                    'class' => 'form-control belong_movie_choose',
                                                    'id' => isset($movie) ? $movie->id : '',
                                                ],
                                            ) !!}

                                        </td>
                                        <td scope="row" colspan="5">
                                            @if (strlen($movie->description) > 100)
                                                @php
                                                    $description = substr($movie->description, 0, 100);
                                                    echo $description . '....';
                                                @endphp
                                            @else
                                                {{ $movie->description }}
                                            @endif
                                        </td>
                                        <td scope="row" colspan="5">
                                            @if (strlen($movie->tags) > 100)
                                                @php
                                                    $tags = substr($movie->tags, 0, 100);
                                                    echo $tags . '....';
                                                @endphp
                                            @else
                                                {{ $movie->tags }}
                                            @endif
                                        </td>
                                        <td scope="row" colspan="3">
                                            {{ $movie->actor }}
                                        </td>
                                        <td scope="row" colspan="3">
                                            {{ $movie->director }}
                                        </td>
                                        <td scope="row" colspan="2">
                                            @if (isset($movie->link_image))
                                                <img width="100px" src="{{ $movie->link_image }}" />
                                            @else
                                                <img width="100px"
                                                    src="{{ asset('uploads/movies/' . $movie->image) }}" />
                                            @endif
                                        </td>
                                        <td scope="row" colspan="10">
                                            {!! Form::select('category_id', $categories, isset($movie) ? $movie->category->id : '', [
                                                'class' => 'form-control category_choose',
                                                // 'id' => isset($movie) ? $movie->id : '',
                                            ]) !!}
                                        </td>
                                        <td scope="row">
                                            @foreach ($movie->movieGenre as $item)
                                                <span class="badge badge-dark">{{ $item->title }}</span>
                                            @endforeach
                                        </td>
                                        {{-- <td scope="row" colspan="3">
                                            {!! Form::select('country_id', $countries, isset($movie) ? $movie->country->id : '', [
                                                'class' => 'form-control country_choose',
                                                // 'id' => isset($movie) ? $movie->id : '',
                                            ]) !!}
                                        </td> --}}
                                        <td scope="row" colspan="2">
                                            {!! Form::select('status', ['0' => 'INACTIVE', '1' => 'ACTIVE'], isset($movie) ? $movie->status : '', [
                                                'class' => 'form-control status_choose',
                                                // 'id' => $movie->id,
                                            ]) !!}
                                        </td>
                                        <td scope="row" colspan="2">
                                            {!! Form::select(
                                                'status_movie',
                                                ['0' => 'INACTIVE', '1' => 'ACTIVE'],
                                                isset($movie) ? $movie->status_movie : '',
                                                [
                                                    'class' => 'form-control status_choose',
                                                    // 'id' => $movie->id,
                                                ],
                                            ) !!}
                                        </td>
                                        <td scope="row" colspan="2">
                                            {!! Form::select(
                                                'top_view',
                                                ['0' => 'Ngày', '1' => 'Tuần', '2' => 'Tháng'],
                                                isset($movie) ? $movie->most_view : '',
                                                [
                                                    'class' => 'select-topview',
                                                    // 'id' => isset($movie) ? $movie->id : '',
                                                ],
                                            ) !!}
                                        </td>
                                        <td scope="row" colspan="2">
                                            {!! Form::select(
                                                'quality',
                                                ['0' => 'CAM', '1' => 'SD', '2' => 'HD', '3' => 'Full HD', '4' => 'trailer'],
                                                isset($listMovieById) ? $listMovieById->quality : '',
                                                [
                                                    'class' => 'form-control',
                                                ],
                                            ) !!}
                                        </td>
                                        <td scope="row" colspan="2">
                                            {!! Form::select('lang', ['0' => 'Vietsub', '1' => 'Thuyết minh'], isset($movie) ? $movie->lang : '', [
                                                'class' => 'form-control subtitle_choose',
                                                // 'id' => isset($movie) ? $movie->id : '',
                                            ]) !!}
                                        </td>
                                        <td scope="row" colspan="2">
                                            {!! Form::select('movie_hot', ['0' => 'INACTIVE', '1' => 'ACTIVE'], isset($movie) ? $movie->movie_hot : '', [
                                                'class' => 'form-control hot_choose',
                                                // 'id' => isset($movie) ? $movie->id : '',
                                            ]) !!}
                                        </td>
                                        <td scope="row" colspan="2">
                                            {!! Form::selectYear('year', 2000, 2023, isset($movie) ? $movie->year : '', [
                                                'class' => 'select-year',
                                                // 'id' => isset($movie) ? $movie->id : '',
                                            ]) !!}
                                        </td>
                                        <td scope="row" colspan="2">
                                            {!! Form::selectYear('season', 1, 10, isset($movie) ? $movie->season : '', [
                                                'class' => 'select-season',
                                                // 'id' => isset($movie) ? $movie->id : '',
                                            ]) !!}
                                        </td>
                                        <td scope="row" colspan="2">{{ $movie->created_at }}
                                        <td scope="row" colspan="2">{{ $movie->updated_at }}
                                        <td scope="row" colspan="2">
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
                            @endif
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
