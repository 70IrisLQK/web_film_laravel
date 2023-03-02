<aside>
    <div id="sidebar" class="nav-collapse">
        <!-- sidebar menu start-->
        <div class="leftside-navigation">
            <ul class="sidebar-menu" id="nav-accordion">
                <li>
                    <a class="active" href="index.html">
                        <i class="fa fa-dashboard"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Category Management</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{ route('category.index') }}">List Category</a></li>
                        <li><a href="{{ route('category.create') }}">Create Category</a></li>
                    </ul>
                </li>

                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-globe"></i>
                        <span>Country Management</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{ route('country.index') }}">List Country</a></li>
                        <li><a href="{{ route('country.create') }}">Create Country</a></li>
                    </ul>
                </li>

                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-building"></i>
                        <span>Genre Management</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{ route('genre.index') }}">List Genre</a></li>
                        <li><a href="{{ route('genre.create') }}">Create Genre</a></li>
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-film"></i>
                        <span>Movie Management</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{ route('movie.index') }}">List Movie</a></li>
                        <li><a href="{{ route('movie.create') }}">Create Movie</a></li>
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-video-camera"></i>
                        <span>Episode Management</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{ route('episode.index') }}">List Episode</a></li>
                        <li><a href="{{ route('episode.create') }}">Create Episode</a></li>
                    </ul>
                </li>

            </ul>
        </div>
        <!-- sidebar menu end-->
    </div>
</aside>
