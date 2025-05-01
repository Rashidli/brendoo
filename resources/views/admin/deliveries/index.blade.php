@include('admin.includes.header')

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                @if(session('message'))
                                    <div class="alert alert-success">{{session('message')}}</div>
                                @endif
                                <h4 class="card-title">Çatdırılma haqqında məlumat</h4>
{{--                                    <a href="{{route('deliveries.create')}}" class="btn btn-primary">+</a>--}}
                                <br>
                                <br>
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0">

                                        <thead>
                                            <tr>
                                                <th>№</th>
                                                <th>Başlıq</th>
                                                <th>Status</th>
                                                <th>Əməliyyat</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                        @foreach($deliveries as $delivery)

                                            <tr>
                                                <th scope="row">{{$delivery->id}}</th>
                                                <th scope="row">{{$delivery->title}}</th>
                                                <td>{{$delivery->is_active ? 'Active' : 'Deactive'}}</td>
                                                <td>
                                                    <a href="{{route('deliveries.edit',$delivery->id)}}" class="btn btn-primary" style="margin-right: 15px" >Edit</a>
{{--                                                    <form action="{{route('deliveries.destroy', $delivery->id)}}" method="post" style="display: inline-block">--}}
{{--                                                        {{ method_field('DELETE') }}--}}
{{--                                                        @csrf--}}
{{--                                                        <button onclick="return confirm('Məlumatın silinməyin təsdiqləyin')" type="submit" class="btn btn-danger">Delete</button>--}}
{{--                                                    </form>--}}
                                                </td>
                                            </tr>

                                        @endforeach

                                        </tbody>
                                    </table>
                                    <br>
                                    {{ $deliveries->links('admin.vendor.pagination.bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>



@include('admin.includes.footer')
