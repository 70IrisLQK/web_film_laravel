<div class="section-bar clearfix">
    <form action="{{ route('filter') }}" method="get" class="form-filter">
        @csrf
        <div class="filter-item">
            <select class="input form-control" name="order">
                <option value="">---Sắp xếp---</option>
                <option value="date">Ngày đăng</option>
                <option value="year_release">Năm sản xuất</option>
                <option value="name_a_z">Tên phim</option>
                <option value="watch_views">Lượt xem</option>
            </select>
        </div>
        <div class="filter-item">
            <select class="form-control" name="genre">
                <option value="">---Thể loại---</option>
                @foreach ($listGenres as $genreFilter)
                    <option {{ isset($_GET['genre']) && $_GET['genre'] == $genreFilter->id ? 'selected' : '' }}
                        value={{ $genreFilter->id }}>{{ $genreFilter->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="filter-item">
            <select class="form-control" name="country">
                <option value="">---Quốc gia---</option>
                @foreach ($listCountries as $countryFilter)
                    <option {{ isset($_GET['country']) && $_GET['country'] == $countryFilter->id ? 'selected' : '' }}
                        value={{ $countryFilter->id }}>{{ $countryFilter->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="filter-item">
            @php
                if (isset($_GET['year'])) {
                    $year = $_GET['year'];
                } else {
                    $year = null;
                }
            @endphp
            {!! Form::selectYear('year', 2010, 2023, $year, ['class' => 'form-control', 'placeholder' => '---Năm---']) !!}
        </div>
        <div class="col-md-2">
            <input type="submit" name="filter" class="btn btn-sm btn-default" value="Lọc phim" />
        </div>
    </form>
</div>
