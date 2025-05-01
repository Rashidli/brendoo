@include('admin.includes.header')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Permission əlavə et</h4>
                                <form action="{{route('permissions.store')}}" method="post">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="example-email-input" class="col-form-label">Name</label>
                                        <input class="form-control" type="text" name="name" id="example-email-input">
                                        @if($errors->first('name')) <small class="form-text text-danger">{{$errors->first('name')}}</small> @endif
                                    </div>
                                    <div class="mb-3">
                                        <label for="example-email-input" class="col-form-label">Group name</label>
                                        <input class="form-control" type="text" name="group_name" id="example-email-input">
                                        @if($errors->first('group_name')) <small class="form-text text-danger">{{$errors->first('group_name')}}</small> @endif
                                    </div>
                                    <div class="mb-3">
                                        <button class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@include('admin.includes.footer')
