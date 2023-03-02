@extends('layout')
@section('content')
    <div class="row container" id="wrapper">
        <div class="halim-panel-filter">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-6">
                        <div class="yoast_breadcrumb hidden-xs"><span><span><a
                                        href="">{{ $listCategoryBySlug->title }}</a> </span></span></div>
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
                    <h1 class="section-title"><span>{{ $listCategoryBySlug->title }}</span></h1>
                </div>
                <div class="halim_box">
                    @foreach ($listMovieBySlug as $movie)
                        <article class="col-md-3 col-sm-3 col-xs-6 thumb grid-item post-37606">
                            <div class="halim-item">
                                <a class="halim-thumb" href="{{ route('movies', $movie->slug) }}">
                                    <figure><img class="lazy img-responsive"
                                            src="{{ asset('uploads/movies/' . $movie->image) }}" alt="{{ $movie->title }}"
                                            title="{{ $movie->title }}">
                                    </figure>
                                    <span class="status">
                                        @if ($listCategoryBySlug->title == 'Phim bộ')
                                            @if ($movie->start_episode != $movie->episode)
                                                Đang chiếu {{ $movie->start_episode }}/{{ $movie->episode }} tập
                                            @else
                                                Hoàn tất {{ $movie->start_episode }}/{{ $movie->episode }} tập
                                            @endif
                                        @else
                                            <td>
                                                @if ($movie->resolution == 0)
                                                    SD
                                                @else
                                                    FULL HD
                                                @endif
                                            </td>
                                        @endif

                                    </span><span class="episode"><i class="fa fa-play" aria-hidden="true"></i>
                                        @if ($movie->subtitle == 0)
                                            Thuyết minh
                                        @else
                                            Việt Sub
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
                    {!! $listMovieBySlug->onEachSide(1)->links() !!}
                </div>
            </section>
        </main>
        {{-- @include('pages.includes.sidebar') --}}
    </div>
@endsection
