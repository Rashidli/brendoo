@include('admin.includes.header')

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            <!-- Filtrlər -->
            <div class="row mb-4">
                <div class="col-lg-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Filtr və Hesabat</h5>
                            <div>
                                <strong>Ümumi Məbləğ:</strong> {{ number_format($totalRevenue, 2) }} ₽ |
                                <strong>Sifariş sayı:</strong> {{ $totalItems }} |
                                <strong>Məhsul sayı:</strong> {{ $totalQuantity }}
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="{{ route('reports.index') }}">
                                <div class="row g-3">
                                    <div class="col-md-2">
                                        <label class="form-label">Status</label>
                                        <select name="status" class="form-control">
                                            <option value="">Seçin</option>
                                            @foreach(\App\Http\Enums\OrderStatus::cases() as $status)
                                                <option value="{{ $status->value }}" {{ request('status') == $status->value ? 'selected' : '' }}>
                                                    {{ \App\Http\Enums\OrderStatus::label($status->value) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Admin Status</label>
                                        <select name="admin_status" class="form-control">
                                            <option value="">Seçin</option>
                                            @foreach(\App\Http\Enums\AdminOrderStatus::cases() as $admin_status)
                                                <option value="{{ $admin_status->value }}" {{ request('admin_status') == $admin_status->value ? 'selected' : '' }}>
                                                    {{ \App\Http\Enums\AdminOrderStatus::label($admin_status->value) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Müştəri kodu</label>
                                        <input type="text" name="customer_id" class="form-control" value="{{ request('customer_id') }}">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Müştəri email</label>
                                        <input type="text" name="customer_mail" class="form-control" value="{{ request('customer_mail') }}">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Müştəri adı</label>
                                        <input type="text" name="name" class="form-control" value="{{ request('name') }}">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Başlanğıc</label>
                                        <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Bitmə</label>
                                        <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary w-100">Filtrlə</button>
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <a href="{{ route('reports.index') }}" class="btn btn-secondary w-100">Sıfırla</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Order Items Cədvəli -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-dark text-white">
                            <h5 class="mb-0">Sifariş məhsulları</h5>
                        </div>
                        <div class="card-body">
                            @if(session('message'))
                                <div class="alert alert-success">{{ session('message') }}</div>
                            @endif

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover align-middle">
                                    <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Məhsul</th>
                                        <th>Müştəri</th>
                                        <th>Qiymət</th>
                                        <th>Miqdar</th>
                                        <th>Cəmi</th>
                                        <th>Status</th>
                                        <th>Admin Status</th>
                                        <th>Tarix</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($orderItems as $item)
                                        <tr class="{{ \App\Http\Enums\OrderStatus::color($item->status) }}">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->product?->title }}</td>
                                            <td>
                                                {{ $item->order?->customer?->id }}<br>
                                                {{ $item->order?->customer?->name }}<br>
                                                {{ $item->order?->customer?->email }}
                                            </td>
                                            <td>{{ number_format($item->price, 2) }} ₽</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ number_format($item->price * $item->quantity, 2) }} ₽</td>
                                            <td>{{ \App\Http\Enums\OrderStatus::label($item->status) }}</td>
                                            <td>{{ \App\Http\Enums\AdminOrderStatus::label($item->admin_status) ?? '—' }}</td>
                                            <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            {{ $orderItems->links('admin.vendor.pagination.bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@include('admin.includes.footer')
