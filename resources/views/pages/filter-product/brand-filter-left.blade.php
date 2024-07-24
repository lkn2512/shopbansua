<div class="row filter-container">
    <label class="filer-title">Thương hiệu</label>
    @foreach ($brand_filter as $key => $valueA)
        @php
            $brand_id = [];
            if (isset($_GET['brand'])) {
                $brand_id = explode(',', $_GET['brand']);
            }
        @endphp
        <div class="form-check-filter-left">
            <input type="checkbox" {{ in_array($valueA->brand_id, $brand_id) ? 'checked' : '' }}
                class="form-check-input brand-filter" data-filter="brand" value="{{ $valueA->brand_id }}" name="brand[]"
                id="flexCheckDefault{{ $valueA->brand_id }}">
            <label class="check-label" for="flexCheckDefault{{ $valueA->brand_id }}">{{ $valueA->brand_name }}</label>
        </div>
    @endforeach
</div>
