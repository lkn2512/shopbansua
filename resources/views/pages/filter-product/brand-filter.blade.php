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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        function handleFilterChange() {
            let params = new URLSearchParams(window.location.search);
            let brands = [];
            document.querySelectorAll('.brand-filter:checked').forEach(function(element) {
                brands.push(element.value);
            });
            if (brands.length > 0) {
                params.set('brand', brands.join(','));
            } else {
                params.delete('brand');
            }
            window.location.search = params.toString();
        }
        document.querySelectorAll('.brand-filter').forEach(function(element) {
            element.addEventListener('change', handleFilterChange);
        });
    });
</script>
