@include('admin.includes.header')

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <form action="{{ route('banners.update', $banner->id) }}" method="post" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Banner Redaktə Et</h4>
                        <div class="row">
                            <div class="col-6">
                                <!-- Başlıq və Mətn -->
                                <div class="mb-3">
                                    <label class="col-form-label">Başlıq en</label>
                                    <input class="form-control" type="text" name="en_title" value="{{ old('en_title', $banner->translate('en')->title) }}">
                                    @if($errors->first('en_title'))
                                        <small class="form-text text-danger">{{ $errors->first('en_title') }}</small>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Başlıq ru</label>
                                    <input class="form-control" type="text" name="ru_title" value="{{ old('ru_title', $banner->translate('ru')->title) }}">
                                    @if($errors->first('ru_title'))
                                        <small class="form-text text-danger">{{ $errors->first('ru_title') }}</small>
                                    @endif
                                </div>
                                <!-- Başlıq və Mətn -->
                                <div class="mb-3">
                                    <label class="col-form-label">Text en</label>
                                    <input class="form-control" type="text" name="en_description" value="{{ old('en_description', $banner->translate('en')->description) }}">
                                    @if($errors->first('en_description'))
                                        <small class="form-text text-danger">{{ $errors->first('en_description') }}</small>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Text ru</label>
                                    <input class="form-control" type="text" name="ru_description" value="{{ old('ru_description', $banner->translate('ru')->description) }}">
                                    @if($errors->first('ru_description'))
                                        <small class="form-text text-danger">{{ $errors->first('ru_description') }}</small>
                                    @endif
                                </div>

                                <!-- Filtr Sahələri -->
                                <div class="mb-3">
                                    <label class="col-form-label">Kateqoriya</label>
                                    <select class="form-control js-example-basic-single" name="category_id" id="category_id">
                                        <option value="">Seçin</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $banner->filter_conditions['category_id'] ?? '') == $category->id ? 'selected' : '' }}>{{ $category->title }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Sub Kateqoriya</label>
                                    <select class="form-control js-example-basic-single" name="sub_category_id" id="sub_category_id">
                                        <option value="">Seçin</option>
                                        @foreach ($subCategories as $subCategory)
                                            <option value="{{ $subCategory->id }}" {{ old('sub_category_id', $banner->filter_conditions['sub_category_id'] ?? '') == $subCategory->id ? 'selected' : '' }}>{{ $subCategory->title }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Sub Kateqoriya (3cü səviyyə)</label>
                                    <select class="form-control js-example-basic-single" name="third_category_id" id="third_category_id">
                                        <option value="">Seçin</option>
                                        @foreach ($thirdCategories as $thirdCategory)
                                            <option value="{{ $thirdCategory->id }}" {{ old('third_category_id', $banner->filter_conditions['third_category_id'] ?? '') == $thirdCategory->id ? 'selected' : '' }}>{{ $thirdCategory->title }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Qiymət Aralığı</label>
                                    <div class="row">
                                        <div class="col-6">
                                            <input class="form-control" type="number" name="min_price" value="{{ old('min_price', $banner->filter_conditions['min_price'] ?? '') }}" placeholder="Minimum">
                                        </div>
                                        <div class="col-6">
                                            <input class="form-control" type="number" name="max_price" value="{{ old('max_price', $banner->filter_conditions['max_price'] ?? '') }}" placeholder="Maksimum">
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Brend</label>
                                    <select class="form-control js-example-basic-single" name="brand_id" id="brand_id">
                                        <option value="">Seçin</option>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}" {{ old('brand_id', $banner->filter_conditions['brand_id'] ?? '') == $brand->id ? 'selected' : '' }}>{{ $brand->title }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Digər Filtrlər -->
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" name="is_discount" id="is_discount" {{ old('is_discount', $banner->filter_conditions['is_discount'] ?? 0) == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_discount">Endirimli Məhsullar</label>
                                </div>

                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" name="is_season" id="is_season" {{ old('is_season', $banner->filter_conditions['is_season'] ?? 0) == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_season">Mövsüm Məhsulları</label>
                                </div>

                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" name="is_popular" id="is_popular" {{ old('is_popular', $banner->filter_conditions['is_popular'] ?? 0) == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_popular">Populyar Məhsullar</label>
                                </div>

                                <!-- Şəkil və Yadda Saxla -->
                                <div class="mb-3">
                                    <label class="col-form-label">Şəkli (1360x500)</label>
                                    <img style="width: 100px; height: 100px;" src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->image }}">
                                    <input class="form-control" type="file" name="image">
                                    @if($errors->first('image'))
                                        <small class="form-text text-danger">{{ $errors->first('image') }}</small>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label class="col-form-label">Active</label>
                                    <select name="is_active" class="form-control">
                                        <option value="1" {{ old('is_active', $banner->is_active) == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('is_active', $banner->is_active) == 0 ? 'selected' : '' }}>Deactive</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <button class="btn btn-primary" type="submit">Yadda saxla</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@include('admin.includes.footer')
