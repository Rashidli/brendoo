@include('admin.includes.header')

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">Stock bildirişləri</h4>
                        </div>
                        <div class="card-body">
                            @if(session('message'))
                                <div class="alert alert-success">{{ session('message') }}</div>
                            @endif

                            <div class="table-responsive">
                                <table class="table table-striped table-bordered text-center align-middle">
                                    <thead class="table-dark">
                                    <tr>
                                        <th>Müştəri ID</th>
                                        <th>Müştəri</th>
                                        <th>Məhsul</th>
                                        <th>Seçilib</th>
                                        <th>Əməliyyat</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($stock_notifications as $stock_notification)
                                        <tr>
                                            <td class="align-middle">
                                                {{ $stock_notification->customer?->id ?? 'Müştəri silinib' }}
                                            </td>
                                            <td class="align-middle">
                                                {{ $stock_notification->customer?->name ?? 'Müştəri silinib' }}
                                            </td>
                                            <td class="align-middle">
                                                @if($stock_notification->product)
                                                    <a href="{{ route('products.edit', $stock_notification->product->id) }}" class="text-decoration-none">
                                                        <p class="mb-1 fw-bold">{{ $stock_notification->product->code }}</p>
                                                        <img src="{{ $stock_notification->product->image }}"
                                                             class="img-thumbnail"
                                                             style="width: 70px; height: 90px"
                                                             alt="Product Image">
                                                        <p class="mb-0">{{ $stock_notification->product->title }}</p>
                                                    </a>
                                                @else
                                                    <span class="text-danger">Məhsul silinib</span>
                                                @endif
                                            </td>
                                            <td>{{$stock_notification->option?->filter?->title}}: {{$stock_notification->option?->title}}</td>
                                            <td class="align-middle">
                                                <div class="d-flex justify-content-center gap-2">
                                                    <form action="#" method="post">
                                                        @csrf
                                                        @method('PUT')
                                                        <button class="btn {{ $stock_notification->is_accept ? 'btn-warning' : 'btn-success' }}">
                                                            {{ $stock_notification->is_mailed ? 'Mail Göndərilib' : 'Mail göndər' }}
                                                        </button>
                                                    </form>

                                                    <form action="{{ route('stock_notifications.destroy', $stock_notification->id) }}" method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button onclick="return confirm('Məlumatın silinməyin təsdiqləyin')"
                                                                type="submit" class="btn btn-danger">
                                                            Sil
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-3">
                                {{ $stock_notifications->links('admin.vendor.pagination.bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.includes.footer')
