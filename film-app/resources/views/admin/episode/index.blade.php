@extends('layouts.admin_layout')
@section('content')
    <section class="wrapper">
        <div class="table-agile-info">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Episode Management
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
                                <th>Movie</th>
                                <th>Server Name</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>File name</th>
                                <th>Link embed</th>
                                <th>Link m3u8</th>
                                <th>Create at</th>
                                <th>Update at</th>
                                <th style="width:30px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($listEpisodes as $key => $episode)
                                <tr>
                                    <td><span class="text-ellipsis">{{ $key + 1 }}</span></td>
                                    <td><span class="text-ellipsis">{{ $episode->movie->title }}</span></td>
                                    <td><span class="text-ellipsis">
                                            <div class="videoWrapper">
                                                {!! $episode->server_name !!}
                                            </div>
                                        </span></td>
                                    <td><span class="text-ellipsis">{{ $episode->name }}</span></td>
                                    <td><span class="text-ellipsis">{{ $episode->slug }}</span></td>
                                    <td><span class="text-ellipsis">{{ $episode->filename }}</span></td>
                                    <td><span class="text-ellipsis">{{ $episode->link_embed }}</span></td>
                                    <td><span class="text-ellipsis">{{ $episode->link_m3u8 }}</span></td>
                                    <td><span class="text-ellipsis">{{ $episode->created_at }}</span></td>
                                    <td><span class="text-ellipsis">{{ $episode->updated_at }}</span></td>
                                    <td>
                                        <a href="{{ route('episode.edit', [$episode->id]) }}" class="active"
                                            ui-toggle-class=""><i class="fa fa-edit text-success text"></i>
                                        </a>
                                        <a href="{{ route('episode.destroy', [$episode->id]) }}" class="active"
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
                            <small class="text-muted inline m-t-sm m-b-sm">showing {{ count($listEpisodes) }} of
                                {{ count($listEpisodes) }} items</small>
                        </div>
                        <div class="col-sm-7 text-right text-center-xs">
                            {{ $listEpisodes->links() }}
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <!--main content end-->
    </section>
@endsection
