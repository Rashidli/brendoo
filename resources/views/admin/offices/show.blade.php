@include('admin.includes.header')

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

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
