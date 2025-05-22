@include('admin.includes.header')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

<style>
    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid rgba(0,0,0,.125);
    }
    .section-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #495057;
        border-bottom: 2px solid #dee2e6;
        padding-bottom: 0.5rem;
        margin-bottom: 1.5rem;
    }
    .form-section {
        background-color: #fff;
        border-radius: 0.5rem;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,.075);
    }
    .action-btn {
        min-width: 40px;
    }
    .product-img {
        width: 70px;
        height: 90px;
        object-fit: cover;
        border-radius: 0.25rem;
    }
    .status-badge {
        padding: 0.35em 0.65em;
        font-size: 0.75em;
    }
    .price-highlight {
        font-weight: 600;
        color: #28a745;
    }
    .nav-tabs .nav-link.active {
        font-weight: 600;
    }
    .ajax-loader {
        display: none;
        width: 20px;
        height: 20px;
    }
</style>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- Page Title -->
            <div class="row mb-3">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Məhsul İdarəetmə Paneli</h4>
                        <a href="{{route('products.create')}}" class="btn btn-primary btn-sm">
                            <i class="bi bi-plus-lg"></i> Yeni Məhsul
                        </a>
                    </div>
                </div>
            </div>

            <!-- Notification Alert -->
            @if(session('message'))
                <div class="alert alert-success alert-dismissible fade show animate__animated animate__fadeIn">
                    {{session('message')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Price Increase Section -->
            <div class="form-section animate__animated animate__fadeIn">
                <h5 class="section-title"><i class="bi bi-currency-exchange me-2"></i>Toplu Qiymət Dəyişikliyi</h5>
                <form action="{{ route('increase-prices') }}" method="POST">
                    @csrf
                    <div class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label">Brend (istəyə bağlı)</label>
                            <select name="brand_id" class="form-select">
                                <option value="">Hamısı</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Artım faizi (%)</label>
                            <div class="input-group">
                                <input type="number" name="percent" class="form-control" required placeholder="Məs: 10">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <button type="submit" class="btn btn-warning w-100">
                                <i class="bi bi-arrow-up-circle me-1"></i> Qiymətləri Artır
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Import Tabs -->
            <div class="form-section animate__animated animate__fadeIn">
                <ul class="nav nav-tabs" id="importTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="trendyol-tab" data-bs-toggle="tab" data-bs-target="#trendyol" type="button" role="tab">
                            <i class="bi bi-shop me-1"></i> Trendyol Import
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="zara-tab" data-bs-toggle="tab" data-bs-target="#zara" type="button" role="tab">
                            <i class="bi bi-tag me-1"></i> Zara Import
                        </button>
                    </li>
                </ul>

                <div class="tab-content p-3 border border-top-0 rounded-bottom">
                    <!-- Trendyol Import -->
                    <div class="tab-pane fade show active" id="trendyol" role="tabpanel">
                        <form action="{{ route('xml.import') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label">Kateqoriya*</label>
                                    <select class="form-control trendyol-category-select" name="category_id">
                                        <option value="">Seçin</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if($errors->first('category_id'))
                                        <small class="text-danger">{{ $errors->first('category_id') }}</small>
                                    @endif
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Alt Kateqoriya</label>
                                    <select class="form-control trendyol-sub-category-select" name="sub_category_id">
                                        <option value="">Seçin</option>
                                    </select>
                                    @if($errors->first('sub_category_id'))
                                        <small class="text-danger">{{ $errors->first('sub_category_id') }}</small>
                                    @endif
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Alt Kateqoriya (3cü səviyə)</label>
                                    <select class="form-control trendyol-third-category-select" name="third_category_id">
                                        <option value="">Seçin</option>
                                    </select>
                                    @if($errors->first('third_category_id'))
                                        <small class="text-danger">{{ $errors->first('third_category_id') }}</small>
                                    @endif
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Brend*</label>
                                    <select class="form-control" name="brand_id">
                                        <option value="">Seçin</option>
                                        @foreach($brands as $brand)
                                            <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                                {{ $brand->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if($errors->first('brand_id'))
                                        <small class="text-danger">{{ $errors->first('brand_id') }}</small>
                                    @endif
                                </div>

                                <div class="col-md-6">
                                    <label for="file" class="form-label">XML Faylı Seçin</label>
                                    <input type="file" name="xml_file" class="form-control" required>
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-success">
                                        <i class="bi bi-upload me-1"></i> Yüklə
                                        <span class="spinner-border spinner-border-sm ajax-loader ms-2" role="status" aria-hidden="true"></span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Zara Import -->
                    <div class="tab-pane fade" id="zara" role="tabpanel">
                        <form action="{{ route('zara.import') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label">Kateqoriya*</label>
                                    <select class="form-control zara-category-select" name="category_id">
                                        <option value="">Seçin</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if($errors->first('category_id'))
                                        <small class="text-danger">{{ $errors->first('category_id') }}</small>
                                    @endif
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Alt Kateqoriya</label>
                                    <select class="form-control zara-sub-category-select" name="sub_category_id">
                                        <option value="">Seçin</option>
                                    </select>
                                    @if($errors->first('sub_category_id'))
                                        <small class="text-danger">{{ $errors->first('sub_category_id') }}</small>
                                    @endif
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Alt Kateqoriya (3cü səviyə)</label>
                                    <select class="form-control zara-third-category-select" name="third_category_id">
                                        <option value="">Seçin</option>
                                    </select>
                                    @if($errors->first('third_category_id'))
                                        <small class="text-danger">{{ $errors->first('third_category_id') }}</small>
                                    @endif
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Brend*</label>
                                    <select class="form-control" name="brand_id">
                                        <option value="">Seçin</option>
                                        @foreach($brands as $brand)
                                            <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                                {{ $brand->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if($errors->first('brand_id'))
                                        <small class="text-danger">{{ $errors->first('brand_id') }}</small>
                                    @endif
                                </div>

                                <div class="col-md-6">
                                    <label for="file" class="form-label">XML Faylı Seçin</label>
                                    <input type="file" name="xml_file" class="form-control" required>
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-success">
                                        <i class="bi bi-upload me-1"></i> Yüklə
                                        <span class="spinner-border spinner-border-sm ajax-loader ms-2" role="status" aria-hidden="true"></span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="form-section animate__animated animate__fadeIn">
                <h5 class="section-title"><i class="bi bi-funnel me-2"></i>Məhsul Filterləri</h5>
                <form method="GET" action="{{ route('products.index') }}">
                    <div class="row g-3">
                        <div class="col-md-2">
                            <label class="form-label">Göstər</label>
                            <select name="limit" class="form-select">
                                <option value="">Hamısı</option>
                                <option value="100" {{ request('limit') == 100 ? 'selected' : '' }}>100</option>
                                <option value="150" {{ request('limit') == 150 ? 'selected' : '' }}>150</option>
                                <option value="200" {{ request('limit') == 200 ? 'selected' : '' }}>200</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Status</label>
                            <select name="is_active" class="form-select">
                                <option value="">Hamısı</option>
                                <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Aktiv</option>
                                <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Deaktiv</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Brend</label>
                            <select name="brand" class="form-select">
                                <option value="">Hamısı</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ request('brand') == $brand->id ? 'selected' : '' }}>
                                        {{ $brand->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Açar söz</label>
                            <input type="text" name="title" class="form-control" placeholder="Məhsul adı" value="{{ request('title') }}">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Kod</label>
                            <input type="text" name="code" class="form-control" placeholder="Məhsul kodu" value="{{ request('code') }}">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Kateqoriya</label>
                            <select name="category" class="form-select filter-category-select">
                                <option value="">Hamısı</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Alt Kateqoriya</label>
                            <select name="subcategory" class="form-select filter-sub-category-select">
                                <option value="">Hamısı</option>
                                @if(request('category'))
                                    @foreach($subcategories as $subcategory)
                                        <option value="{{ $subcategory->id }}" {{ request('subcategory') == $subcategory->id ? 'selected' : '' }}>
                                            {{ $subcategory->title }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="col-md-2">
                            <div class="form-check pt-4">
                                <input class="form-check-input" type="checkbox" name="stock" id="stockCheck" {{ request('stock') ? 'checked' : '' }}>
                                <label class="form-check-label" for="stockCheck">
                                    Stoku az olanlar
                                </label>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">İstifadəçi</label>
                            <select name="user_id" class="form-select">
                                <option value="">Hamısı</option>
                                @foreach($users as $user)
                                    <option value="{{$user->id}}" {{ request('user_id') == $user->id ? 'selected' : '' }}>{{$user->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Başlanğıc tarix</label>
                            <input type="date" name="start_act" class="form-control" value="{{ request('start_act') }}">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Son tarix</label>
                            <input type="date" name="end_act" class="form-control" value="{{ request('end_act') }}">
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="bi bi-funnel me-1"></i> Filterlə
                            </button>
                            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-counterclockwise me-1"></i> Sıfırla
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Products Table -->
            <div class="card animate__animated animate__fadeIn">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                            <tr>
                                <th width="50">#</th>
                                <th width="120">Əməliyyat</th>
                                <th width="100">Kod</th>
                                <th width="80">Şəkil</th>
                                <th>Başlıq</th>
                                <th width="150">Brend</th>
                                <th width="150">Kateqoriya</th>
                                <th width="120">Qiymət</th>
                                <th width="100">Status</th>
                                <th width="100">User</th>
                                <th width="100">Tarix</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($products as $key => $product)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-primary action-btn" title="Düzəliş">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('products.destroy', $product->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger action-btn" title="Sil" onclick="return confirm('Məhsulu silmək istədiyinizə əminsiniz?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-secondary">{{ $product->code }}</span></td>
                                    <td>
                                        <img src="{{ $product->image }}" class="product-img" alt="{{ $product->title }}">
                                    </td>
                                    <td>
                                        <div class="text-truncate" style="max-width: 250px;" title="{{ $product->title }}">
                                            {{ $product->title }}
                                        </div>
                                    </td>
                                    <td>{{ $product->brand?->title ?? '-' }}</td>
                                    <td>
                                        <div class="text-truncate" style="max-width: 150px;">
                                            {{ $product->category?->title }}
                                            @if($product->sub_category)
                                                <small class="text-muted d-block">{{ $product->sub_category?->title }}</small>
                                            @endif
                                            @if($product->third_category)
                                                <small class="text-muted d-block">{{ $product->third_category?->title }}</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <span class="{{ $product->discount > 0 ? 'text-decoration-line-through text-muted' : 'price-highlight' }}">
                                                {{ number_format($product->price, 2) }} ₼
                                            </span>
                                            @if($product->discount > 0)
                                                <br>
                                                <span class="price-highlight">
                                                    {{ number_format($product->discounted_price, 2) }} ₼
                                                </span>
                                                <span class="badge bg-danger ms-1">-{{ $product->discount }} %</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge rounded-pill status-badge bg-{{ $product->is_active ? 'success' : 'secondary' }}">
                                            {{ $product->is_active ? 'Aktiv' : 'Deaktiv' }}
                                        </span>
                                    </td>
                                    <td>{{$product->user?->name}}</td>
                                    <td>{{$product->activation_date}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($products->hasPages())
                        <div class="row mt-3">
                            <div class="col-12">
                                <nav aria-label="Page navigation">
                                    {{ $products->links('admin.vendor.pagination.bootstrap-5') }}
                                </nav>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.includes.footer')

<script>
    $(document).ready(function() {
        // Show loading spinner on form submit
        $('form').on('submit', function() {
            $(this).find('.ajax-loader').show();
        });

        // Trendyol Category AJAX
        $('.trendyol-category-select').on('change', function() {
            var categoryId = $(this).val();
            var form = $(this).closest('form');
            var subSelect = form.find('.trendyol-sub-category-select');
            var thirdSelect = form.find('.trendyol-third-category-select');

            subSelect.html('<option value="">Seçin</option>');
            thirdSelect.html('<option value="">Seçin</option>');

            if (categoryId) {
                $.ajax({
                    url: '/categories/' + categoryId + '/details',
                    type: 'GET',
                    success: function(response) {
                        if (response.sub_categories) {
                            response.sub_categories.forEach(function(subCategory) {
                                subSelect.append(
                                    '<option value="' + subCategory.id + '">' + subCategory.title + '</option>'
                                );
                            });
                        }
                    }
                });
            }
        });

        // Trendyol Sub-Category AJAX
        $('.trendyol-sub-category-select').on('change', function() {
            var subCategoryId = $(this).val();
            var form = $(this).closest('form');
            var thirdSelect = form.find('.trendyol-third-category-select');

            thirdSelect.html('<option value="">Seçin</option>');

            if (subCategoryId) {
                $.ajax({
                    url: '/sub_categories/' + subCategoryId + '/details',
                    type: 'GET',
                    success: function(response) {
                        if (response.third_categories) {
                            response.third_categories.forEach(function(thirdCategory) {
                                thirdSelect.append(
                                    '<option value="' + thirdCategory.id + '">' + thirdCategory.title + '</option>'
                                );
                            });
                        }
                    }
                });
            }
        });

        // Zara Category AJAX
        $('.zara-category-select').on('change', function() {
            var categoryId = $(this).val();
            var form = $(this).closest('form');
            var subSelect = form.find('.zara-sub-category-select');
            var thirdSelect = form.find('.zara-third-category-select');

            subSelect.html('<option value="">Seçin</option>');
            thirdSelect.html('<option value="">Seçin</option>');

            if (categoryId) {
                $.ajax({
                    url: '/categories/' + categoryId + '/details',
                    type: 'GET',
                    success: function(response) {
                        if (response.sub_categories) {
                            response.sub_categories.forEach(function(subCategory) {
                                subSelect.append(
                                    '<option value="' + subCategory.id + '">' + subCategory.title + '</option>'
                                );
                            });
                        }
                    }
                });
            }
        });

        // Zara Sub-Category AJAX
        $('.zara-sub-category-select').on('change', function() {
            var subCategoryId = $(this).val();
            var form = $(this).closest('form');
            var thirdSelect = form.find('.zara-third-category-select');

            thirdSelect.html('<option value="">Seçin</option>');

            if (subCategoryId) {
                $.ajax({
                    url: '/sub_categories/' + subCategoryId + '/details',
                    type: 'GET',
                    success: function(response) {
                        if (response.third_categories) {
                            response.third_categories.forEach(function(thirdCategory) {
                                thirdSelect.append(
                                    '<option value="' + thirdCategory.id + '">' + thirdCategory.title + '</option>'
                                );
                            });
                        }
                    }
                });
            }
        });

        // Filter Category AJAX
        $('.filter-category-select').on('change', function() {
            var categoryId = $(this).val();
            var subSelect = $('.filter-sub-category-select');

            subSelect.html('<option value="">Seçin</option>');

            if (categoryId) {
                $.ajax({
                    url: '/categories/' + categoryId + '/details',
                    type: 'GET',
                    success: function(response) {
                        if (response.sub_categories) {
                            response.sub_categories.forEach(function(subCategory) {
                                subSelect.append(
                                    '<option value="' + subCategory.id + '">' + subCategory.title + '</option>'
                                );
                            });
                        }
                    }
                });
            }
        });
    });
</script>
