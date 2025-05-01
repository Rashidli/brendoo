@include('admin.includes.header')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-4">
                    <div class="card">
                        <div class="card-body">
                            @if(session('message'))
                                <div class="alert alert-success">{{session('message')}}</div>
                            @endif
                            <h4 class="card-title">İstifadəçi editlə</h4>
                            <form action="{{route('users.update',$user->id)}}" method="post">
                                @csrf
                                {{ method_field('PUT') }}
                                <div class="mb-3">
                                    <label for="example-email-input" class="col-form-label">Email</label>
                                    <input class="form-control" value="{{$user->email}}" type="email" name="email" id="example-email-input">
                                    @if($errors->first('email')) <small class="form-text text-danger">{{$errors->first('email')}}</small> @endif
                                </div>
                                <div class="mb-3">
                                    <label for="example-text-input" class=" col-form-label">Username</label>
                                    <input class="form-control" value="{{$user->name}}" type="text" name="name"  id="example-text-input">
                                    @if($errors->first('name')) <small class="form-text text-danger">{{$errors->first('name')}}</small> @endif
                                </div>
                                <div class="mb-3">
                                    <label for="example-search-input" class="col-form-label">Password</label>
                                    <input class="form-control" type="password" name="password" id="example-search-input">
                                    @if($errors->first('password')) <small class="form-text text-danger">{{$errors->first('password')}}</small> @endif
                                </div>
                                <div class="mb-3">
                                    <h4>Roles</h4>
                                    @if($user->roles)
                                        @foreach($roles as $role)

                                            <input id="{{$role->id}}" type="radio" name="role" @foreach($user->roles as $p){{$p->name == $role->name ? 'checked' : ''}}@endforeach value="{{$role->name}}">
                                            <label for="{{$role->id}}">{{$role->name}}</label><br>

                                        @endforeach
                                    @endif

                                </div>
                                <div class="mb-3">
                                    <button class="btn btn-primary">Submit</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div>
        </div>
    </div>
</div>
@include('admin.includes.footer')
