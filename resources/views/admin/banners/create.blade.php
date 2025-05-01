@include('admin.includes.header')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <form action="{{ route('banners.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">əlavə et</h4>
                        <div class="row">
                            <div class="col-6">
                                <!-- Başlıq və Mətn -->
                                <div class="mb-3">
                                    <label class="col-form-label">Başlıq en</label>
                                    <input class="form-control" type="text" name="en_title">
                                    @if($errors->first('en_title'))
                                        <small class="form-text text-danger">{{ $errors->first('en_title') }}</small>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Başlıq ru</label>
                                    <input class="form-control" type="text" name="ru_title">
                                    @if($errors->first('ru_title'))
                                        <small class="form-text text-danger">{{ $errors->first('ru_title') }}</small>
                                    @endif
                                </div>
                                <!-- Başlıq və Mətn -->
                                <div class="mb-3">
                                    <label class="col-form-label">Text en</label>
                                    <input class="form-control" type="text" name="en_description">
                                    @if($errors->first('en_description'))
                                        <small class="form-text text-danger">{{ $errors->first('en_description') }}</small>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Text ru</label>
                                    <input class="form-control" type="text" name="ru_description">
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
                                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Sub Kateqoriya</label>
                                    <select class="form-control js-example-basic-single" name="sub_category_id" id="sub_category_id">
                                        <option value="">Seçin</option>
                                        @foreach ($subCategories as $subCategory)
                                            <option value="{{ $subCategory->id }}">{{ $subCategory->title }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Sub Kateqoriya (3cü səviyyə)</label>
                                    <select class="form-control js-example-basic-single" name="third_category_id" id="third_category_id">
                                        <option value="">Seçin</option>
                                        @foreach ($thirdCategories as $thirdCategory)
                                            <option value="{{ $thirdCategory->id }}">{{ $thirdCategory->title }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Qiymət Aralığı</label>
                                    <div class="row">
                                        <div class="col-6">
                                            <input class="form-control" type="number" name="min_price" placeholder="Minimum">
                                        </div>
                                        <div class="col-6">
                                            <input class="form-control" type="number" name="max_price" placeholder="Maksimum">
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Brend</label>
                                    <select class="form-control js-example-basic-single" name="brand_id" id="brand_id">
                                        <option value="">Seçin</option>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}">{{ $brand->title }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Digər Filtrlər -->
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" name="is_discount" id="is_discount">
                                    <label class="form-check-label" for="is_discount">Endirimli Məhsullar</label>
                                </div>

                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" name="is_season" id="is_season">
                                    <label class="form-check-label" for="is_season">Mövsüm Məhsulları</label>
                                </div>

                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" name="is_popular" id="is_popular">
                                    <label class="form-check-label" for="is_popular">Populyar Məhsullar</label>
                                </div>

                                <!-- Şəkil və Yadda Saxla -->
                                <div class="mb-3">
                                    <label class="col-form-label">Şəkli (1360x500)</label>
                                    <input class="form-control" type="file" name="image">
                                    @if($errors->first('image'))
                                        <small class="form-text text-danger">{{ $errors->first('image') }}</small>
                                    @endif
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
