@include('admin.includes.header')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            @if(session('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            @if(session('message'))
                                <div class="alert alert-success">{{session('message')}}</div>
                            @endif
                            <h4 class="card-title">Məhsullar</h4>
                            <a href="{{route('products.create')}}" class="btn btn-primary">+</a>
                            <br>
                            <br>
                            <form action="{{ route('increase-prices') }}" method="POST">
                                @csrf
                                <div class="row">

                                    <div class="col-md-3">
                                        <label>Brend (istəyə bağlı)</label>
                                        <select name="brand_id" class="form-control">
                                            <option value="">Hamısı</option>
                                            @foreach($brands as $brand)
                                                <option value="{{ $brand->id }}">{{ $brand->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label>Artım faizi (%)</label>
                                        <input type="number" name="percent" class="form-control" required
                                               placeholder="Məs: 10">
                                    </div>

                                    <div class="col-md-3" style="margin-top: 30px;">
                                        <button type="submit" class="btn btn-warning">
                                            <i class="bi bi-arrow-up-circle"></i> Qiymətləri Artır
                                        </button>
                                    </div>
                                </div>
                            </form>

                            <br>
                            <br>
                            <form action="{{ route('xml.import') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <label class="col-form-label">Kateqoriya*</label>
                                        <select class="form-control" name="category_id" id="categorySelect">
                                            <option value="">Seçin</option>
                                            @foreach($categories as $category)
                                                <option
                                                    value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if($errors->first('category_id'))
                                            <small
                                                class="form-text text-danger">{{ $errors->first('category_id') }}</small>
                                        @endif
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label class="col-form-label">Alt Kateqoriya</label>
                                        <select class="form-control" name="sub_category_id" id="subCategorySelect">
                                            <option value="">Seçin</option>
                                        </select>
                                        @if($errors->first('sub_category_id'))
                                            <small
                                                class="form-text text-danger">{{ $errors->first('sub_category_id') }}</small>
                                        @endif
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label class="col-form-label">Alt Kateqoriya (3cü səviyə)</label>
                                        <select class="form-control" name="third_category_id" id="thirdCategorySelect">
                                            <option value="">Seçin</option>
                                        </select>
                                        @if($errors->first('third_category_id'))
                                            <small
                                                class="form-text text-danger">{{ $errors->first('third_category_id') }}</small>
                                        @endif
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label class="col-form-label">Brend*</label>
                                        <select class="form-control" name="brand_id" id="brandSelect">
                                            <option value="">Seçin</option>
                                            @foreach($brands as $brand)
                                                <option
                                                    value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                                    {{ $brand->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if($errors->first('brand_id'))
                                            <small
                                                class="form-text text-danger">{{ $errors->first('brand_id') }}</small>
                                        @endif
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label for="file" class="form-label">XML Faylı Seçin</label>
                                        <input type="file" name="xml_file" id="xml_file" class="form-control" required>
                                    </div>

                                    <div class="col-12">
                                        <button type="submit" class="btn btn-success">
                                            <i class="bi bi-upload"></i> Yüklə
                                        </button>
                                    </div>
                                </div>
                            </form>


                            <br>
                            <h4 class="card-title">Filterlə</h4>
                            <form method="GET" action="{{ route('products.index') }}">
                                <div class="row">
                                    <div class="col-md-2">
                                        <select id="limit" name="limit" class="form-control">
                                            <option value="">Choose</option>
                                            <option value="100" {{ request('limit') == 100 ? 'selected' : '' }}>100
                                            </option>
                                            <option value="150" {{ request('limit') == 150 ? 'selected' : '' }}>150
                                            </option>
                                            <option value="200" {{ request('limit') == 200 ? 'selected' : '' }}>
                                                200
                                            </option>
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <select id="is_active" name="is_active" class="form-control">
                                            <option value="">Choose</option>
                                            <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>
                                                Active
                                            </option>
                                            <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>
                                                Deactive
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" name="title" class="form-control"
                                               placeholder="Başlıq üzrə axtar" value="{{ request('title') }}">
                                    </div>
                                    <div class="col-md-1">
                                        <label>Stoku az olanlar</label>
                                        <input type="checkbox" name="stock"
                                               placeholder="Stocku az olanlar" {{request('stock') ? 'selected' : ''}}>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" name="code" class="form-control" placeholder="Kod üzrə axtar"
                                               value="{{ request('code') }}">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="brand" class="form-control">
                                            <option value="">Brend seçin</option>
                                            @foreach($brands as $brand)
                                                <option
                                                    value="{{ $brand->id }}" {{ request('brand') == $brand->id ? 'selected' : '' }}>
                                                    {{ $brand->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="col-md-2">
                                        <select name="category" class="form-control" id="categorySelect">
                                            <option value="">Kateqoriya seçin</option>
                                            @foreach($categories as $category)
                                                <option
                                                    value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <select name="subcategory" class="form-control" id="subCategorySelect">
                                            <option value="">Alt kateqoriya Seçin</option>
                                            @if(request('category'))
                                                @foreach($subcategories as $subcategory)
                                                    <option
                                                        value="{{ $subcategory->id }}" {{ request('subcategory') == $subcategory->id ? 'selected' : '' }}>
                                                        {{ $subcategory->title }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <br>
                                <button type="submit" class="btn btn-primary">Axtar</button>
                                <a href="{{ route('products.index') }}" class="btn btn-secondary">Sıfırla</a>
                            </form>
                            <br>
                            <div class="table-responsive">
                                <table class="table table-centered mb-0 align-middle table-hover table-nowrap">

                                    <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>Əməliyyat</th>
                                        <th>Kod</th>
                                        <th>Şəkil</th>
                                        <th>Başlıq</th>
                                        <th>Brend</th>
                                        <th>Kateqoriya</th>
                                        <th>Alt kateqoriya</th>
                                        <th>Alt kateqoriya (3cu)</th>
                                        <th>Qiymət</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($products as $key => $product)

                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>
                                                <a href="{{ route('products.edit', $product->id) }}"
                                                   class="btn btn-primary" style="margin-right: 15px">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('products.destroy', $product->id) }}"
                                                      method="post" style="display: inline-block">
                                                    {{ method_field('DELETE') }}
                                                    @csrf
                                                    <button onclick="return confirm('Məlumatın silinməyin təsdiqləyin')"
                                                            type="submit" class="btn btn-danger">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>

                                            <td>{{$product->code}}</td>
                                            <td><img src="{{$product->image}}"
                                                     style="width: 70px; height: 90px" alt=""></td>
                                            <td style="max-width: 200px; text-wrap: wrap;">{{$product->title}}</td>
                                            <td>{{$product->brand?->title}}</td>
                                            <td>{{$product->category?->title}}</td>
                                            <td>{{$product->sub_category?->title}}</td>
                                            <td>{{$product->third_category?->title}}</td>
                                            <td>
                                                <div>
                                                    <strong>Qiymət:</strong> {{$product->price}} <br>
                                                    @if($product->discount > 0)
                                                        <strong>Endirim:</strong> {{$product->discount}}% <br>
                                                        <strong>Endirimli qiymət:</strong> <span
                                                            style="color: green;">{{$product->discounted_price}}</span>
                                                    @endif
                                                </div>
                                            </td>

                                            <td>{{$product->is_active  ? 'Active' : 'Deactive'}}</td>


                                        </tr>

                                    @endforeach

                                    </tbody>
                                </table>
                                <br>
                                {{ $products->links('admin.vendor.pagination.bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@include('admin.includes.footer')
<script>
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
