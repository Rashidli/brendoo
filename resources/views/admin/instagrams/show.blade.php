@include('admin.includes.header')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @elseif(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif


            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <nav aria-label="breadcrumb" style="margin-bottom: 20px;">
                                <ol class="breadcrumb bg-light p-3 rounded">
                                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('instagrams.index') }}">Siyahı</a>
                                    </li>
                                    <li class="breadcrumb-item active"
                                        aria-current="page">{{ $instagram->translate('en')?->title }}</li>
                                </ol>
                            </nav>
                            <form method="GET" action="{{ route('instagrams.show', $instagram->id) }}">
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
                                        <input type="text" name="title" class="form-control"
                                               placeholder="Başlıq üzrə axtar" value="{{ request('title') }}">
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
                                <a href="{{ route('instagrams.show', $instagram->id) }}" class="btn btn-secondary">Sıfırla</a>
                            </form>
                            <br>
                            <div class="table-responsive">
                                <table class="table table-centered mb-0 align-middle table-hover table-nowrap">

                                    <thead>
                                    <tr>
                                        <th>Kod</th>
                                        <th>Şəkil</th>
                                        <th>Başlıq</th>
                                        <th>Brend</th>
                                        <th>Kateqoriya</th>
                                        <th>Alt kateqoriya</th>
                                        <th>Qiymət</th>
                                        <th>Status</th>
                                        <th>Əməliyyat</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($products as $key => $product)

                                        <tr>
                                            <td>{{$product->code}}</td>
                                            <td><img src="{{$product->image}}"
                                                     style="width: 70px; height: 90px" alt=""></td>
                                            <td>{{$product->title}}</td>
                                            <td>{{$product->brand?->title}}</td>
                                            <td>{{$product->category?->title}}</td>
                                            <td>{{$product->sub_category?->title}}</td>
                                            <td>
                                                <div>
                                                    <strong>Maya dəyəri:</strong> {{$product->cost_price}} <br>
                                                    <strong>Qiymət:</strong> {{$product->price}} <br>
                                                    @if($product->discount > 0)
                                                        <strong>Endirim:</strong> {{$product->discount}}% <br>
                                                        <strong>Endirimli qiymət:</strong> <span
                                                            style="color: green;">{{$product->discounted_price}}</span>
                                                    @endif
                                                </div>
                                            </td>

                                            <td>{{$product->is_active  ? 'Active' : 'Deactive'}}</td>
                                            <td>
                                                <a href="{{ route('assign_instagram', [$instagram->id, $product->id]) }}"
                                                   class="btn btn-primary"
                                                   style="margin-right: 15px">Əlavə et</a>
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

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">

                                <h3>Əlavə olunmuş məhsullar</h3>
                                <div class="table-responsive">
                                    <table class="table table-centered mb-0 align-middle table-hover table-nowrap">

                                        <thead>
                                        <tr>
                                            <th>Kod</th>
                                            <th>Şəkil</th>
                                            <th>Başlıq</th>
                                            <th>Brend</th>
                                            <th>Kateqoriya</th>
                                            <th>Alt kateqoriya</th>
                                            <th>Qiymət</th>
                                            <th>Status</th>
                                            <th>Əməliyyat</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        @foreach($instagram->products as $key => $product)

                                            <tr>
                                                <td>{{$product->code}}</td>
                                                <td><img src="{{$product->image}}"
                                                         style="width: 70px; height: 90px" alt=""></td>
                                                <td>{{$product->title}}</td>
                                                <td>{{$product->brand?->title}}</td>
                                                <td>{{$product->category?->title}}</td>
                                                <td>{{$product->sub_category?->title}}</td>
                                                <td>
                                                    <div>
                                                        <strong>Maya dəyəri:</strong> {{$product->cost_price}} <br>
                                                        <strong>Qiymət:</strong> {{$product->price}} <br>
                                                        @if($product->discount > 0)
                                                            <strong>Endirim:</strong> {{$product->discount}}% <br>
                                                            <strong>Endirimli qiymət:</strong> <span
                                                                style="color: green;">{{$product->discounted_price}}</span>
                                                        @endif
                                                    </div>
                                                </td>

                                                <td>{{$product->is_active  ? 'Active' : 'Deactive'}}</td>
                                                <td>
                                                    <form action="{{ route('remove_assign_instagram', [$instagram->id, $product->id]) }}"
                                                          method="post" style="display: inline-block">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button onclick="return confirm('Məlumatın silinməyin təsdiqləyin')"
                                                                type="submit"
                                                                class="btn btn-danger">Delete
                                                        </button>
                                                    </form>

                                                </td>
                                            </tr>

                                        @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
        </div>
    </div>
</div>
@include('admin.includes.footer')

<!-- Include Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
