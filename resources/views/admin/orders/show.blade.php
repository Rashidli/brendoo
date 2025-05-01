@include('admin.includes.header')

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            <!-- Page Header -->
            <div class="row mb-4">
                <div class="col-12 d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">Sifariş Detalları #{{ $order->order_number }}</h3>
                    <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Geri
                    </a>
                </div>
            </div>

            <!-- Müştəri Məlumatları -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="card shadow-sm border-0 rounded-3">
                        <div class="card-header bg-info text-white fw-bold">
                            <i class="fas fa-user me-2"></i> Müştəri Məlumatları
                        </div>
                        <div class="card-body">
                            <p><strong>👤 Adı:</strong> {{ $order->customer?->name }}</p>
                            <p><strong>🆔 ID:</strong> {{ $order->customer?->id }}</p>
                            <p><strong>📍 Ünvan:</strong> {{ $order->address ?? 'Ünvan yoxdur' }}</p>
                            <p><strong>📝 Əlavə Məlumat:</strong> {{ $order->additional_info ?? 'Əlavə məlumat yoxdur' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sifariş Məhsulları -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card shadow-sm border-0 rounded-3">
                        <div class="card-header bg-dark text-white fw-bold">
                            <i class="fas fa-boxes me-2"></i> Sifariş Məhsulları
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
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
                                        <th>Admin status</th>
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
                                                     style="width: 70px; height: 90px; object-fit: cover;">
                                            </td>
                                            <td>
                                                @if($product->product)
                                                    <a href="{{ route('products.edit', $product->product?->id) }}"
                                                       class="text-primary text-decoration-none">
                                                        {{ $product->product?->title }}
                                                    </a>
                                                @else
                                                    <span class="text-muted">Silinmiş məhsul</span>
                                                @endif
                                            </td>
                                            <td>{{ $product->product?->brand?->title }}</td>
                                            <td>{{ $product->quantity }}</td>
                                            <td>
                                                @foreach($product->options as $option)
                                                    <span class="badge bg-secondary me-1">
                                                            {{ $option->filter?->title }}: {{ $option->option?->title }}
                                                        </span>
                                                @endforeach
                                            </td>

                                            <!-- Status dəyişdirmək -->
                                            <td>
                                                <form action="{{ route('orders.updateStatus', $product->id) }}" method="POST">
                                                    @csrf @method('PUT')
                                                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                                        @foreach(\App\Http\Enums\OrderStatus::cases() as $status)
                                                            <option value="{{ $status->value }}" {{ $product->status == $status->value ? 'selected' : '' }}>
                                                                {{ \App\Http\Enums\OrderStatus::label($status->value) }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </form>

                                                @php
                                                    $enumStatus = App\Http\Enums\OrderStatus::tryFrom($product->status);
                                                @endphp

                                                @if(!$enumStatus || !$enumStatus->isProgressable())
                                                    <div class="mt-2">
                                                            <span class="badge bg-danger">
                                                                {{ App\Http\Enums\OrderStatus::label($product->status) }}
                                                            </span>
                                                    </div>
                                                @else
                                                    @php
                                                        $progressSteps = App\Http\Enums\OrderStatus::progressSteps();
                                                        $currentIndex = $enumStatus->progressIndex();
                                                    @endphp
                                                    <div class="progress mt-2" style="height: 35px;">
                                                        @foreach($progressSteps as $index => $step)
                                                            @php
                                                                $isCompleted = $index <= $currentIndex;
                                                                $width = 100 / count($progressSteps);
                                                                $statusHistory = $product->statuses->where('status', $step->value)->first();
                                                            @endphp
                                                            <div class="progress-bar {{ $isCompleted ? 'bg-success' : 'bg-light text-dark' }}"
                                                                 style="width: {{ $width }}%; font-size: 11px;">
                                                                <div class="d-flex flex-column align-items-center">
                                                                    <span>{{ App\Http\Enums\OrderStatus::label($step->value) }}</span>
                                                                    @if($statusHistory)
                                                                        <small class="text-white">{{ \Carbon\Carbon::parse($statusHistory->created_at)->format('d/m/Y') }}</small>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </td>

                                            <!-- Admin Status -->
                                            <td>
                                                <form action="{{ route('admin_orders.updateStatus', $product->id) }}" method="POST">
                                                    @csrf @method('PUT')
                                                    <select name="admin_status" class="form-select form-select-sm" onchange="this.form.submit()">
                                                        @foreach(\App\Http\Enums\AdminOrderStatus::cases() as $admin_status)
                                                            <option value="{{ $admin_status->value }}" {{ $product->admin_status == $admin_status->value ? 'selected' : '' }}>
                                                                {{ \App\Http\Enums\AdminOrderStatus::label($admin_status->value) }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </form>
                                            </td>

                                            <!-- Price -->
                                            <td>{{ number_format($product->price, 2) }} ₽</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer text-end bg-light">
                            <h5 class="mb-0"><strong>Yekun Məbləğ:</strong> {{ number_format($order->final_price, 2) }} ₽</h5>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@include('admin.includes.footer')
