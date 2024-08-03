<div class="row filter-container">
    <label class="filer-title">Danh mục</label>
    @foreach ($category_filter as $key => $valueB)
        @php
            $category_id = [];
            if (isset($_GET['category'])) {
                $category_id = explode(',', $_GET['category']);
            }
        @endphp
        <div class="form-check-filter">
            <input type="checkbox" {{ in_array($valueB->category_id, $category_id) ? 'checked' : '' }}
                class="form-check-input category-filter" data-filter="category" value="{{ $valueB->category_id }}"
                name="category[]" id="flexCheckDefault{{ $valueB->category_id }}">
            <label class="check-label"
                for="flexCheckDefault{{ $valueB->category_id }}">{{ $valueB->category_name }}</label>
        </div>
    @endforeach
</div>
<script>
    document.querySelectorAll('.form-check-input').forEach(function(element) {
        element.addEventListener('change', function() {
            let params = new URLSearchParams(window.location.search);
            let filterType = this.dataset.filter;
            let values = [];

            document.querySelectorAll(`.${filterType}-filter:checked`).forEach(function(
                checkedElement) {
                values.push(checkedElement.value);
            });

            if (values.length > 0) {
                params.set(filterType, values.join(','));
            } else {
                params.delete(filterType);
            }

            window.location.search = params.toString();
        });
    });
</script>
