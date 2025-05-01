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
                            <h4 class="card-title">Role editlə</h4>

                            <form action="{{route('roles.update',$role->id)}}" method="post">
                                @csrf
                                {{ method_field('PUT') }}
                                <div class="mb-3">
                                    <label for="example-email-input" class="col-form-label">Name</label>
                                    <input class="form-control" value="{{$role->name}}" type="text" name="name" id="example-email-input">
                                    @if($errors->first('name')) <small class="form-text text-danger">{{$errors->first('name')}}</small> @endif
                                </div>
                                <div class="mb-3">
                                    <h4>Permissions</h4>

                                    @foreach($permissions as $groupName => $groupPermissions)
                                        <br>
                                        <input id="{{ $groupName }}" class="group-checkbox" data-group="{{ $groupName }}" type="checkbox">
                                        <label style="font-weight: 600" for="{{ $groupName }}">{{ $groupName }}</label> <br><br>

                                        @foreach($groupPermissions as $permission)
                                            <input id="{{ $permission->id }}" type="checkbox" data-group="{{ $groupName }}" name="permission[]"
                                                   @foreach($role->permissions as $p)
                                                       {{ $p->name == $permission->name ? 'checked' : '' }}
                                                   @endforeach
                                                   value="{{ $permission->name }}">
                                            <label for="{{ $permission->id }}">{{ $permission->name }}</label><br>
                                        @endforeach
                                    @endforeach

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
