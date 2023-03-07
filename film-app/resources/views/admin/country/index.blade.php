@extends('layouts.admin_layout')
@section('content')
    <section class="wrapper">
        <div class="table-agile-info">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Country Management
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
                                <th>Slug</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Create at</th>
                                <th>Update at</th>
                                <th style="width:30px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($listCountries as $key => $country)
                                <tr>
                                    <td><span class="text-ellipsis">{{ $key + 1 }}</span></td>
                                    <td>{{ $country->title }}</td>
                                    <td><span class="text-ellipsis">{{ $country->slug }}</span></td>
                                    <td><span class="text-ellipsis">{{ $country->description }}</span></td>
                                    <td><span class="text-ellipsis">
                                            {!! Form::select('status', ['0' => 'inactive', '1' => 'active'], isset($country) ? $country->status : '', [
                                                'class' => 'form-control choose_country_status',
                                                'id' => $country->id,
                                            ]) !!}
                                        </span></td>
                                    <td><span class="text-ellipsis">{{ $country->created_at }}</span></td>
                                    <td><span class="text-ellipsis">{{ $country->updated_at }}</span></td>
                                    <td>
                                        <a href="{{ route('country.edit', [$country->id]) }}" class="active"
                                            ui-toggle-class=""><i class="fa fa-edit text-success text"></i>
                                        </a>
                                        <a href="{{ route('country.destroy', [$country->id]) }}" class="active"
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
                            <small class="text-muted inline m-t-sm m-b-sm">showing {{ count($listCountries) }} of
                                {{ count($listCountries) }} items</small>
                        </div>
                        <div class="col-sm-7 text-right text-center-xs">
                            {{ $listCountries->links() }}
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <!--main content end-->
    </section>
@endsection
