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
                                <h4 class="card-title">Tags</h4>
                                        <a href="{{route('tags.create')}}" class="btn btn-primary">+</a>
                                <br>
                                <br>
                                <div class="table-responsive">
                                    <table class="table table-centered mb-0 align-middle table-hover table-nowrap">

                                        <thead>
                                            <tr>
                                                <th>№</th>
                                                <th>Başlıq</th>
                                                <th>Status</th>
                                                <th>Əməliyyat</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($tags as $tag)

                                            <tr>
                                                <th scope="row">{{$tag->id}}</th>
                                                <th scope="row">{{$tag->title}}</th>
{{--                                                <td><img src="{{asset('storage/'.$tag->image)}}" style="width: 100px; height: 50px" alt=""></td>--}}
                                                <td>{{$tag->is_active == true ? 'Active' : 'Deactive'}}</td>
                                                <td>
                                                    <a href="{{route('tags.edit',$tag->id)}}" class="btn btn-primary" style="margin-right: 15px" >Edit</a>
                                                    <form action="{{route('tags.destroy', $tag->id)}}" method="post" style="display: inline-block">
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
                                    {{ $tags->links('admin.vendor.pagination.bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>



@include('admin.includes.footer')
