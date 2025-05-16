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
                            <h4 class="card-title">Məhsullar</h4>
                            <br>
                            <h4 class="card-title">Filterlə</h4>
                            <form method="GET" action="{{ route('inspections.index') }}">
                                <div class="row">
                                    <div class="col-md-2">
                                        <select id="limit" name="limit" class="form-control">
                                            <option value="">Choose</option>
                                            <option value="100" {{ request('limit') == 100 ? 'selected' : '' }}>100</option>
                                            <option value="150" {{ request('limit') == 150 ? 'selected' : '' }}>150</option>
                                            <option value="200" {{ request('limit') == 200 ? 'selected' : '' }}>200</option>
                                        </select>
                                    </div>
                                    <input type="hidden" value="1" name="is_active">
                                    <div class="col-md-2">
                                        <input type="text" name="title" class="form-control" placeholder="Başlıq üzrə axtar" value="{{ request('title') }}">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" name="code" class="form-control" placeholder="Kod üzrə axtar" value="{{ request('code') }}">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="brand" class="form-control">
                                            <option value="">Brend seçin</option>
                                            @foreach($brands as $brand)
                                                <option value="{{ $brand->id }}" {{ request('brand') == $brand->id ? 'selected' : '' }}>
                                                    {{ $brand->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <select name="category" class="form-control" id="categorySelect">
                                            <option value="">Kateqoriya seçin</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
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
                                                    <option value="{{ $subcategory->id }}" {{ request('subcategory') == $subcategory->id ? 'selected' : '' }}>
                                                        {{ $subcategory->title }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
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
                                </div>
                                <br>
                                <button type="submit" class="btn btn-primary">Axtar</button>
                                <a href="{{ route('inspections.index') }}" class="btn btn-secondary">Sıfırla</a>
                            </form>
                            <br>
                            <div class="table-responsive">
                                <table class="table table-centered mb-0 align-middle table-hover table-nowrap">
                                    <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>Kod</th>
                                        <th>Şəkil</th>
                                        <th>Başlıq (en/ru)</th>
                                        <th>Description (en/ru)</th>
                                        <th>Brend</th>
                                        <th>Kateqoriya</th>
                                        <th>Alt kateqoriya</th>
                                        <th>Alt kateqoriya (3cu)</th>
                                        <th>Seçimləri</th>
                                        <th>Qaytarıla bilər?</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($products as $key => $product)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $product->code }}</td>
                                            <td><img src="{{ $product->image }}" style="width: 70px; height: 90px" alt=""></td>
                                            <td>
                                                <ul style="list-style: none; padding: 0;">
                                                    @foreach(['en', 'ru'] as $locale)
                                                        <li>
                                                            <a href="#" class="open-modal"
                                                               data-title="{{ $product->translate($locale)->title }}"
                                                               data-label="Title ({{ $locale }})">
                                                                {{ Str::limit($product->translate($locale)->title, 15) }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td>
                                                <ul style="list-style: none; padding: 0;">
                                                    @foreach(['en', 'ru'] as $locale)
                                                        <li>
                                                            <a href="#" class="open-modal"
                                                               data-title="{{ $product->translate($locale)->description }}"
                                                               data-label="Description ({{ $locale }})">
                                                                {{ Str::limit(strip_tags($product->translate($locale)->description), 15) }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </td>

                                            <td>{{ $product->brand?->title }}</td>
                                            <td>{{ $product->category?->title }}</td>
                                            <td>{{ $product->sub_category?->title }}</td>
                                            <td>{{ $product->third_category?->title }}</td>

                                            @php
                                                $grouped = $product->options->groupBy(function ($option) {
                                                    return $option->pivot->filter_id;
                                                });
                                            @endphp
                                            <td>
                                                @foreach($grouped as $filterId => $options)
                                                    @php
                                                        $filter = $product->filters->firstWhere('id', $filterId);
                                                    @endphp
                                                    @if($filter)
                                                        <strong>{{ $filter->title }}:</strong><br>
                                                        @foreach($options as $option)
                                                            {{ $option->title }}
                                                            @if($option->pivot->is_default)
                                                                <span style="color: green;">(Default)</span>
                                                            @endif
                                                            @if(!$option->pivot->is_stock)
                                                                <span style="color: red;">(Out of Stock)</span>
                                                            @endif
                                                            <br>
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                <div class="form-check form-switch mb-3">
                                                    <input class="form-check-input" type="checkbox" disabled {{ $product->is_return ? 'checked' : '' }}>
                                                </div>
                                            </td>


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

    {{-- Modal --}}
    <div class="modal fade" id="textModal" tabindex="-1" aria-labelledby="textModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="textModalLabel" class="modal-title">Mətn Baxışı</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Bağla"></button>
                </div>
                <div class="modal-body">
                    <h6 id="modal-label" class="text-muted"></h6>
                    <div id="modal-content" class="mt-2"></div>
                </div>
            </div>
        </div>
    </div>

</div>

@include('admin.includes.footer')

<script>
    $(document).ready(function () {
        $('.open-modal').on('click', function (e) {
            e.preventDefault();
            let content = $(this).data('title');
            let label = $(this).data('label');
            $('#modal-content').html(content);
            $('#modal-label').text(label);
            $('#textModal').modal('show');
        });
    });

    $('#categorySelect').on('change', function () {
        var categoryId = $(this).val();
        var subCategorySelect = $('#subCategorySelect');
        subCategorySelect.html('<option value="">Alt kateqoriya seçin</option>');

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
                    }
                }
            });
        }
    });
</script>
