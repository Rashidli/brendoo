@include('admin.includes.header')

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            {{-- Filter --}}
            <div class="row mb-4">
                <div class="col-lg-12">
                    <div class="card shadow-sm">
                        @if(session('message'))
                            <div class="alert alert-success">{{ session('message') }}</div>
                        @endif
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Sifarişləri Filtrlə</h5>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="{{ route('offices.index') }}">
                                <div class="row g-3">
                                    <div class="col-md-2">
                                        <label class="form-label">Müştəri kodu</label>
                                        <input type="text" name="customer_id" class="form-control" value="{{ request('customer_id') }}">
                                    </div>

                                    <div class="col-md-2">
                                        <label class="form-label">Müştəri adı</label>
                                        <input type="text" name="name" class="form-control" value="{{ request('name') }}">
                                    </div>

                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary w-100">Filtrlə</button>
                                    </div>

                                    <div class="col-md-2 d-flex align-items-end">
                                        <a href="{{ route('offices.index') }}" class="btn btn-secondary w-100">Sıfırla</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Paketlə formu + OrderItems --}}
            <form method="POST" action="{{ route('packages.store') }}">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-3">
                        <input type="text" required  name="tr_barcode" class="form-control" placeholder="Türk barcodu">
                    </div>
                    <div class="col-md-3">
                        <input type="number" required step="0.01" name="weight" class="form-control" placeholder="Çəki (q)">
                    </div>
                    <div class="col-md-3">
                        <textarea name="note" cols="30" class="form-control" placeholder="Qeyd"></textarea>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-success w-100">✅ Seçilmişləri Paketlə</button>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card shadow-sm">
                            <div class="card-header bg-dark text-white">
                                <i class="fas fa-boxes"></i> Sifariş Məhsulları
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped align-middle">
                                        <thead class="table-light">
                                        <tr>
                                            <th><input type="checkbox" id="checkAll"></th>
                                            <th>#</th>
                                            <th>Müştəri kodu</th>
                                            <th>Kodu</th>
                                            <th>Şəkil</th>
                                            <th>Məhsul</th>
                                            <th>Brend</th>
                                            <th>Miqdar</th>
                                            <th>Seçilib</th>
                                            <th>Qiymət</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($orders as $order)
                                            @foreach($order->order_items ?? [] as $index => $product)
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" name="order_item_ids[]" value="{{ $product->id }}" class="order-item-checkbox">
                                                    </td>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $order->customer?->id }}</td>
                                                    <td>{{ $product->product?->code }}</td>
                                                    <td>
                                                        <img src="{{ $product->product?->image }}"
                                                             alt="Məhsul Şəkli"
                                                             class="img-thumbnail"
                                                             style="width: 70px; height: 90px;">
                                                    </td>
                                                    <td>
                                                        @if($product->product)
                                                            <a href="{{ route('products.edit', $product->product?->id) }}"
                                                               class="text-decoration-none">
                                                                {{ $product->product?->title }}
                                                            </a>
                                                        @else
                                                            <a href="#" class="text-decoration-none">N/A</a>
                                                        @endif
                                                    </td>
                                                    <td>{{ $product->product?->brand?->title }}</td>
                                                    <td>{{ $product->quantity }}</td>
                                                    <td>
                                                        @foreach($product->options as $option)
                                                            <span class="badge bg-secondary">
                                                                    {{ $option->filter?->title }}: {{ $option->option?->title }}
                                                                </span>
                                                        @endforeach
                                                    </td>
                                                    <td>{{ number_format($product->price, 2) }} ₽</td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                        </tbody>
                                    </table>
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

{{-- Select all checkbox JS --}}
<script>
    document.getElementById('checkAll').addEventListener('change', function () {
        const checkboxes = document.querySelectorAll('.order-item-checkbox');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });
</script>
