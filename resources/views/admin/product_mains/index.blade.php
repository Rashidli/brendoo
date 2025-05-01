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
                                <h4 class="card-title">Product hero</h4>
{{--                                    <a href="{{route('product_mains.create')}}" class="btn btn-primary">+</a>--}}
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
                                        @foreach($product_mains as $product_main)

                                            <tr>
                                                <th scope="row">{{$product_main->id}}</th>
                                                <th scope="row">{{$product_main->title}}</th>
{{--                                                <td><img src="{{asset('storage/'.$product_main->image)}}" style="width: 100px; height: 50px" alt=""></td>--}}
                                                <td>{{$product_main->is_active == true ? 'Active' : 'Deactive'}}</td>
                                                <td>
                                                    <a href="{{route('product_mains.edit',$product_main->id)}}" class="btn btn-primary" style="margin-right: 15px" >Edit</a>
{{--                                                    <form action="{{route('product_mains.destroy', $product_main->id)}}" method="post" style="display: inline-block">--}}
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
                                    {{ $product_mains->links('admin.vendor.pagination.bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>



@include('admin.includes.footer')
