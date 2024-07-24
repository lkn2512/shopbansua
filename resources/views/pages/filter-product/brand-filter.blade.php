<div class="row filter-container">
    <label class="filer-title">Thương hiệu</label>
    @foreach ($brand_filter as $key => $valueB)
        @php
            $brand_id = [];
            if (isset($_GET['brand'])) {
                $brand_id = explode(',', $_GET['brand']);
            }
        @endphp
        <div class="form-check-filter">
            <input type="checkbox" {{ in_array($valueB->brand_id, $brand_id) ? 'checked' : '' }}
                class="form-check-input brand-filter" data-filter="brand" value="{{ $valueB->brand_id }}" name="brand[]"
                id="flexCheckDefault{{ $valueB->brand_id }}">
            <label class="check-label" for="flexCheckDefault{{ $valueB->brand_id }}">{{ $valueB->brand_name }}</label>
        </div>
    @endforeach
</div>
