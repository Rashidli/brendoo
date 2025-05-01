<style>
    .slider-section {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        justify-content: start;
    }

    .slider-image-container {
        display: inline-block;
        position: relative;
        margin: 10px;
    }

    .slider-image-container img {
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        width: 100px;
        height: 100px;
        object-fit: cover;
    }

    .slider-image-container img:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
    }

    .slider-image-container .delete-slider-button {
        position: absolute;
        top: -5px;
        right: -5px;
        font-size: 10px;
        padding: 5px 8px;
        border-radius: 50%;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .slider-image-container:hover .delete-slider-button {
        opacity: 1;
    }

    .slider-form-group {
        margin-top: 20px;
        width: 100%;
    }

    .slider-file-input {
        border: 1px solid #ccc;
        padding: 8px;
        border-radius: 5px;
        width: 100%;
    }
     .card {
         transition: all 0.3s ease;
     }

    .option-card {
        min-height: 180px;
    }
    .form-check-input {
        cursor: pointer;
    }
    .filter-section {
        padding: 15px;
        border-radius: 5px;
        background-color: #f8f9fa;
        margin-bottom: 20px;
    }
    .search-box {
        width: 250px;
    }
    .hidden-option {
        display: none;
    }

</style>
@include('admin.includes.header')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            @if(session('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif
            <form action="{{ route('products.update', $product->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Redaktə et</h4>
                    </div>
                    <div class="card-body">
                        <nav aria-label="breadcrumb" style="margin-bottom: 20px;">
                            <ol class="breadcrumb bg-light p-3 rounded">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Siyahı</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $product->translate('en')?->title }}</li>
                            </ol>
                        </nav>
                        <!-- Language Tabs -->
                        <ul class="nav nav-tabs" id="languageTab" role="tablist">
                            @foreach(['en', 'ru'] as $lang)
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link @if($loop->first) active @endif" id="{{ $lang }}-tab" data-bs-toggle="tab" href="#{{ $lang }}" role="tab" aria-controls="{{ $lang }}" aria-selected="true">
                                        {{ strtoupper($lang) }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        <br>
                        <div class="tab-content" id="languageTabContent">
                            @foreach(['en', 'ru'] as $lang)
                                <div class="tab-pane fade @if($loop->first) show active @endif" id="{{ $lang }}" role="tabpanel" aria-labelledby="{{ $lang }}-tab">
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="card mb-3">
                                                <div class="card-header">Başlıq Mətn</div>
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <label class="col-form-label">Başlıq* {{ $lang }}</label>
                                                        <input id="mainInput_{{ $lang }}" class="form-control" type="text" name="{{ $lang }}_title" value="{{ $product->translate($lang)->title }}">
                                                        @if($errors->first($lang.'_title'))
                                                            <small class="form-text text-danger">{{ $errors->first($lang.'_title') }}</small>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="col-form-label">Qısa text* {{ $lang }}</label>
                                                        <input class="form-control sync-input_{{ $lang }}" type="text" name="{{ $lang }}_short_title" value="{{ $product->translate($lang)->short_title }}">
                                                        @if($errors->first($lang.'_short_title'))
                                                            <small class="form-text text-danger">{{ $errors->first($lang.'_short_title') }}</small>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="col-form-label">Text* {{ $lang }}</label>
                                                        <textarea id="editor_{{ $lang }}" class="form-control " name="{{ $lang }}_description">{{ $product->translate($lang)->description }}</textarea>
                                                        @if($errors->first($lang.'_description'))
                                                            <small class="form-text text-danger">{{ $errors->first($lang.'_description') }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="card mb-3">
                                                <div class="card-header">Alt və Title Taglar</div>
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <label class="col-form-label">Alt tag {{ $lang }}</label>
                                                        <input class="form-control sync-input_{{ $lang }}" type="text" name="{{ $lang }}_img_alt" value="{{ $product->translate($lang)->img_alt }}">
                                                        @if($errors->first($lang.'_img_alt'))
                                                            <small class="form-text text-danger">{{ $errors->first($lang.'_img_alt') }}</small>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="col-form-label">Title tag {{ $lang }}</label>
                                                        <input class="form-control sync-input_{{ $lang }}" type="text" name="{{ $lang }}_img_title" value="{{ $product->translate($lang)->img_title }}">
                                                        @if($errors->first($lang.'_img_title'))
                                                            <small class="form-text text-danger">{{ $errors->first($lang.'_img_title') }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-4">
                                            <div class="card mb-3">
                                                <div class="card-header">Meta Taglar</div>
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <label class="col-form-label">Meta title {{ $lang }}</label>
                                                        <input class="form-control sync-input_{{ $lang }}" type="text" name="{{ $lang }}_meta_title" value="{{ $product->translate($lang)->meta_title }}">
                                                        @if($errors->first($lang.'_meta_title'))
                                                            <small class="form-text text-danger">{{ $errors->first($lang.'_meta_title') }}</small>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="col-form-label">Meta description {{ $lang }}</label>
                                                        <textarea class="form-control sync-input_{{ $lang }}" name="{{ $lang }}_meta_description">{{ $product->translate($lang)->meta_description }}</textarea>
                                                        @if($errors->first($lang.'_meta_description'))
                                                            <small class="form-text text-danger">{{ $errors->first($lang.'_meta_description') }}</small>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="col-form-label">Meta keywords {{ $lang }}</label>
                                                        <textarea class="form-control sync-input_{{ $lang }}" name="{{ $lang }}_meta_keywords">{{ $product->translate($lang)->meta_keywords }}</textarea>
                                                        @if($errors->first($lang.'_meta_keywords'))
                                                            <small class="form-text text-danger">{{ $errors->first($lang.'_meta_keywords') }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Product General Information -->
                        <div class="row mt-4">
                            <div class="col-4">
                                <div class="mb-3">
                                    <label class="col-form-label">Brend*</label>
                                    <select class="form-control" name="brand_id">
                                        <option value="">Seçin</option>
                                        @foreach($brands as $brand)
                                            <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>{{ $brand->title }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->first('brand_id'))
                                        <small class="form-text text-danger">{{ $errors->first('brand_id') }}</small>
                                    @endif
                                </div>


                                <div class="mb-3">
                                    <label class="col-form-label">Kateqoriya*</label>
                                    <select class="form-control" name="category_id" id="categorySelect">
                                        <option value="">Seçin</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->title }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->first('category_id'))
                                        <small class="form-text text-danger">{{ $errors->first('category_id') }}</small>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label class="col-form-label">Alt Kateqoriya</label>
                                    <select class="form-control" name="sub_category_id" id="subCategorySelect">
                                        <option value="">Seçin</option>
                                        @foreach($subCategories as $subCategory)
                                            <option value="{{ $subCategory->id }}" {{ old('sub_category_id', $product->sub_category_id) == $subCategory->id ? 'selected' : '' }}>{{ $subCategory->title }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->first('sub_category_id'))
                                        <small class="form-text text-danger">{{ $errors->first('sub_category_id') }}</small>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label class="col-form-label">Alt Kateqoriya (3cü səviyə)</label>
                                    <select class="form-control" name="third_category_id" id="thirdCategorySelect">
                                        <option value="">Seçin</option>
                                        @foreach($thirdCategories as $thirdCategory)
                                            <option value="{{ $thirdCategory->id }}" {{ old('third_category_id', $product->third_category_id) == $thirdCategory->id ? 'selected' : '' }}>{{ $thirdCategory->title }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->first('third_category_id'))
                                        <small class="form-text text-danger">{{ $errors->first('third_category_id') }}</small>
                                    @endif
                                </div>


                                <div class="mb-3">
                                    <label class="col-form-label">Status*</label>
                                    <select class="form-control" name="status">
                                        <option value="saytda" {{ old('status', $product->status) == 'saytda' ? 'selected' : '' }}>Saytda</option>
                                        <option value="bitib" {{ old('status', $product->status) == 'bitib' ? 'selected' : '' }}>Bitib</option>
                                        <option value="olmayacaq" {{ old('status', $product->status) == 'olmayacaq' ? 'selected' : '' }}>Olmayacaq</option>
                                    </select>
                                    @if($errors->first('status'))
                                        <small class="form-text text-danger">{{ $errors->first('status') }}</small>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="mb-3">
                                    <label class="col-form-label">Məhsul kodu</label>
                                    <input class="form-control" type="text" name="code" value="{{ old('code', $product->code) }}">
                                    @if($errors->first('code'))
                                        <small class="form-text text-danger">{{ $errors->first('code') }}</small>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Türk Qiyməti (tl)*</label>
                                    <input id="tr_price" class="form-control" type="number" step="0.01" name="tr_price" value="{{ old('tr_price', $product->tr_price) }}">
                                    @if($errors->first('tr_price'))
                                        <small class="form-text text-danger">{{ $errors->first('tr_price') }}</small>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Qiymət rubl*</label>
                                    <input id="price" class="form-control" type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}">
                                    @if($errors->first('price'))
                                        <small class="form-text text-danger">{{ $errors->first('price') }}</small>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Endirim (%)</label>
                                    <input id="discount" class="form-control" type="number" step="0.01" name="discount" value="{{ old('discount', $product->discount) }}">
                                    @if($errors->first('discount'))
                                        <small class="form-text text-danger">{{ $errors->first('discount') }}</small>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Endirimli qiymət</label>
                                    <input id="discounted_price" class="form-control" type="number" step="0.01" name="discounted_price" value="{{ old('discounted_price', $product->discounted_price) }}">
                                    @if($errors->first('discounted_price'))
                                        <small class="form-text text-danger">{{ $errors->first('discounted_price') }}</small>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Maya Dəyəri*</label>
                                    <input class="form-control" type="number" step="0.01" name="cost_price" value="{{ old('cost_price', $product->cost_price) }}">
                                    @if($errors->first('cost_price'))
                                        <small class="form-text text-danger">{{ $errors->first('cost_price') }}</small>
                                    @endif
                                </div>


                                <div class="mb-3">
                                    <label class="col-form-label">Vahidi</label>
                                    <input class="form-control" type="text" name="unit" value="{{ old('unit', $product->unit) }}">
                                    @if($errors->first('unit'))
                                        <small class="form-text text-danger">{{ $errors->first('unit') }}</small>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="card mb-3">
                                    <div class="card-header">Slider</div>
                                    <div class="card-body slider-section">
                                        @foreach($product->sliders as $slider)
                                            <div class="slider-image-container" data-slider-id="{{ $slider->id }}">
                                                <img src="{{$slider->image }}" class="uploaded-image" alt="{{ $slider->image }}">
                                                <a class="btn btn-danger btn-sm delete-slider-button" href="{{ route('delete-slider-image', ['id' => $slider->id]) }}">Sil</a>
                                            </div>
                                        @endforeach
                                        <div class="slider-form-group">
                                            <label for="slider-images">Slider Şəkillər:</label>
                                            <input id="slider-images" type="file" name="slider_images[]" multiple class="slider-file-input">
                                            @if($errors->first('slider_images'))
                                                <small class="form-text text-danger">{{ $errors->first('slider_images') }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Şəkil*</label>
                                    <input class="form-control" type="file" name="image">
                                    <img src="{{ $product->image }}" alt="Məhsul şəkli" class="img-thumbnail mt-2" width="150">
                                    @if($errors->first('image'))
                                        <small class="form-text text-danger">{{ $errors->first('image') }}</small>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Bədən razmerləri*</label>
                                    <input class="form-control" type="file" name="size_image">
                                    <img src="{{ asset('storage/' . $product->size_image) }}" alt="Bədən razmerləri" class="img-thumbnail mt-2" width="150">
                                    @if($errors->first('size_image'))
                                        <small class="form-text text-danger">{{ $errors->first('size_image') }}</small>
                                    @endif
                                </div>

                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="is_new" name="is_new" {{ old('is_new', $product->is_new) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_new">Yeni</label>
                                </div>
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">Aktiv</label>
                                </div>
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="is_return" name="is_return" {{ old('is_return', $product->is_return) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_return">Qaytarıla bilər</label>
                                </div>
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="is_season" name="is_season" {{ old('is_season', $product->is_season) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_season">Mövsümi təklif?</label>
                                </div>
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="is_popular" name="is_popular" {{ old('is_popular', $product->is_popular) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_popular">Popular məhsul?</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="card mb-3 shadow">
                                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">Filterləri təyin et</h5>
                                        <div class="search-box">
                                            <input type="text" id="filterSearch" class="form-control form-control-sm" placeholder="Filter seçimləri axtar...">
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        @foreach($product->category->filters ?? [] as $filter)
                                            <div class="mb-4 filter-section">
                                                <h6 class="text-secondary fw-bold">{{ $filter->title }}</h6>
                                                <input type="hidden" name="filter_id[]" value="{{ $filter->id }}">
                                                <div class="row option-container">
                                                    @foreach($filter->options as $option)
                                                        <div class="col-md-2 col-sm-4 col-6 mb-3 option-card">
                                                            <div class="card h-100 border p-2">
                                                                <div class="card-body p-2">
                                                                    <!-- Option Title -->
                                                                    <h6 class="card-title mb-2">{{ $option->title }}</h6>

                                                                    <!-- Checkbox for Selection -->
                                                                    <div class="form-check form-switch mb-2">
                                                                        <input
                                                                            type="checkbox"
                                                                            name="selected_options[{{ $filter->id }}][]"
                                                                            class="form-check-input"
                                                                            value="{{ $option->id }}"
                                                                            id="option-{{ $filter->id }}-{{ $option->id }}"
                                                                            {{ $product->options->contains(function ($prodOption) use ($option) {
                                                                                return $prodOption->id == $option->id;
                                                                            }) ? 'checked' : '' }}
                                                                        >
                                                                        <label class="form-check-label" for="option-{{ $filter->id }}-{{ $option->id }}">
                                                                            Seç
                                                                        </label>
                                                                    </div>

                                                                    <!-- Radio Button for Default -->
                                                                    <div class="form-check mb-2">
                                                                        <input
                                                                            type="radio"
                                                                            name="default_option[{{ $filter->id }}]"
                                                                            class="form-check-input"
                                                                            value="{{ $option->id }}"
                                                                            id="default-option-{{ $filter->id }}-{{ $option->id }}"
                                                                            {{ $product->options->contains(function ($prodOption) use ($option) {
                                                                                return $prodOption->id == $option->id && $prodOption->pivot->is_default;
                                                                            }) ? 'checked' : '' }}
                                                                        >
                                                                        <label class="form-check-label" for="default-option-{{ $filter->id }}-{{ $option->id }}">
                                                                            Default
                                                                        </label>
                                                                    </div>

                                                                    <!-- Stock Checkbox -->
                                                                    <div class="form-check">
                                                                        <input
                                                                            type="checkbox"
                                                                            name="is_stock[{{ $filter->id }}][{{ $option->id }}]"
                                                                            class="form-check-input"
                                                                            id="is-stock-{{ $filter->id }}-{{ $option->id }}"
                                                                            {{ $product->options->contains(function ($prodOption) use ($option) {
                                                                                return $prodOption->id == $option->id && $prodOption->pivot->is_stock;
                                                                            }) ? 'checked' : '' }}
                                                                        >
                                                                        <label class="form-check-label" for="is-stock-{{ $filter->id }}-{{ $option->id }}">
                                                                            Stokda var
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    @error('filters.*.options')
                                    <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                    @error('filters.*.default')
                                    <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 text-end">
                            <button class="btn btn-primary">Yadda saxla</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal for Image Preview -->
<div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-labelledby="imagePreviewLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img id="previewImage" src="" alt="Şəkil" class="img-fluid">
            </div>
        </div>
    </div>
</div>

@include('admin.includes.footer')

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const images = document.querySelectorAll('.uploaded-image');
        const previewImage = document.getElementById('previewImage');
        const modal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));

        images.forEach(image => {
            image.addEventListener('click', function () {
                previewImage.src = this.src;
                modal.show();
            });
        });
    });

    const mainInputen = document.getElementById('mainInput_en');
    const otherInputsen = document.querySelectorAll('.sync-input_en');

    mainInputen.addEventListener('input', function() {
        otherInputsen.forEach(input => {
            input.value = this.value;
        });
    });

    const mainInputru = document.getElementById('mainInput_ru');
    const otherInputsru = document.querySelectorAll('.sync-input_ru');

    mainInputru.addEventListener('input', function() {
        otherInputsru.forEach(input => {
            input.value = this.value;
        });
    });


    document.addEventListener("DOMContentLoaded", () => {
        const priceInput = document.getElementById("price");
        const discountInput = document.getElementById("discount");
        const discountedPriceInput = document.getElementById("discounted_price");

        const calculateDiscountPercentage = () => {
            const price = parseFloat(priceInput.value) || 0;
            const discountedPrice = parseFloat(discountedPriceInput.value) || 0;
            if (price > 0) {
                const discount = ((price - discountedPrice) / price) * 100;
                discountInput.value = Math.round(discount);
            }
        };

        const calculateDiscountedPrice = () => {
            const price = parseFloat(priceInput.value) || 0;
            const discount = parseFloat(discountInput.value) || 0;
            const discountedPrice = price - (price * discount / 100);
            discountedPriceInput.value = discountedPrice.toFixed(2);
        };

        priceInput.addEventListener("input", () => {
            calculateDiscountedPrice();
            calculateDiscountPercentage();
        });
        discountInput.addEventListener("input", calculateDiscountedPrice);
        discountedPriceInput.addEventListener("input", calculateDiscountPercentage);
    });


    $(document).ready(function () {
        let initialLoad = true;

        function loadSubCategories(categoryId, selectedSubCategory, callback) {
            var subCategorySelect = $('#subCategorySelect');
            var thirdCategorySelect = $('#thirdCategorySelect');
            subCategorySelect.html('<option value="">Alt kateqoriya seçin</option>');
            thirdCategorySelect.html('<option value="">Alt kateqoriya seçin</option>');

            if (categoryId) {
                $.ajax({
                    url: '/categories/' + categoryId + '/details',
                    type: 'GET',
                    success: function (response) {
                        if (response.sub_categories) {
                            response.sub_categories.forEach(function (subCategory) {
                                subCategorySelect.append(
                                    '<option value="' + subCategory.id + '">' + subCategory.title + '</option>'
                                );
                            });

                            if (selectedSubCategory) {
                                subCategorySelect.val(selectedSubCategory);
                                if (callback) callback(selectedSubCategory);
                            }
                        }
                    },
                    error: function (xhr) {
                        console.error('Error fetching data:', xhr.responseText);
                    }
                });
            }
        }

        function loadThirdCategories(subCategoryId, selectedThirdCategory) {
            var thirdCategorySelect = $('#thirdCategorySelect');
            thirdCategorySelect.html('<option value="">Alt kateqoriya seçin</option>');

            if (subCategoryId) {
                $.ajax({
                    url: '/sub_categories/' + subCategoryId + '/details',
                    type: 'GET',
                    success: function (response) {
                        if (response.third_categories) {
                            response.third_categories.forEach(function (thirdCategory) {
                                thirdCategorySelect.append(
                                    '<option value="' + thirdCategory.id + '">' + thirdCategory.title + '</option>'
                                );
                            });

                            if (selectedThirdCategory) {
                                thirdCategorySelect.val(selectedThirdCategory);
                            }
                        }
                    },
                    error: function (xhr) {
                        console.error('Error fetching data:', xhr.responseText);
                    }
                });
            }
        }

        $('#categorySelect').change(function () {
            if (!initialLoad) { // İlk yüklənmədən sonra işləsin
                var categoryId = $(this).val();
                loadSubCategories(categoryId, null, null);
            }
        });

        $('#subCategorySelect').change(function () {
            var subCategoryId = $(this).val();
            loadThirdCategories(subCategoryId, null);
        });

        // Səhifə yükləndikdə seçilmiş dəyərləri yoxlayır və uyğun olaraq kateqoriyaları yükləyir
        var selectedCategory = "{{ old('category_id', $product->category_id) }}";
        var selectedSubCategory = "{{ old('sub_category_id', $product->sub_category_id) }}";
        var selectedThirdCategory = "{{ old('third_category_id', $product->third_category_id) }}";

        if (selectedCategory) {
            loadSubCategories(selectedCategory, selectedSubCategory, function(subCategoryId) {
                loadThirdCategories(subCategoryId, selectedThirdCategory);
                initialLoad = false; // İlk yüklənmədən sonra dəyişən false olur ki, change eventi yenidən işləsin
            });
        } else {
            initialLoad = false; // Əgər heç bir kateqoriya seçilməyibsə də, dəyişəni false edirik
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('filterSearch');

        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const optionCards = document.querySelectorAll('.option-card');

            optionCards.forEach(card => {
                const optionText = card.textContent.toLowerCase();
                if (optionText.includes(searchTerm)) {
                    card.classList.remove('hidden-option');
                    // Show the parent filter section if it was hidden
                    card.closest('.filter-section').style.display = 'block';
                } else {
                    card.classList.add('hidden-option');
                    // Hide the parent filter section if all options are hidden
                    const section = card.closest('.filter-section');
                    const visibleOptions = section.querySelectorAll('.option-card:not(.hidden-option)');
                    if (visibleOptions.length === 0) {
                        section.style.display = 'none';
                    }
                }
            });
        });
    });


</script>
