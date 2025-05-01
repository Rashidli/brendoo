@include('admin.includes.header')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Əlavə et</h4>
                    </div>
                    <div class="card-body">
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
                                        <div class="col-md-4">
                                            <h5 class="mb-3">Başlıq və Mətn</h5>
                                            <div class="mb-3">
                                                <label class="col-form-label">Başlıq* {{ $lang }}</label>
                                                <input id="mainInput_{{ $lang }}" class="form-control" type="text" value="{{ old($lang . '_title') }}" name="{{ $lang }}_title">
                                                @if($errors->first("{$lang}_title"))
                                                    <small class="form-text text-danger">{{ $errors->first("{$lang}_title") }}</small>
                                                @endif
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label">Qısa text* {{ $lang }}</label>
                                                <input class="form-control sync-input_{{ $lang }}" type="text" value="{{ old($lang . '_short_title') }}" name="{{ $lang }}_short_title">
                                                @if($errors->first("{$lang}_short_title"))
                                                    <small class="form-text text-danger">{{ $errors->first("{$lang}_short_title") }}</small>
                                                @endif
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label">Text* {{ $lang }}</label>
                                                <textarea id="editor_{{ $lang }}" class="form-control" name="{{ $lang }}_description">{{ old($lang . '_description') }}</textarea>
                                                @if($errors->first("{$lang}_description"))
                                                    <small class="form-text text-danger">{{ $errors->first("{$lang}_description") }}</small>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <h5 class="mb-3">Şəkil Etiketləri</h5>
                                            <div class="mb-3">
                                                <label class="col-form-label">Title tag {{ $lang }}</label>
                                                <input class="form-control sync-input_{{ $lang }}" type="text" name="{{ $lang }}_img_title" value="{{old($lang . '_img_title')}}">
                                                @if($errors->first("{$lang}_img_title"))
                                                    <small class="form-text text-danger">{{ $errors->first("{$lang}_img_title") }}</small>
                                                @endif
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label">Alt tag {{ $lang }}</label>
                                                <input class="form-control sync-input_{{ $lang }}" type="text" name="{{ $lang }}_img_alt" value="{{old($lang . '_img_alt')}}">
                                                @if($errors->first("{$lang}_img_alt"))
                                                    <small class="form-text text-danger">{{ $errors->first("{$lang}_img_alt") }}</small>
                                                @endif
                                            </div>

                                        </div>
                                        <div class="col-md-4">
                                            <h5 class="mb-3">Meta Tags</h5>
                                            <div class="mb-3">
                                                <label class="col-form-label">Meta title {{ $lang }}</label>
                                                <input class="form-control sync-input_{{ $lang }}" type="text" name="{{ $lang }}_meta_title" value="{{ old("{$lang}_meta_title") }}">
                                                @if($errors->first("{$lang}_meta_title"))
                                                    <small class="form-text text-danger">{{ $errors->first("{$lang}_meta_title") }}</small>
                                                @endif
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label">Meta description {{ $lang }}</label>
                                                <textarea class="form-control sync-input_{{ $lang }}" name="{{ $lang }}_meta_description">{{ old("{$lang}_meta_description") }}</textarea>
                                                @if($errors->first("{$lang}_meta_description"))
                                                    <small class="form-text text-danger">{{ $errors->first("{$lang}_meta_description") }}</small>
                                                @endif
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label">Meta keywords {{ $lang }}</label>
                                                <textarea class="form-control sync-input_{{ $lang }}" name="{{ $lang }}_meta_keywords">{{ old("{$lang}_meta_keywords") }}</textarea>
                                                @if($errors->first("{$lang}_meta_keywords"))
                                                    <small class="form-text text-danger">{{ $errors->first("{$lang}_meta_keywords") }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Product General Information -->
                        <div class="row mt-4">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="col-form-label">Brend*</label>
                                    <select class="form-control" name="brand_id" id="brandSelect">
                                        <option value="">Seçin</option>
                                        @foreach($brands as $brand)
                                            <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                                {{ $brand->title }}
                                            </option>
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
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->title }}
                                            </option>
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
                                    </select>
                                    @if($errors->first('sub_category_id'))
                                        <small class="form-text text-danger">{{ $errors->first('sub_category_id') }}</small>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label class="col-form-label">Alt Kateqoriya (3cü səviyə)</label>
                                    <select class="form-control" name="third_category_id" id="thirdCategorySelect">
                                        <option value="">Seçin</option>
                                    </select>
                                    @if($errors->first('third_category_id'))
                                        <small class="form-text text-danger">{{ $errors->first('third_category_id') }}</small>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label class="col-form-label">Status*</label>
                                    <select class="form-control" name="status">
                                        <option value="saytda" {{ old('status') == 'saytda' ? 'selected' : '' }}>Saytda</option>
                                        <option value="bitib" {{ old('status') == 'bitib' ? 'selected' : '' }}>Bitib</option>
                                        <option value="olmayacaq" {{ old('status') == 'olmayacaq' ? 'selected' : '' }}>Olmayacaq</option>
                                    </select>
                                    @if($errors->first('status'))
                                        <small class="form-text text-danger">{{ $errors->first('status') }}</small>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
{{--                                <div class="mb-3">--}}
{{--                                    <label class="col-form-label">Məhsul kodu</label>--}}
{{--                                    <input class="form-control" type="text" step="0.01" name="code" value="{{ old('code') }}">--}}
{{--                                    @if($errors->first('code'))--}}
{{--                                        <small class="form-text text-danger">{{ $errors->first('code') }}</small>--}}
{{--                                    @endif--}}
{{--                                </div>--}}
                                <div class="mb-3">
                                    <label class="col-form-label">Qiymət*</label>
                                    <input id="price" class="form-control" type="number" step="0.01" name="price" value="{{ old('price') }}">
                                    @if($errors->first('price'))
                                        <small class="form-text text-danger">{{ $errors->first('price') }}</small>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label class="col-form-label">Endirim (%)</label>
                                    <input id="discount" class="form-control" type="number" step="0.01" name="discount" value="{{ old('discount') }}">
                                    @if($errors->first('discount'))
                                        <small class="form-text text-danger">{{ $errors->first('discount') }}</small>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label class="col-form-label">Endirimli qiymət</label>
                                    <input id="discounted_price" class="form-control" type="number" step="0.01" name="discounted_price" value="{{ old('discounted_price') }}">
                                    @if($errors->first('discounted_price'))
                                        <small class="form-text text-danger">{{ $errors->first('discounted_price') }}</small>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Maya Dəyəri*</label>
                                    <input class="form-control" type="number" step="0.01" name="cost_price" value="{{ old('cost_price') }}">
                                    @if($errors->first('cost_price'))
                                        <small class="form-text text-danger">{{ $errors->first('cost_price') }}</small>
                                    @endif
                                </div>


                                <div class="mb-3">
                                    <label class="col-form-label">Vahidi</label>
                                    <input class="form-control" type="text" name="unit" value="{{ old('unit') }}">
                                    @if($errors->first('unit'))
                                        <small class="form-text text-danger">{{ $errors->first('unit') }}</small>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="col-form-label">Bədən ölçüləri* (325X386)</label>
                                    <input class="form-control" type="file" name="size_image">
                                    @if($errors->first('size_image'))
                                        <small class="form-text text-danger">{{ $errors->first('size_image') }}</small>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label class="col-form-label">Şəkil* (325X386)</label>
                                    <input class="form-control" type="file" name="image">
                                    @if($errors->first('image'))
                                        <small class="form-text text-danger">{{ $errors->first('image') }}</small>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label class="col-form-label">Slider Şəkilləri (670x628)</label>
                                    <input class="form-control" type="file" name="slider_images[]" multiple>
                                    @if($errors->first('slider_images'))
                                        <small class="form-text text-danger">{{ $errors->first('slider_images') }}</small>
                                    @endif
                                </div>
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="is_new" name="is_new" {{ old('is_new') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_new">Yeni</label>
                                </div>
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" {{ old('is_active') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">Aktiv</label>
                                </div>
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="is_return" name="is_return" {{ old('is_return') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_return">Qaytarıla bilər</label>
                                </div>
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="is_season" name="is_season" {{ old('is_season') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_season">Mövsümi təklif?</label>
                                </div>
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="is_popular" name="is_popular" {{ old('is_popular') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_popular">Popular məhsul?</label>
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

@include('admin.includes.footer')
<script>



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

        const calculateDiscountedPrice = () => {
            const price = parseFloat(priceInput.value) || 0;
            const discount = parseFloat(discountInput.value) || 0;
            const discountedPrice = price - (price * discount / 100);
            discountedPriceInput.value = discountedPrice.toFixed(2);
        };

        const calculateDiscountPercentage = () => {
            const price = parseFloat(priceInput.value) || 0;
            const discountedPrice = parseFloat(discountedPriceInput.value) || 0;
            if (price > 0) {
                const discount = ((price - discountedPrice) / price) * 100;
                discountInput.value = Math.round(discount);
            }
        };

        discountInput.addEventListener("input", calculateDiscountedPrice);
        discountedPriceInput.addEventListener("input", calculateDiscountPercentage);
    });

    $('#categorySelect').on('change', function () {
        var categoryId = $(this).val();
        var subCategorySelect = $('#subCategorySelect');
        // subCategorySelect.html('<option value="">Alt kateqoriya seçin</option>');

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

                        var selectedSubCategory = "{{ request('subcategory') }}";
                        if (selectedSubCategory) {
                            subCategorySelect.val(selectedSubCategory).trigger('change');
                        }
                    }
                },
                error: function (xhr) {
                    console.error('Error fetching data:', xhr.responseText);
                }
            });
        }
    });

    $('#subCategorySelect').on('change', function () {
        var subCategoryId = $(this).val();
        var thirdCategorySelect = $('#thirdCategorySelect');
        thirdCategorySelect.html('<option value="">Alt kateqoriya seçin</option>');

        if (subCategoryId) {
            $.ajax({
                url: '/sub_categories/' + subCategoryId + '/details', // Corrected URL
                type: 'GET',
                success: function (response) {
                    if (response.third_categories) {
                        response.third_categories.forEach(function (thirdCategory) {
                            thirdCategorySelect.append(
                                '<option value="' + thirdCategory.id + '">' + thirdCategory.title + '</option>'
                            );
                        });

                        var selectedThirdCategory = "{{ request('thirdcategory') }}";
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
    });

</script>




