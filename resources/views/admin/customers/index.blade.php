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
                            <h4 class="card-title">Müştərilər</h4>
                            <br>
                            <br>
                                <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#bulkNotificationModal">Bütün Müştərilərə Bildiriş Göndər</button>
                                <br><br>
                            <!-- Search Form -->
                            <form method="GET" action="{{ route('customers.index') }}">
                                <div class="row">
                                    <div class="col-md-2">
                                        <input type="text" name="id" class="form-control" placeholder="Müştəri id"
                                               value="{{ request('id') }}">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" name="name" class="form-control" placeholder="Ad üzrə axtar"
                                               value="{{ request('name') }}">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" name="email" class="form-control"
                                               placeholder="Email üzrə axtar" value="{{ request('email') }}">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" name="phone" class="form-control"
                                               placeholder="Telefon üzrə axtar" value="{{ request('phone') }}">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-primary">Axtar</button>
                                        <a href="{{ route('customers.index') }}" class="btn btn-secondary">Sıfırla</a>
                                    </div>
                                </div>
                            </form>
                            <br>

                            <div class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Ad</th>
                                        <th>Telefon</th>
                                        <th>Doğum tarixi</th>
                                        <th>Email</th>
                                        <th>Cinsiyət</th>
                                        <th>Bildirişlər siyahı</th>
                                        <th>Bildiriş göndər</th>
                                        <th>Səbəti</th>
                                        <th>Favoritləri</th>
                                        <th>Əməliyyat</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($customers as $key => $customer)
                                        <tr>
                                            <th scope="row">{{ $customer->id }}</th>
                                            <td>{{ $customer->name }}</td>
                                            <td>{{ $customer->phone }}</td>
                                            <td>{{ $customer->birthday }}</td>
                                            <td>{{ $customer->email }}</td>
                                            <td>
                                                @if($customer->gender == 'man')
                                                   kişi
                                                @elseif($customer->gender == 'woman')
                                                    qadın
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('notices.index', $customer->id) }}" class="btn btn-primary">Bildirişlər siyahı</a>
                                            </td>
                                            <td>
                                                <button class="btn btn-info" data-bs-toggle="modal"
                                                        data-bs-target="#sendNotificationModal"
                                                        data-customer-id="{{ $customer->id }}">
                                                    Bildiriş Göndər
                                                </button>
                                            </td>

                                            <td>
                                                <a href="{{ route('customer_basket', $customer->id) }}" class="btn btn-primary">{{$customer->basket_items_count}} Məhsul</a>
                                            </td>
                                            <td>
                                                <a href="{{ route('favorites.index', $customer->id) }}" class="btn btn-primary">{{$customer->favorites_count}} Məhsul</a>
                                            </td>
                                            <td>
                                                <form action="{{ route('customer.toggleStatus', $customer->id) }}"
                                                      method="post" style="display: inline-block">
                                                    @csrf

                                                    @if($customer->is_blocked)

                                                        <button class="btn btn-success">
                                                            Blokdan çıxart
                                                        </button>
                                                    @else
                                                        <button
                                                            type="submit" class="btn btn-danger">
                                                            Blokla
                                                        </button>
                                                    @endif


                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <br>
                                {{ $customers->links('admin.vendor.pagination.bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Bulk Notification Modal -->
<div class="modal fade" id="bulkNotificationModal" tabindex="-1" aria-labelledby="bulkNotificationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bulkNotificationModalLabel">Bütün Müştərilərə Bildiriş Göndər</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('sendBulkNotification') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Başlıq</label>
                        <input type="text" name="title" class="form-control" id="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="body" class="form-label">Mətn</label>
                        <textarea name="body" class="form-control" id="body" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Göndər</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Single Notification Modal -->
<div class="modal fade" id="sendNotificationModal" tabindex="-1" aria-labelledby="sendNotificationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sendNotificationModalLabel">Müştəriyə Bildiriş Göndər</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('sendSingleNotification') }}">
                    @csrf
                    <input type="hidden" name="customer_id" id="customer_id">

                    <div class="mb-3">
                        <label for="title" class="form-label">Başlıq</label>
                        <input type="text" name="title" class="form-control" id="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="body" class="form-label">Mətn</label>
                        <textarea name="body" class="form-control" id="body" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Göndər</button>
                </form>
            </div>
        </div>
    </div>
</div>

@include('admin.includes.footer')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var notificationModal = document.getElementById("sendNotificationModal");

        notificationModal.addEventListener("show.bs.modal", function (event) {
            var button = event.relatedTarget; // Düyməni tapan kod
            var customerId = button.getAttribute("data-customer-id");

            var modalInput = document.getElementById("customer_id");
            modalInput.value = customerId;
        });
    });
</script>

