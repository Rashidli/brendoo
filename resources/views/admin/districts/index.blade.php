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
                                <h4 class="card-title">Bölgələr</h4>
                                    <a href="{{route('districts.create')}}" class="btn btn-primary">+</a>
                                <br>
                                <br>
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0">

                                        <thead>
                                            <tr>
                                                <th>№</th>
                                                <th>Rayon</th>
                                                <th>Şəhər</th>
                                                <th>Əməliyyat</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                        @foreach($districts as $district)

                                            <tr>
                                                <th scope="row">{{$district->id}}</th>
                                                <th scope="row">{{$district->name}}</th>
                                                <th scope="row">{{$district->city?->name}}</th>
{{--                                                <td><img src="{{asset('storage/'.$district->image)}}" style="width: 100px; height: 50px" alt=""></td>--}}
                                                <td>
                                                    <a href="{{route('districts.edit',$district->id)}}" class="btn btn-primary" style="margin-right: 15px" >Edit</a>
                                                    <form action="{{route('districts.destroy', $district->id)}}" method="post" style="display: inline-block">
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
                                    {{ $districts->links('admin.vendor.pagination.bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>



@include('admin.includes.footer')
