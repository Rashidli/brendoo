@include('admin.includes.header')

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <form action="{{ route('tiktoks.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <h4 class="card-title">Add TikTok</h4>

                                <!-- Language Tabs -->
                                <ul class="nav nav-tabs" id="langTabs" role="tablist">
                                    @foreach([ 'en', 'ru'] as $lang)
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link {{ $loop->first ? 'active' : '' }}" id="{{ $lang }}-tab" data-bs-toggle="tab" href="#{{ $lang }}" role="tab" aria-controls="{{ $lang }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}">{{ strtoupper($lang) }}</a>
                                        </li>
                                    @endforeach
                                </ul>

                                <div class="tab-content" id="langTabsContent">
                                    @foreach(['en', 'ru'] as $lang)
                                        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ $lang }}" role="tabpanel" aria-labelledby="{{ $lang }}-tab">
                                            <div class="mb-3">
                                                <label class="col-form-label">Title {{ strtoupper($lang) }}</label>
                                                <input class="form-control" type="text" value="{{ old($lang . '_title') }}" name="{{ $lang }}_title">
                                                @if($errors->first("{$lang}_title")) <small class="form-text text-danger">{{ $errors->first("{$lang}_title") }}</small> @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Image Upload -->
                                <div class="mb-3">
                                    <label class="col-form-label">Video (480x824)</label>
                                    <input class="form-control" type="file" name="image">
                                    @if($errors->first('image')) <small class="form-text text-danger">{{ $errors->first('image') }}</small> @endif
                                </div>

                                <div class="mb-3 mt-4">
                                    <button class="btn btn-success">Yadda saxla</button>
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

<!-- Include Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

<script>
    document.getElementById('searchButton').addEventListener('click', function () {
        const category = document.getElementById('category').value;
        const subCategory = document.getElementById('subCategory').value;
        const brand = document.getElementById('brand').value;
        const title = document.getElementById('title').value;

        fetch(`/products.search?category_id=${category}&sub_category_id=${subCategory}&brand_id=${brand}&title=${title}`)
            .then(response => response.json())
            .then(data => {
                const results = document.getElementById('searchResults');
                results.innerHTML = '';

                data.forEach(product => {
                    const productCard = `
                        <div class="card mb-2">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <span>${product.title}</span>
                                <button type="button" class="btn btn-sm btn-success" onclick="assignProduct(${product.id})">Assign</button>
                            </div>
                        </div>`;
                    results.innerHTML += productCard;
                });
            });
    });

    function assignProduct(productId) {
        // Logic to assign the product to TikTok
        alert(`Product with ID ${productId} assigned.`);
    }
</script>
