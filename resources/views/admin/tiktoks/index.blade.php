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
                            <h4 class="card-title">Tiktok hekayələri</h4>
                               <a href="{{route('tiktoks.create')}}" class="btn btn-primary">+</a>
                            <br>
                            <br>
                            <div class="table-responsive">
                                <table class="table table-centered mb-0 align-middle table-hover table-nowrap">

                                    <thead>
                                        <tr>
                                            <th>№</th>
                                            <th>Başlıq</th>
                                            <th>Məhsulları</th>
                                            <th>Əməliyyat</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        @foreach($tiktoks as $tiktok)

                                        <tr>
                                            <th scope="row">{{$tiktok->id}}</th>
                                            <th scope="row">{{$tiktok->title}}</th>
                                            <th scope="row"><a class="btn btn-info" href="{{route('tiktoks.show', $tiktok->id)}}">Əlavə et</a></th>
                                            {{--                                                <td><img src="{{asset('storage/'.$tiktok->image)}}" style="width: 100px; height: 50px" alt=""></td>--}}
                                            <td>
                                                <a href="{{route('tiktoks.edit',$tiktok->id)}}" class="btn btn-primary"
                                                   style="margin-right: 15px">Edit</a>
                                                <form action="{{route('tiktoks.destroy', $tiktok->id)}}" method="post" style="display: inline-block">
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
                                {{ $tiktoks->links('admin.vendor.pagination.bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@include('admin.includes.footer')
