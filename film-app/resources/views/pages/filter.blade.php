@extends('layout')
@section('content')
    <div class="row container" id="wrapper">
        <div class="halim-panel-filter">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-6">
                        <div class="yoast_breadcrumb hidden-xs"><span><span><a href="">@@@</a>
                                </span></span></div>
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
                    <h1 class="section-title"><span>Lọc phim</span></h1>
                </div>
                @include('pages.includes.filter')
                <div class="halim_box">
                    @foreach ($listMovies as $movie)
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
                                            @if ($movie->type == 3)
                                                {{ $movie->episodes_count . '/' . $movie->episode_total }}
                                            @elseif ($movie->quality && $movie->type != 1)
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
                                            <p class="original_title">{{ $movie->original_title }}</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>
                <div class="clearfix"></div>
                <div class="text-center">
                    {!! $listMovies->links() !!}
                </div>
            </section>
        </main>
        @include('pages.includes.sidebar')
    </div>
@endsection
