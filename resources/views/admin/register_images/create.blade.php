@include('admin.includes.header')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <form action="{{route('register_images.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Add İmage</h4>
                            <div class="row">
                                <div class="col-6">


                                    <div class="mb-3">
                                        <label class="col-form-label">Arxa fon şəkli</label>
                                        <input class="form-control" type="file" name="register_image">
                                        @if($errors->first('register_image')) <small class="form-text text-danger">{{$errors->first('register_image')}}</small> @endif
                                    </div>

                                    <div class="mb-3">

                                        <button class="btn btn-primary">Yadda saxla</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@include('admin.includes.footer')
