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
                                <h4 class="card-title">Arxa fon şəkli</h4>
{{--                                    <a href="{{route('register_images.create')}}" class="btn btn-primary">+</a>--}}
                                <br>
                                <br>

                                <div class="table-responsive">
                                    <table class="table table-centered mb-0 align-middle table-hover table-nowrap">

                                        <thead>
                                            <tr>
                                                <th>№</th>
                                                <th>Şəkil</th>
                                                <th>Əməliyyat</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                        @foreach($register_images as $key => $register_image)

                                            <tr>
                                                <td>{{$register_image->id}}</td>
                                                <td><img style="width: 100px; height: 100px" src="{{asset('storage/' . $register_image->register_image)}}" alt=""></td>
                                                <td>
                                                    <a href="{{route('register_images.edit',$register_image->id)}}" class="btn btn-primary" style="margin-right: 15px" >Edit</a>
{{--                                                    <form action="{{route('register_images.destroy', $register_image->id)}}" method="post" style="display: inline-block">--}}
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
                                    {{ $register_images->links('admin.vendor.pagination.bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@include('admin.includes.footer')
