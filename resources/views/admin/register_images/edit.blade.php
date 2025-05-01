@include('admin.includes.header')

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            @if(session('message'))
                <div class="alert alert-success">{{session('message')}}</div>
            @endif
            <form action="{{route('register_images.update', $register_image->id)}}" method="post" enctype="multipart/form-data">
                {{ method_field('PUT') }}
                @csrf
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{$register_image->title}}</h4>
                        <div class="row">
                            <div class="col-6">

                                <div class="mb-3">
                                    <img style="width: 100px; height: 100px;" src="{{asset('storage/' . $register_image->register_image)}}" class="uploaded_register_image" alt="{{$register_image->register_image}}">
                                    <div class="form-group">
                                        <label>Arxa fon şəkli(1920x880)</label>
                                        <input type="file" name="register_image" class="form-control">
                                    </div>
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
