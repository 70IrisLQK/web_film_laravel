@extends('layout')
@section('content')
    <div class="row container" id="wrapper">
        <div class="halim-panel-filter">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-6">
                        <div class="yoast_breadcrumb hidden-xs"><span><span><a
                                        href="{{ route('categories', $listMovieBySlug->category->slug) }}">{{ $listMovieBySlug->category->title }}</a>
                                    » <span><a
                                            href="{{ route('countries', $listMovieBySlug->country->slug) }}">{{ $listMovieBySlug->country->title }}</a>
                                        » <span class="breadcrumb_last"
                                            aria-current="page">{{ $listMovieBySlug->title }}</span></span></span></span>
                        </div>
                    </div>
                </div>
            </div>
            <div id="ajax-filter" class="panel-collapse collapse" aria-expanded="true" role="menu">
                <div class="ajax"></div>
            </div>
        </div>
        <main id="main-contents" class="col-xs-12 col-sm-12 col-md-8">
            <section id="content" class="test">
                <div class="clearfix wrap-content">
                    <div class="halim-movie-wrapper">
                        <div class="title-block">
                            <div id="bookmark" class="bookmark-img-animation primary_ribbon" data-id="38424">
                                <div class="halim-pulse-ring"></div>
                            </div>
                            <div class="title-wrapper" style="font-weight: bold;">
                                Bookmark
                            </div>
                        </div>
                        <div class="movie_info col-xs-12">
                            <div class="movie-poster col-md-3">
                                <img class="movie-thumb" src="{{ asset('uploads/movies/' . $listMovieBySlug->image) }}"
                                    alt="{{ $listMovieBySlug->title }}">
                                @if ($listMovieBySlug->resolution != 5)
                                    @if ($countEpisode > 0)
                                        <div class="bwa-content">
                                            <div class="loader"></div>
                                            <a href="{{ url('watch/' . $listMovieBySlug->slug . '/episode-' . $firstEpisode->episode) }}"
                                                class="bwac-btn">
                                                <i class="fa fa-play"></i>
                                            </a>
                                        </div>
                                    @endif
                                @else
                                    <a href="#watch-trailer" style="display:block;"
                                        class="btn btn-primary watch-trailer">Xem Trailer</a>
                                @endif
                            </div>
                            <div class="film-poster col-md-9">
                                <h1 class="movie-title title-1"
                                    style="display:block;line-height:35px;margin-bottom: -14px;color: #ffed4d;text-transform: uppercase;font-size: 18px;">
                                    {{ $listMovieBySlug->title }}</h1>
                                <h2 class="movie-title title-2" style="font-size: 12px;">
                                    {{ $listMovieBySlug->original_title }}
                                </h2>
                                <ul class="list-info-group">
                                    <li class="list-info-group-item"><span>Trạng Thái</span> : <span class="quality">
                                            @if ($listMovieBySlug->resolution == 0)
                                                SD
                                            @else
                                                FULL HD
                                            @endif
                                        </span><span class="episode">
                                            @if ($listMovieBySlug->subtitle == 0)
                                                Thuyết minh
                                            @else
                                                Việt Sub
                                            @endif
                                        </span></li>
                                    <li class="list-info-group-item"><span>Điểm IMDb</span> : <span
                                            class="imdb">{{ $listMovieBySlug->imdb }}</span></li>
                                    <li class="list-info-group-item"><span>Thời lượng</span> :
                                        {{ $listMovieBySlug->duration }}</li>
                                    @if ($listMovieBySlug->belong_movie)
                                        <li class="list-info-group-item"><span>Tập phim</span> :
                                            {{ $countEpisode }}/{{ $listMovieBySlug->episode }} -
                                            @if ($countEpisode == $listMovieBySlug->episode)
                                                Full
                                            @else
                                                Đang cập nhật
                                            @endif
                                        </li>
                                    @endif
                                    <li class="list-info-group-item"><span>Thể loại</span> :
                                        @foreach ($listMovieBySlug->movieGenre as $item)
                                            <a href="{{ route('genres', [$item->slug]) }}" rel="category tag">
                                                {{ $item->title }}
                                            </a>
                                        @endforeach
                                    </li>
                                    <li class="list-info-group-item"><span>Quốc gia</span> : <a
                                            href="{{ route('countries', [$listMovieBySlug->country->slug]) }}"
                                            rel="tag">{{ $listMovieBySlug->country->title }}</a></li>

                                    <li class="list-info-group-item"><span>Tập Phim Mới Nhất</span> :
                                        @if ($countEpisode > 0)
                                            @if ($listMovieBySlug->belong_movie == 'Phim bộ')
                                                @foreach ($listEpisode as $episode)
                                                    <a href="{{ url('watch/' . $episode->movie->slug . '/episode-' . $episode->episode) }}"
                                                        rel="tag">Tập
                                                        {{ $episode->episode }}
                                                    </a>
                                                @endforeach
                                            @else
                                                @foreach ($listEpisode as $episode)
                                                    <a href="{{ url('watch/' . $episode->movie->slug . '/episode-' . $episode->episode) }}"
                                                        rel="tag">Tập
                                                        {{ $episode->episode }}
                                                    </a>
                                                @endforeach
                                            @endif
                                        @else
                                            Đang cập nhật
                                        @endif

                                    </li>
                                    <li class="list-info-group-item">
                                        <div class="box-rating" itemprop="aggregateRating" itemscope=""
                                            itemtype="https://schema.org/AggregateRating">
                                            <div id="star" style="cursor: pointer; width: 200px; padding-right: 10px;">
                                                <ul class="list-inline rating" title="Average Rating">
                                                    @for ($count = 1; $count <= 5; $count++)
                                                        @php
                                                            if ($count <= $rating) {
                                                                $color = 'color:#ffcc00;';
                                                            } else {
                                                                $color = 'color:#ccc;';
                                                            }
                                                        @endphp
                                                        <li title="star_rating"
                                                            id="{{ $listMovieBySlug->id }}-{{ $count }}"
                                                            data-index="{{ $count }}"
                                                            data-movie_id="{{ $listMovieBySlug->id }}"
                                                            data-rating="{{ $rating }}" clas s="rating"
                                                            style="cursor:pointer; {{ $color }} font-size:30px;">
                                                            &#9733;</li>
                                                    @endfor
                                                </ul>
                                            </div>
                                            <div style="float: left; line-height: 20px; margin: 0 5px; ">
                                                <span id="hint">
                                                    ({{ $rating }} điểm/{{ $countTotal }} lượt)
                                                </span>
                                            </div>
                                        </div>

                                    </li>
                                    {{-- <li class="list-info-group-item"><span>Đạo diễn</span> : <a class="director"
                                            rel="nofollow" href="https://phimhay.co/dao-dien/cate-shortland"
                                            title="Cate Shortland">Cate Shortland</a></li>
                                    <li class="list-info-group-item last-item"
                                        style="-overflow: hidden;-display: -webkit-box;-webkit-line-clamp: 1;-webkit-box-flex: 1;-webkit-box-orient: vertical;">
                                        <span>Diễn viên</span> : <a href="" rel="nofollow" title="C.C. Smiff">C.C.
                                            Smiff</a>, <a href="" rel="nofollow" title="David Harbour">David
                                            Harbour</a>, <a href="" rel="nofollow" title="Erin Jameson">Erin
                                            Jameson</a>, <a href="" rel="nofollow" title="Ever Anderson">Ever
                                            Anderson</a>, <a href="" rel="nofollow" title="Florence Pugh">Florence
                                            Pugh</a>, <a href="" rel="nofollow" title="Lewis Young">Lewis Young</a>,
                                        <a href="" rel="nofollow" title="Liani Samuel">Liani Samuel</a>, <a
                                            href="" rel="nofollow" title="Michelle Lee">Michelle Lee</a>, <a
                                            href="" rel="nofollow" title="Nanna Blondell">Nanna Blondell</a>, <a
                                            href="" rel="nofollow" title="O-T Fagbenle">O-T Fagbenle</a>
                                    </li> --}}
                                </ul>
                                <div class="movie-trailer hidden"></div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div id="halim_trailer">

                    </div>
                    <div class="clearfix"></div>
                    <div class="section-bar clearfix">
                        <h2 class="section-title"><span style="color:#ffed4d">Nội dung phim</span></h2>
                    </div>
                    <div class="entry-content htmlwrap clearfix">
                        <div class="video-item halim-entry-box">
                            <article id="post-38424" class="item-content">
                                {{ $listMovieBySlug->description }}
                            </article>
                        </div>
                    </div>
                    @if (isset($listMovieBySlug->trailer))
                        <div class="section-bar clearfix">
                            <h2 class="section-title"><span style="color:#ffed4d">Trailer phim</span></h2>
                        </div>
                        <div class="entry-content htmlwrap clearfix">
                            <div class="video-item halim-entry-box">
                                <article id="watch-trailer" class="item-content iframe">
                                    {!! $listMovieBySlug->trailer !!}
                                </article>
                            </div>
                        </div>
                    @endif
                    <div class="section-bar clearfix">
                        <h2 class="section-title"><span style="color:#ffed4d">Tags phim</span></h2>
                    </div>
                    <div class="entry-content htmlwrap clearfix">
                        <div class="video-item halim-entry-box">
                            <article id="post-38424" class="item-content">
                                @if (isset($listMovieBySlug->tags))
                                    @php
                                        $tags = [];
                                        $tags = explode(',', $listMovieBySlug->tags);
                                    @endphp

                                    @foreach ($tags as $tag)
                                        <a href="{{ url('tag/' . $tag) }}">{{ $tag }}</a>
                                    @endforeach
                                @else
                                    <a
                                        href="{{ url('tag/' . $listMovieBySlug->title) }}">{{ $listMovieBySlug->title }}</a>
                                @endif
                            </article>
                        </div>
                    </div>
                    {{-- Comment --}}
                    <div class="section-bar clearfix">
                        <h2 class="section-title"><span style="color:#ffed4d">Bình luận</span></h2>
                    </div>
                    <div class="entry-content htmlwrap clearfix">
                        <div class="video-item halim-entry-box">
                            @php
                                $currentUrl = Request::url();
                            @endphp

                            <article id="post-38424" class="item-content">
                                <div class="fb-comments" data-href="{{ $currentUrl }}" data-width="100%"
                                    data-numposts="5"></div>
                            </article>
                        </div>
                    </div>
                </div>
            </section>
            <section class="related-movies">
                <div id="halim_related_movies-2xx" class="wrap-slider">
                    <div class="section-bar clearfix">
                        <h class="section-title"><span>CÓ THỂ BẠN MUỐN XEM</span></h>
                    </div>
                    <div id="halim_related_movies-2" class="owl-carousel owl-theme related-film">
                        @foreach ($listMovieRelate as $relateMovie)
                            <article class="thumb grid-item post-38498">
                                <div class="halim-item">
                                    <a class="halim-thumb" href="{{ route('movies', $relateMovie->slug) }}"
                                        title="Đại Thánh Vô Song">
                                        <figure><img class="lazy img-responsive"
                                                src="{{ asset('uploads/movies/' . $relateMovie->image) }}"
                                                alt="{{ asset('uploads/movies/' . $relateMovie->image) }}"
                                                title="{{ asset('uploads/movies/' . $relateMovie->image) }}"></figure>
                                        <span class="status">HD</span><span class="episode"><i class="fa fa-play"
                                                aria-hidden="true"></i>Vietsub</span>
                                        <div class="icon_overlay"></div>
                                        <div class="halim-post-title-box">
                                            <div class="halim-post-title ">
                                                <p class="entry-title">{{ $relateMovie->title }}</p>
                                                <p class="original_title">{{ $relateMovie->original_title }}</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>
        </main>
        <aside id="sidebar" class="col-xs-12 col-sm-12 col-md-4"></aside>
    </div>
    <script>
        jQuery(document).ready(function($) {
            var owl = $('#halim_related_movies-2');
            owl.owlCarousel({
                loop: true,
                margin: 4,
                autoplay: true,
                autoplayTimeout: 4000,
                autoplayHoverPause: true,
                nav: true,
                navText: ['<i class="hl-down-open rotate-left"></i>',
                    '<i class="hl-down-open rotate-right"></i>'
                ],
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 2
                    },
                    480: {
                        items: 3
                    },
                    600: {
                        items: 4
                    },
                    1000: {
                        items: 4
                    }
                }
            })
        });
    </script>

@endsection
