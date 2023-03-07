@extends('layout')
@section('content')
    <div class="row container" id="wrapper">
        <div class="halim-panel-filter">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-6">
                        <div class="yoast_breadcrumb hidden-xs"><span><span><a href="">Phim </a> » <span
                                        class="breadcrumb_last" aria-current="page">{{ $year }}</span></span></span>
                        </div>
                    </div>
                </div>
            </div>
            <div id="ajax-filter" class="panel-collapse collapse" aria-expanded="true" role="menu">
                <div class="ajax"></div>
            </div>
        </div>
        <main id="main-contents" class="col-xs-12 col-sm-12 col-md-8">
            <section>
                <div class="section-bar clearfix">
                    <h1 class="section-title"><span>Phim {{ $year }}</span></h1>
                </div>
                <div class="halim_box">
                    @foreach ($listMovieByYear as $movie)
                        <article class="col-md-3 col-sm-3 col-xs-6 thumb grid-item post-37606">
                            <div class="halim-item">
                                <a class="halim-thumb" href="{{ route('phim', $movie->slug) }}">
                                    <figure>
                                        @if (empty($movie->image))
                                            <img class="lazy img-responsive" src="{{ $movie->link_image }}"
                                                alt="{{ $movie->title }}" title="{{ $movie->title }}">
                                        @else
                                            <img class="lazy img-responsive"
                                                src="{{ asset('uploads/movies/' . $movie->image) }}"
                                                alt="{{ $movie->title }}" title="{{ $movie->title }}">
                                        @endif
                                    </figure>
                                    <span class="status">
                                        @if ($movie->type == 2 && strcmp($movie->episode_total, '1') !== 0)
                                            {{ $movie->episodes_count . '/' . $movie->episode_total }}
                                        @else
                                            @if ($movie->quality && $movie->type != 1)
                                                @if ($movie->quality == 0)
                                                    CAM
                                                @elseif($movie->quality == 1)
                                                    SD
                                                @elseif($movie->quality == 2)
                                                    HD
                                                @elseif($movie->quality == 3)
                                                    Full HD
                                                @endif
                                            @elseif ($movie->type == 2)
                                                @if ($movie->quality == 0)
                                                    CAM
                                                @elseif($movie->quality == 1)
                                                    SD
                                                @elseif($movie->quality == 2)
                                                    HD
                                                @elseif($movie->quality == 3)
                                                    Full HD
                                                @endif
                                            @else
                                                {{ $movie->episodes_count . '/' . $movie->episode_total }}
                                            @endif
                                        @endif
                                    </span>
                                    <span class="episode"><i class="fa fa-play" aria-hidden="true"></i>
                                        @if ($movie->lang == 0)
                                            Vietsub
                                        @else
                                            Thuyết minh
                                        @endif
                                    </span>
                                    <div class="icon_overlay"></div>
                                    <div class="halim-post-title-box">
                                        <div class="halim-post-title ">
                                            <p class="entry-title">{{ $movie->title }}</p>
                                            <p class="original_title">{{ $movie->origin_name }}</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>
                <div class="clearfix"></div>
                <div class="text-center">
                    {{-- <ul class='page-numbers'>
                        <li><span aria-current="page" class="page-numbers current">1</span></li>
                        <li><a class="page-numbers" href="">2</a></li>
                        <li><a class="page-numbers" href="">3</a></li>
                        <li><span class="page-numbers dots">&hellip;</span></li>
                        <li><a class="page-numbers" href="">55</a></li>
                        <li><a class="next page-numbers" href=""><i class="hl-down-open rotate-right"></i></a>
                        </li>
                    </ul> --}}
                    {!! $listMovieByYear->links('vendor.pagination.custom') !!}
                </div>
            </section>

        </main>
        @include('pages.includes.sidebar')

    </div>
@endsection
