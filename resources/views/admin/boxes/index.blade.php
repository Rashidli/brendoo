@include('admin.includes.header')

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            @if(session('message'))
                                <div class="alert alert-success">{{ session('message') }}</div>
                            @endif

                            <h4 class="card-title">Qutular</h4>
                                <form method="GET" action="{{ route('boxes.index') }}" class="row mb-4">
                                    <div class="col-md-2">
                                        <input type="text" name="number" value="{{ request('number') }}" class="form-control" placeholder="Qutu nömrəsi">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" name="barcode" value="{{ request('barcode') }}" class="form-control" placeholder="Paket barkodu">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="number" name="customer_id" value="{{ request('customer_id') }}" class="form-control" placeholder="Müştəri ID">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="date" name="from" value="{{ request('from') }}" class="form-control" placeholder="Başlanğıc tarix">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="date" name="to" value="{{ request('to') }}" class="form-control" placeholder="Son tarix">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-secondary w-100">Axtar</button>
                                    </div>
                                </form>

                                <a href="{{ route('boxes.create') }}" class="btn btn-primary">+ Yeni Qutu</a>
                            <br><br>
                            <div class="table-responsive">
                                <table class="table table-centered mb-0 align-middle table-hover table-nowrap">
                                    <thead>
                                    <tr>
                                        <th>№</th>
                                        <th>Qutu nömrəsi</th>
                                        <th>Qeyd</th>
                                        <th>Paket sayı</th>
                                        <th>Paketlər</th>
                                        <th>Müştəri ID-lər</th>
                                        <th>Ümumi çəki</th>
                                        <th>Əməliyyat</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($boxes as $box)
                                        <tr>
                                            <td>{{ $box->id }}</td>
                                            <td>{{ $box->number }}</td>
                                            <td>{{ $box->note }}</td>
                                            <td>{{ $box->packages->count() }}</td>
                                            <td>
                                                @foreach($box->packages as $pack)
                                                    {{$pack->barcode}} <br>
                                                @endforeach
                                            </td>
                                            <td>
                                                @php
                                                    $customerIds = collect();
                                                @endphp
                                                @foreach($box->packages as $pack)
                                                    @foreach($pack->orderItems as $orderItem)
                                                        @php $customerIds->push($orderItem->customer_id); @endphp
                                                    @endforeach
                                                @endforeach
                                                @foreach($customerIds->unique() as $id)
                                                    {{ $id }} <br>
                                                @endforeach
                                            </td>

                                            <td>
                                                {{
                                                    number_format(
                                                        $box->packages->sum('weight'),
                                                        2
                                                    )
                                                }} q
                                            </td>
                                            <td>
                                                <a href="{{ route('boxes.edit', $box->id) }}" class="btn btn-primary" style="margin-right: 10px">Edit</a>
                                                <form action="{{ route('boxes.destroy', $box->id) }}" method="post" style="display:inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger"
                                                            onclick="return confirm('Qutunu silmək istədiyinizə əminsiniz?')">Sil</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <br>
                                {{ $boxes->links('admin.vendor.pagination.bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.includes.footer')
