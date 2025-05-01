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
                            <h4 class="card-title">Alt Kateqoriyalar</h4>
                               <a href="{{route('sub_categories.create')}}" class="btn btn-primary">+</a>
                            <br>
                            <br>
                            <div class="table-responsive">
                                <table class="table table-centered mb-0 align-middle table-hover table-nowrap">

                                    <thead>
                                        <tr>
                                            <th>№</th>
                                            <th>Başlıq</th>
                                            <th>Üst kateqoriya</th>
                                            <th>Əməliyyat</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach($sub_categories as $sub_category)

                                        <tr>
                                            <th scope="row">{{$sub_category->id}}</th>
                                            <th scope="row">{{$sub_category->title}}</th>
                                            <th scope="row">{{$sub_category->category?->title}}</th>
                                            {{--                                                <td><img src="{{asset('storage/'.$sub_category->image)}}" style="width: 100px; height: 50px" alt=""></td>--}}
                                            <td>
                                                <a href="{{route('sub_categories.edit',$sub_category->id)}}" class="btn btn-primary"
                                                   style="margin-right: 15px">Edit</a>
                                                <form action="{{route('sub_categories.destroy', $sub_category->id)}}" method="post" style="display: inline-block">
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
                                {{ $sub_categories->links('admin.vendor.pagination.bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@include('admin.includes.footer')
