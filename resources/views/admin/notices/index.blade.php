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
                                <h4 class="card-title">Bildirişlər</h4>
{{--                                    <a href="{{route('notices.create')}}" class="btn btn-primary">+</a>--}}
                                <br>
                                <br>
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0">

                                        <thead>
                                            <tr>
                                                <th>№</th>
                                                <th>Başlıq</th>
                                                <th>Mətn</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                        @foreach($notices as $key => $notice)

                                            <tr>
                                                <th scope="row">{{$key+1}}</th>
                                                <th scope="row">{{$notice->title}}</th>
                                                <th scope="row">{{$notice->body}}</th>
{{--                                                <td><img src="{{asset('storage/'.$notice->image)}}" style="width: 100px; height: 50px" alt=""></td>--}}
{{--                                                <td>{{$notice->is_active  ? 'Active' : 'Deactive'}}</td>--}}
{{--                                                <td>--}}
{{--                                                    <a href="{{route('notices.edit',$notice->id)}}" class="btn btn-primary" style="margin-right: 15px" >Edit</a>--}}
{{--                                                    <form action="{{route('notices.destroy', $notice->id)}}" method="post" style="display: inline-block">--}}
{{--                                                        {{ method_field('DELETE') }}--}}
{{--                                                        @csrf--}}
{{--                                                        <button onclick="return confirm('Məlumatın silinməyin təsdiqləyin')" type="submit" class="btn btn-danger">Delete</button>--}}
{{--                                                    </form>--}}
{{--                                                </td>--}}
                                            </tr>

                                        @endforeach

                                        </tbody>
                                    </table>
                                    <br>
                                    {{ $notices->links('admin.vendor.pagination.bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>



@include('admin.includes.footer')
