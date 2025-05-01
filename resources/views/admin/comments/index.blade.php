@include('admin.includes.header')

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">Rəylər</h4>
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
                                        <th>Ulduz</th>
                                        <th>Rəy</th>
                                        <th>Əməliyyat</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($comments as $comment)
                                        <tr>
                                            <td class="align-middle">
                                                {{ $comment->customer?->id ?? 'Müştəri silinib' }}
                                            </td>
                                            <td class="align-middle">
                                                {{ $comment->customer?->name ?? 'Müştəri silinib' }}
                                            </td>
                                            <td class="align-middle">
                                                @if($comment->product)
                                                    <a href="{{ route('products.edit', $comment->product->id) }}" class="text-decoration-none">
                                                        <p class="mb-1 fw-bold">{{ $comment->product->code }}</p>
                                                        <img src="{{ $comment->product->image }}"
                                                             class="img-thumbnail"
                                                             style="width: 70px; height: 90px"
                                                             alt="Product Image">
                                                        <p class="mb-0">{{ $comment->product->title }}</p>
                                                    </a>
                                                @else
                                                    <span class="text-danger">Məhsul silinib</span>
                                                @endif
                                            </td>
                                            <td class="align-middle">
                                                @php
                                                    $fullStars = floor($comment->star);
                                                @endphp
                                                @for ($i = 0; $i < $fullStars; $i++)
                                                    <i class="fa fa-star text-warning"></i>
                                                @endfor
                                            </td>
                                            <td class="align-middle">
                                                {{ $comment->comment }}
                                            </td>
                                            <td class="align-middle">
                                                <div class="d-flex justify-content-center gap-2">
                                                    <form action="{{ route('comments.update', $comment->id) }}" method="post">
                                                        @csrf
                                                        @method('PUT')
                                                        <button class="btn {{ $comment->is_accept ? 'btn-warning' : 'btn-success' }}">
                                                            {{ $comment->is_accept ? 'Rədd et' : 'Qəbul et' }}
                                                        </button>
                                                    </form>

                                                    <form action="{{ route('comments.destroy', $comment->id) }}" method="post">
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
                                {{ $comments->links('admin.vendor.pagination.bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.includes.footer')
