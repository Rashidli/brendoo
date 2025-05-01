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
                                <h4 class="card-title">Qəsəbələr</h4>
                                    <a href="{{route('settlements.create')}}" class="btn btn-primary">+</a>
                                <br>
                                <br>
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0">

                                        <thead>
                                            <tr>
                                                <th>№</th>
                                                <th>Qəsəbə</th>
                                                <th>Bölgə</th>
                                                <th>Şəhər</th>
                                                <th>Əməliyyat</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                        @foreach($settlements as $settlement)

                                            <tr>
                                                <th scope="row">{{$settlement->id}}</th>
                                                <th scope="row">{{$settlement->name}}</th>
                                                <th scope="row">{{$settlement->district?->name}}</th>
                                                <th scope="row">{{$settlement->district?->city?->name}}</th>
{{--                                                <td><img src="{{asset('storage/'.$settlement->image)}}" style="width: 100px; height: 50px" alt=""></td>--}}
                                                <td>
                                                    <a href="{{route('settlements.edit',$settlement->id)}}" class="btn btn-primary" style="margin-right: 15px" >Edit</a>
                                                    <form action="{{route('settlements.destroy', $settlement->id)}}" method="post" style="display: inline-block">
                                                        {{ method_field('DELETE') }}
                                                        @csrf
                                                        <button onclick="return confirm('Məlumatın silinməyin təsdiqləyin')" type="submit" class="btn btn-danger">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>

                                        @endforeach

                                        </tbody>
                                    </table>
                                    <br>
                                    {{ $settlements->links('admin.vendor.pagination.bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>



@include('admin.includes.footer')
