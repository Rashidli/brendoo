@include('admin.includes.header')

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <nav aria-label="breadcrumb" style="margin-bottom: 20px;">
                                <ol class="breadcrumb bg-light p-3 rounded">
                                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('filters.index', $filter->id) }}">Filter Siyahı</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ $filter->translate('en')?->title }}</li>
                                </ol>
                            </nav>
                            @if(session('message'))
                                <div class="alert alert-success">{{ session('message') }}</div>
                            @endif
                            <h4 class="card-title">{{ $filter->title }} üçün optionlar</h4>
                            <a href="{{ route('filters.options.create', $filter->id) }}" class="btn btn-primary">+</a>
                            <br>
                            <br>
                            <div class="table-responsive">
                                <table class="table table-centered mb-0 align-middle table-hover table-nowrap">
                                    <thead class="table-light">
                                    <tr>
                                        <th>№</th>
                                        <th>Başlıq</th>
                                        <th>Status</th>
                                        <th>Əməliyyat</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($options as $key => $option)
                                        <tr >
                                            <th scope="row">{{ $key+1 }}</th>
                                            <td >{{ $option->title }}
                                                @if($option->color_code)
                                                    <span style="display: inline-block;width: 20px; height: 20px; border-radius: 50%; background-color: {{$option->color_code}}"></span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($option->is_active)
                                                    <i class="ri-checkbox-blank-circle-fill font-size-10 text-success align-middle me-2"></i>Active
                                                @else
                                                    Deactive
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('filters.options.edit', [$filter->id, $option->id]) }}" class="btn btn-primary" style="margin-right: 15px">Edit</a>
                                                <form action="{{ route('filters.options.destroy', [$filter->id, $option->id]) }}" method="post" style="display: inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button onclick="return confirm('Məlumatın silinməyin təsdiqləyin')" type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                                <br>
{{--                                {{ $options->links('admin.vendor.pagination.bootstrap-5') }}--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.includes.footer')
