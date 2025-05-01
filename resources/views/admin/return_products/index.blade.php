@include('admin.includes.header')

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">İadələr</h4>
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
                                        <th>Rəy</th>
                                        <th>Status</th>
                                        <th>Əməliyyat</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($return_products as $return_product)
                                        <tr>
                                            <td class="align-middle">
                                                {{ $return_product->customer?->id ?? 'Müştəri silinib' }}
                                            </td>
                                            <td class="align-middle">
                                                {{ $return_product->customer?->name ?? 'Müştəri silinib' }}
                                            </td>
                                            <td class="align-middle">
                                                @if($return_product->orderItem?->product)
                                                    <a href="{{ route('products.edit', $return_product->orderItem->product->id) }}" class="text-decoration-none">
                                                        <p class="mb-1 fw-bold">{{ $return_product->orderItem->product->code }}</p>
                                                        <img src="{{ $return_product->orderItem->product->image }}"
                                                             class="img-thumbnail"
                                                             style="width: 70px; height: 90px"
                                                             alt="Product Image">
                                                        <p class="mb-0">{{ $return_product->orderItem->product->title }}</p>
                                                    </a>
                                                @else
                                                    <span class="text-danger">Məhsul silinib</span>
                                                @endif
                                            </td>
                                            <td class="align-middle">
                                                {{ $return_product->reason }}
                                            </td>
                                            <td class="align-middle">
                                                <select class="form-select status-select"
                                                        data-id="{{ $return_product->id }}">
                                                    <option value="pending" {{ $return_product->status == 'pending' ? 'selected' : '' }}>Gözləyir</option>
                                                    <option value="approved" {{ $return_product->status == 'approved' ? 'selected' : '' }}>Təsdiqləndi</option>
                                                    <option value="rejected" {{ $return_product->status == 'rejected' ? 'selected' : '' }}>İmtina edildi</option>
                                                </select>
                                            </td>
                                            <td class="align-middle">
                                                <form action="{{ route('return_products.destroy', $return_product->id) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button onclick="return confirm('Məlumatın silinməyin təsdiqləyin')"
                                                            type="submit" class="btn btn-danger">
                                                        Sil
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-3">
                                {{ $return_products->links('admin.vendor.pagination.bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.includes.footer')

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll('.status-select').forEach(select => {
            select.addEventListener('change', function () {
                let productId = this.dataset.id;
                let newStatus = this.value;

                fetch(`/admin/return-products/${productId}/update-status`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ status: newStatus })
                }).then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert("Status dəyişdirildi!");
                        } else {
                            alert("Xəta baş verdi!");
                        }
                    }).catch(error => console.log(error));
            });
        });
    });
</script>
