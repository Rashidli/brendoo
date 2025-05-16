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
                            <h4 class="card-title">Loglar</h4>
                            <br>

                            <!-- Axtarış Formu -->
                            <form method="GET" action="{{ route('admin.logs.index') }}">
                                <div class="row">
                                    <div class="col-md-2">
                                        <input type="text" name="log_name" class="form-control"
                                               placeholder="Log adı üzrə axtar" value="{{ request('log_name') }}">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" name="event" class="form-control"
                                               placeholder="Hadisə növü üzrə axtar" value="{{ request('event') }}">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" name="causer_id" class="form-control"
                                               placeholder="User ID üzrə axtar" value="{{ request('causer_id') }}">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" name="subject_type" class="form-control"
                                               placeholder="Model tipi üzrə axtar" value="{{ request('subject_type') }}">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="date" name="start_date" class="form-control"
                                               placeholder="" value="{{ request('start_date') }}">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="date" name="end_date" class="form-control"
                                               placeholder="Model tipi üzrə axtar" value="{{ request('end_date') }}">
                                    </div>
                                    <div class="col-md-2 mt-2">
                                        <button type="submit" class="btn btn-primary">Axtar</button>
                                        <a href="{{ route('admin.logs.index') }}" class="btn btn-secondary">Sıfırla</a>
                                    </div>
                                </div>
                            </form>
                            <br>

                            <div class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <thead>
                                    <tr>
                                        <th>№</th>
                                        <th>Log Adı</th>
                                        <th>Hadisə</th>
                                        <th>Açıqlama</th>
                                        <th>Model</th>
                                        <th>Model ID</th>
                                        <th>İstifadəçi</th>
                                        <th>Tarix</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($logs as $key => $log)
                                        <tr>
                                            <th scope="row">{{ $key+1 }}</th>
                                            <td>{{ $log->log_name ?? '-' }}</td>
                                            <td>{{ $log->event ?? '-' }}</td>
                                            <td>
                                                <button class="btn btn-info btn-sm show-log-details"
                                                        data-description="{{ json_encode($log->properties) }}">
                                                    Bax
                                                </button>
                                            </td>
                                            <td>{{ class_basename($log->subject_type) }}</td>
                                            <td>{{ $log->subject_id }}</td>
                                            <td>ID {{ optional($log->causer)->id }}: {{ optional($log->causer)->name ?? 'Sistem' }}</td>
                                            <td>{{ $log->created_at->format('d.m.Y H:i') }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <br>
                                {{ $logs->links('admin.vendor.pagination.bootstrap-5') }}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Popup Modal -->
<div class="modal fade" id="logDetailsModal" tabindex="-1" aria-labelledby="logDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logDetailsModalLabel">Log Açıqlaması</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <pre id="logDetailsContent"></pre>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bağla</button>
            </div>
        </div>
    </div>
</div>

@include('admin.includes.footer')

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const logButtons = document.querySelectorAll(".show-log-details");

        logButtons.forEach(button => {
            button.addEventListener("click", function () {
                const description = JSON.parse(this.getAttribute("data-description"));
                document.getElementById("logDetailsContent").textContent = JSON.stringify(description, null, 4);
                new bootstrap.Modal(document.getElementById("logDetailsModal")).show();
            });
        });
    });
</script>
