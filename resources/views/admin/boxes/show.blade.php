@include('admin.includes.header')

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            <div class="row mb-4">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">Sifariş Detalları #{{ $order->order_number }}</h3>
                        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Geri
                        </a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card shadow-sm">
                            <div class="card-header bg-info text-white">
                                <i class="fas fa-user"></i> Müştəri Məlumatları
                            </div>
                            <div class="card-body">
                                <p><strong>Adı:</strong> {{ $order->customer?->name }}</p>
                                <p><strong>Ünvan:</strong> {{ $order->address ?? 'Ünvan yoxdur' }}</p>
                                <p><strong>Əlavə Məlumat:</strong> {{ $order->additional_info ?? 'Əlavə məlumat yoxdur' }}</p>

                                <!-- Toggle Button for is_complete -->
                                <form action="{{ route('toggle_is_complete', $order->id) }}" method="GET">
                                    @csrf
                                    <button type="submit" class="btn btn-{{ $order->is_complete ? 'success' : 'danger' }}">
                                        {{ $order->is_complete ? 'Tam' : 'Natamam' }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card shadow-sm">
                        <div class="card-header bg-warning text-dark">
                            <i class="fas fa-tasks"></i> Sifariş Statusunu Dəyiş
                        </div>
                        <div class="card-body">
                            <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="input-group">
                                    <select name="status" class="form-select">
                                        @foreach(\App\Http\Enums\OrderStatus::cases() as $status)
                                            <option
                                                value="{{ $status->value }}" {{ $order->status === $status->value ? 'selected' : '' }}>
                                                {{ \App\Http\Enums\OrderStatus::label($status->value) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save"></i> Saxla
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
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
                                        <th>#</th>
                                        <th>Kodu</th>
                                        <th>Şəkil</th>
                                        <th>Məhsul</th>
                                        <th>Brend</th>
                                        <th>Miqdar</th>
                                        <th>Seçilib</th>
                                        <th>Status</th>
                                        <th>Qiymət</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($orderItems as $index => $product)
                                        <tr @if(!$product->order_item_status) style="text-decoration: line-through" @endif>
                                            <td>{{ $index + 1 }}</td>
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
                                                    <a href="#"
                                                       class="text-decoration-none">
                                                        {{ $product->product?->title }}
                                                    </a>
                                                @endif

                                            </td>

                                            <td>{{$product->product?->brand?->title}}</td>

                                            <td>{{ $product->quantity }}</td>

                                            <td>
                                                @foreach($product->options as $option)
                                                    <span class="badge bg-secondary">
                                                            {{ $option->filter?->title }}: {{ $option->option?->title }}
                                                        </span>
                                                @endforeach
                                            </td>

                                            <td>
                                                <a class="btn btn-info" href="{{route('toggle_order_item_status', $product->id)}}">{{$product->order_item_status  ? 'Stokda' : 'Yoxdur'}}</a>
                                            </td>

                                            <td>{{ number_format($product->price, 2) }} ₽</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <h5><strong>Yekun Məbləğ:</strong> {{ number_format($order->final_price, 2) }} ₽</h5>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@include('admin.includes.footer')
