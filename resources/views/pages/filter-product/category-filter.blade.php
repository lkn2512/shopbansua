<div class="row filter-container">
    <label class="filer-title">Danh mục</label>
    @foreach ($category as $key => $valueB)
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
