@extends('layout')
@section('content')
    <div class="row container" id="wrapper">
        <div class="halim-panel-filter">
            <div id="ajax-filter" class="panel-collapse collapse" aria-expanded="true" role="menu">
                <div class="ajax"></div>
            </div>
        </div>
        <div class="col-xs-12 carausel-sliderWidget">
            <section id="halim-advanced-widget-4">
                <div class="section-heading">
                    <a href="{{ url('/phim-hot') }}" title="Phim Hot">
                        <span class="h-text">Phim Hot</span>
                    </a>
                    <ul class="heading-nav pull-right hidden-xs">
                        <a href="{{ url('/phim-hot') }}" title="Phim Hot">
                            <li class="section-btn
                            halim_ajax_get_post" data-catid="4"
                                data-showpost="12" data-widgetid="halim-advanced-widget-4" data-layout="6col"><span
                                    data-text="Xem thêm"></span>
                            </li>
                        </a>
                    </ul>
                </div>
                <div id="halim-advanced-widget-4-ajax-box" class="halim_box">
                    @foreach ($listHotMovies as $hotMovie)
                        <article class="col-md-2 col-sm-4 col-xs-6 thumb grid-item post-38424">
                            <div class="halim-item">
                                <a class="halim-thumb" href="{{ route('phim', [$hotMovie->slug]) }}"
                                    title="{{ $hotMovie->title }}">
                                    <figure>
                                        @if (!empty($hotMovie->image))
                                            <img class="lazy img-responsive"
                                                src="{{ asset('uploads/movies/' . $hotMovie->image) }}"
                                                alt="{{ $hotMovie->title }}" title="{{ $hotMovie->title }}">
                                        @else
                                            <img class="lazy img-responsive" src="{{ $hotMovie->link_image }}"
                                                alt="{{ $hotMovie->title }}" title="{{ $hotMovie->title }}">
                                        @endif

                                    </figure>

                                    <span class="status">
                                        @if ($hotMovie->type == 2 && strcmp($hotMovie->episode_total, '1') !== 0)
                                            {{ $hotMovie->episodes_count . '/' . $hotMovie->episode_total }}
                                        @else
                                            @if ($hotMovie->quality && $hotMovie->type != 1)
                                                @if ($hotMovie->quality == 0)
                                                    CAM
                                                @elseif($hotMovie->quality == 1)
                                                    SD
                                                @elseif($hotMovie->quality == 2)
                                                    HD
                                                @elseif($hotMovie->quality == 3)
                                                    Full HD
                                                @endif
                                            @elseif ($hotMovie->type == 2)
                                                @if ($hotMovie->quality == 0)
                                                    CAM
                                                @elseif($hotMovie->quality == 1)
                                                    SD
                                                @elseif($hotMovie->quality == 2)
                                                    HD
                                                @elseif($hotMovie->quality == 3)
                                                    Full HD
                                                @endif
                                            @else
                                                {{ $hotMovie->episodes_count . '/' . $hotMovie->episode_total }}
                                            @endif
                                        @endif
                                    </span>
                                    <span class="episode"><i class="fa fa-play" aria-hidden="true"></i>
                                        @if ($hotMovie->lang == 0)
                                            Vietsub
                                        @else
                                            Thuyết minh
                                        @endif
                                    </span>
                                    <div class="icon_overlay"></div>
                                    <div class="halim-post-title-box">
                                        <div class="halim-post-title ">
                                            <p class="entry-title">{{ $hotMovie->title }}</p>
                                            <p class="original_title">{{ $hotMovie->origin_name }}</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
            <div class="clearfix"></div>
        </div>
        <main id="main-contents" class="col-xs-12 col-sm-12 col-md-8">
            @foreach ($listCategoryByMovie as $category)
                <section id="halim-advanced-widget-2">
                    <div class="section-heading">
                        <a href="{{ route('loai-phim', [$category->slug]) }}" title="{{ $category->title }}">
                            <span class="h-text">{{ $category->title }}</span>
                        </a>

                        <ul class="heading-nav pull-right hidden-xs">
                            <a href="{{ route('loai-phim', [$category->slug]) }}" title="{{ $category->title }}">
                                <li class="section-btn halim_ajax_get_post" data-catid="4" data-showpost="12"
                                    data-widgetid="halim-advanced-widget-4" data-layout="6col">
                                    <span data-text="Xem thêm">
                                    </span>
                                </li>
                            </a>
                        </ul>
                    </div>
                    <div id="halim-advanced-widget-2-ajax-box" class="halim_box">
                        @foreach ($category->movies->take(8) as $movie)
                            <article class="col-md-3 col-sm-3 col-xs-6 thumb grid-item post-37606">
                                <div class="halim-item">
                                    <a class="halim-thumb" href="{{ route('phim', [$movie->slug]) }}">
                                        <figure>
                                            @if (empty($movie->image))
                                                <img class="lazy img-responsive" src="{{ $movie->link_image }}"
                                                    alt=" {{ $movie->title }} " title="{{ $movie->title }}">
                                            @else
                                                <img class="lazy img-responsive"
                                                    src=" {{ asset('uploads/movies/' . $movie->image) }} "
                                                    alt=" {{ $movie->title }} " title="{{ $movie->title }}">
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
                </section>
                <div class="clearfix"></div>
            @endforeach
        </main>
        {{-- Sidebar --}}
        @include('pages.includes.sidebar')
    </div>
    <script>
        jQuery(document).ready(function($) {
            var owl = $('#halim_hot_movies-2');
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
                        items: 5
                    },
                    1000: {
                        items: 5
                    }

                }
            })
        });
    </script>
@endsection
