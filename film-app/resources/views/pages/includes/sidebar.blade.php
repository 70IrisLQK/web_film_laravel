<aside id="sidebar" class="col-xs-12 col-sm-12 col-md-4">
    <div id="halim_tab_popular_videos-widget-7" class="widget halim_tab_popular_videos-widget">
        <div class="section-bar clearfix">
            <div class="section-title">
                <span>Phim sắp chiếu</span>
            </div>
        </div>
        <section class="tab-content">
            <div role="tabpanel" class="tab-pane active halim-ajax-popular-post">
                <div class="halim-ajax-popular-post-loading hidden"></div>
                <div id="halim-ajax-popular-post" class="popular-post">
                    @foreach ($listTrailerMovies->take(5) as $trailerMovie)
                        <div class="item post-37176">
                            <a href="{{ route('phim', [$trailerMovie->slug]) }}" title="CHỊ MƯỜI BA: BA NGÀY SINH TỬ">
                                <div class="item-link">
                                    @if (!empty($trailerMovie->image))
                                        <img src="{{ asset('uploads/movies/' . $trailerMovie->image) }}"
                                            class="lazy post-thumb" alt="{{ $trailerMovie->title }}"
                                            title="{{ $trailerMovie->title }}" />
                                    @else
                                        <img src="{{ $trailerMovie->link_image }}" class="lazy post-thumb"
                                            alt="{{ $trailerMovie->title }}" title="{{ $trailerMovie->title }}" />
                                    @endif
                                    <span class="is_trailer">Trailer</span>
                                </div>
                                <p class="title">{{ $trailerMovie->title }}</p>
                            </a>
                            <div class="viewsCount" style="color: #9d9d9d;">{{ $trailerMovie->year }}</div>
                            <div style="float: left;">
                                <span class="user-rate-image post-large-rate stars-large-vang"
                                    style="display: block;/* width: 100%; */">
                                    <span style="width: 0%"></span>
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        <div class="clearfix"></div>
    </div>
</aside>
<aside id="sidebar" class="col-xs-12 col-sm-12 col-md-4">
    <div id="halim_tab_popular_videos-widget-7" class="widget halim_tab_popular_videos-widget">
        <div class="section-bar clearfix">
            <div class="section-title">
                <span>Top Trending</span>
            </div>
        </div>
        <ul class="nav nav-pills mb-3 tabs" id="pills-tab" role="tablist">
            <li class="nav-item tab active">
                <a class="nav-link filter-sidebar" id="pills-home-tab" data-toggle="pill" href="#day" role="tab"
                    aria-controls="pills-home" aria-selected="true">Ngày</a>
            </li>
            <li class="nav-item tab">
                <a class="nav-link filter-sidebar" id="pills-profile-tab" data-toggle="pill" href="#week"
                    role="tab" aria-controls="pills-profile" aria-selected="false">Tháng</a>
            </li>
            <li class="nav-item tab">
                <a class="nav-link filter-sidebar" id="pills-contact-tab" data-toggle="pill" href="#month"
                    role="tab" aria-controls="pills-contact" aria-selected="false">Năm</a>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div id="halim-ajax-popular-post-default" class="popular-post">
                <span id="show_data_default">
                </span>
            </div>
            <div class="tab-pane fade show active" id="week" role="tabpanel" aria-labelledby="pills-home-tab">
                <div id="halim-ajax-popular-post" class="popular-post">
                    <span id="show_data">
                    </span>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</aside>
