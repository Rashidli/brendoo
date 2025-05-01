@include('admin.includes.header')

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            <!-- Filtrlər -->
            <div class="row mb-4">
                <div class="col-lg-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Sifarişləri Filtrlə</h5>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="{{ route('orders.index') }}">
                                <div class="row g-3">
                                    <div class="col-md-2">
                                        <label class="form-label">Status</label>
                                        <select name="status" class="form-control">
                                            <option value="">Status seçin</option>
                                            @foreach(\App\Http\Enums\OrderStatus::cases() as $status)
                                                <option
                                                    value="{{ $status->value }}" {{ request('status') == $status->value ? 'selected' : '' }}>
                                                    {{ \App\Http\Enums\OrderStatus::label($status->value) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <label class="form-label">Admin Status</label>
                                        <select name="admin_status" class="form-control">
                                            <option value="">Status seçin</option>
                                            @foreach(\App\Http\Enums\AdminOrderStatus::cases() as $admin_status)
                                                <option
                                                    value="{{ $admin_status->value }}" {{ request('admin_status') == $admin_status->value ? 'selected' : '' }}>
                                                    {{ \App\Http\Enums\AdminOrderStatus::label($admin_status->value) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <label class="form-label">Müştəri kodu</label>
                                        <input type="text" name="customer_id" class="form-control"
                                               value="{{ request('customer_id') }}">
                                    </div>

                                    <div class="col-md-2">
                                        <label class="form-label">Müştəri email</label>
                                        <input type="text" name="customer_mail" class="form-control"
                                               value="{{ request('customer_mail') }}">
                                    </div>

                                    <div class="col-md-2">
                                        <label class="form-label">Müştəri adı</label>
                                        <input type="text" name="name" class="form-control"
                                               value="{{ request('name') }}">
                                    </div>

                                    <div class="col-md-2">
                                        <label class="form-label">Başlanğıc tarix</label>
                                        <input type="date" name="start_date" class="form-control"
                                               value="{{ request('start_date') }}">
                                    </div>

                                    <div class="col-md-2">
                                        <label class="form-label">Bitmə tarixi</label>
                                        <input type="date" name="end_date" class="form-control"
                                               value="{{ request('end_date') }}">
                                    </div>

                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary w-100">Filtrlə</button>
                                    </div>

                                    <div class="col-md-2 d-flex align-items-end">
                                        <a href="{{ route('orders.index') }}"
                                           class="btn btn-secondary w-100">Sıfırla</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sifarişlər Cədvəli -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-dark text-white">
                            <h5 class="mb-0">Sifarişlər</h5>
                        </div>
                        <div class="card-body">
                            @if(session('message'))
                                <div class="alert alert-success">{{ session('message') }}</div>
                            @endif

                            <div class="table-responsive">
                                <table class="table table-bordered align-middle table-hover table-striped">
                                    <thead class="table-light">
                                    <tr>
                                        <th>Detallar</th>
                                        <th>Sifariş nömrəsi</th>
                                        <th>Müştəri kodu</th>
                                        <th>Müştəri</th>
                                        <th>Address</th>
                                        <th>Məbləğ</th>
                                        <th>Endirim</th>
                                        <th>Yekun</th>
                                        <th>Tarix</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($orders as $order)
                                        <tr class="{{ \App\Http\Enums\OrderStatus::color($order->status) }}">
                                            <td>
                                                <a href="{{ route('orders.show', $order->id) }}"
                                                   class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i> Bax
                                                </a>
                                            </td>
                                            <td>{{ $order->order_number }}</td>
                                            <td>{{ $order->customer?->id }}</td>
                                            <td>{{ $order->customer?->name }} <br> {{ $order->customer?->email }}</td>
                                            <td style="max-width: 150px; text-wrap: wrap">{{ $order->address }}</td>
                                            <td>{{ number_format($order->total_price, 2) }} ₽</td>
                                            <td>{{ $order->discount }}</td>
                                            <td>{{ number_format($order->final_price, 2) }} ₽</td>
                                            <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                        </tr>

                                        @foreach($order->order_items as $item)
                                            <tr>
                                                <td colspan="9">
                                                    <div class="table-responsive">
                                                        <table
                                                            class="table table-bordered table-striped table-hover mb-0"
                                                            style="table-layout: fixed; width: 100%;">
                                                            <thead class="table-light">
                                                            <tr>
                                                                <th style="width: 40%;">Məhsul adı</th>
                                                                <th style="width: 20%;">Miqdar</th>
                                                                <th style="width: 20%;">Qiyməti</th>
                                                                <th style="width: 20%;">Status</th>
                                                                <th style="width: 20%;">Admin Status</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr>
                                                                <td>{{ $item->product?->title }}</td>
                                                                <td>{{ $item->quantity }}</td>
                                                                <td>{{ number_format($item->price, 2) }} ₽</td>
                                                                <td>{{ \App\Http\Enums\OrderStatus::label($item->status) }}</td>
                                                                <td>
                                                                    @if($item->admin_status)
                                                                        {{ \App\Http\Enums\AdminOrderStatus::label($item->admin_status) }}
                                                                    @else

                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </td>
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

        </div>
    </div>
</div>

@include('admin.includes.footer')
