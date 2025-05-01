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
                                <h4 class="card-title">Roles</h4>
                                <a href="{{route('roles.create')}}" class="btn btn-primary">+</a>
                                <br>
                                <br>
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0">

                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Ad</th>
                                                <th>Əməliyyat</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($roles as $key => $role)
                                            <tr>
                                                <td scope="row">{{$key+1}}</td>
                                                <td>{{$role->name}}</td>
                                                <td>
                                                    @if($role->id !== 2)
                                                    <a href="{{route('roles.edit',$role->id)}}" class="btn btn-primary" style="margin-right: 15px" >Edit</a>
                                                        <form action="{{route('roles.destroy', $role->id)}}" method="post" style="display: inline-block">
                                                            {{ method_field('DELETE') }}
                                                            @csrf
                                                            <button  type="submit" class="btn btn-danger">Delete</button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>



@include('admin.includes.footer')

<script>

</script>
