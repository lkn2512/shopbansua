<div class="sort-product">
    <label for="amount" class="sort-title">Sắp xếp theo</label>
    <p class="sortBy">Tình trạng</p>
    <form>
        @csrf
        <select name="sort" id="sort_condition" class="form-select" aria-label="Default select example">
            <option value="{{ Request::url() }}?sort_by=none">--Tình trạng--</option>
            <option value="{{ Request::url() }}?sort_by=new">Mới nhất</option>
            <option value="{{ Request::url() }}?sort_by=old">Cũ nhất</option>
        </select>
    </form>
    <p class="sortBy">Giá</p>
    <form>
        @csrf
        <select name="sort-price" id="sort_price" class="form-select">
            <option value="{{ Request::url() }}?sort_by=none">--Theo giá--</option>
            <option value="{{ Request::url() }}?sort_by=tang_dan">Giá tăng dần</option>
            <option value="{{ Request::url() }}?sort_by=giam_dan">Giá giảm dần</option>
        </select>
    </form>
    <p class="sortBy">Tên</p>
    <form>
        @csrf
        <select name="sort" id="sort_name" class="form-select" aria-label="Default select example">
            <option value="{{ Request::url() }}?sort_by=none">--Theo tên--</option>
            <option value="{{ Request::url() }}?sort_by=kytu_az">A đến Z</option>
            <option value="{{ Request::url() }}?sort_by=kytu_za">Z đến A</option>
        </select>
    </form>
    <p class="sortBy">Mức giá cụ thể</p>
    <form>
        @csrf
        <p>
            <label for="amount"></label>
            <input class="sliderRangeInput" type="text" id="amount" readonly="">
        </p>
        <div id="slider-range" class="slider-range"></div>
        <input type="hidden" name="start_price" id="start_price">
        <input type="hidden" name="end_price" id="end_price">
        <button type="submit" name="filter_price" class="btn-filter_price">Lọc giá</button>
    </form>
</div>
