@include('admin.includes.header')

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            <!-- Filtrlər -->
            <div class="row mb-4">
                <div class="col-lg-12">
                    <div class="card shadow-sm">
                        @if(session('message'))
                            <div class="alert alert-success">{{ session('message') }}</div>
                        @endif
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Paketlər</h5>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="{{ route('packages.index') }}">
                                <div class="row g-3">

                                    <div class="col-md-3">
                                        <label class="form-label">Barkod</label>
                                        <input type="text" name="barcode" class="form-control"
                                               value="{{ request('barcode') }}">
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label">Başlanğıc tarix</label>
                                        <input type="date" name="start_date" class="form-control"
                                               value="{{ request('start_date') }}">
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label">Bitmə tarixi</label>
                                        <input type="date" name="end_date" class="form-control"
                                               value="{{ request('end_date') }}">
                                    </div>

                                    <div class="col-md-3 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary w-100">Filtrlə</button>
                                    </div>

                                    <div class="col-md-3 d-flex align-items-end">
                                        <a href="{{ route('packages.index') }}"
                                           class="btn btn-secondary w-100">Sıfırla</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Paketlər cədvəli -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-dark text-white">
                            <h5 class="mb-0">Paketlər</h5>
                        </div>
                        <div class="card-body">
                            @if(session('message'))
                                <div class="alert alert-success">{{ session('message') }}</div>
                            @endif

                            <div class="table-responsive">
                                <table class="table table-bordered align-middle table-hover table-striped">
                                    <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Barkod</th>
                                        <th>Çəki (q)</th>
                                        <th>Qeyd</th>
                                        <th>Sifariş sayı</th>
                                        <th>Məhsullar</th>
                                        <th>Waybill</th>
                                        <th>Yaradılma</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($packages as $package)
                                        <tr>

                                            <td>{{ $package->id }}</td>
                                            <td>{{ $package->barcode }}</td>
                                            <td>{{ $package->weight }} q</td>
                                            {{-- Əgər kq istəsən: number_format($package->weight / 1000, 2) . ' kq' --}}
                                            <td>{{ $package->note }}</td>
                                            <td>
                                                {{ $package->order_items_count ?? $package->orderItems()->count() }}
                                            </td>
                                            <td>
                                                @foreach($package->orderItems as $orderItem)
                                                    <span class="badge bg-light text-dark">
                                                        {{ $orderItem->product?->title ?? 'Məhsul tapılmadı' }}
                                                    </span><br>
                                                @endforeach
                                            </td>
                                            <td>
                                                @if($package->topdelivery_waybill_path)
                                                    <a href="{{ $package->topdelivery_waybill_path }}"
                                                       target="_blank" class="btn btn-sm btn-secondary">PDF Bax</a>
                                                    <button
                                                        onclick="window.open('{{ $package->topdelivery_waybill_path }}', '_blank').print()"
                                                        class="btn btn-sm btn-info">Print
                                                    </button>
                                                @endif
                                            </td>
                                            <td>{{ $package->created_at->format('d/m/Y H:i') }}</td>

                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>


                            <div class="mt-3">
                                {{ $packages->withQueryString()->links() }}
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@include('admin.includes.footer')

<!-- Select all checkbox JS -->
<script>
    document.getElementById('checkAllPackages').addEventListener('change', function () {
        const checkboxes = document.querySelectorAll('table .package-checkbox');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });
</script>
