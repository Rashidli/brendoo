@include('admin.includes.header')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            @if(session('message'))
                <div class="alert alert-success">{{session('message')}}</div>
            @endif
            <form action="{{route('login_banners.update', $login_banner->id)}}" method="post" enctype="multipart/form-data">
                {{ method_field('PUT') }}
                @csrf
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{$login_banner->translate('en')->title}}</h4>
                        <div class="row">
                            <div class="col-6">

                                <div class="mb-3">
                                    <label class="col-form-label">Başlıq en</label>
                                    <input class="form-control" type="text" name="en_title" value="{{$login_banner->translate('en')->title}}">
                                    @if($errors->first('en_title')) <small class="form-text text-danger">{{$errors->first('en_title')}}</small> @endif
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Başlıq ru</label>
                                    <input class="form-control" type="text" name="ru_title" value="{{$login_banner->translate('ru')->title}}">

                                    @if($errors->first('ru_title')) <small class="form-text text-danger">{{$errors->first('ru_title')}}</small> @endif
                                </div>

                                <div class="mb-3">
                                    <img style="width: 100px; height: 100px;" src="{{asset('storage/' . $login_banner->image)}}" class="uploaded_image" alt="{{$login_banner->image}}">
                                    <div class="form-group">
                                        <label >Image (580x260)</label>
                                        <input type="file" name="image" class="form-control">
                                    </div>
                                    @if($errors->first('image')) <small class="form-text text-danger">{{$errors->first('image')}}</small> @endif
                                </div>

                                <div class="mb-3">
                                    <img style="width: 100px; height: 100px;" src="{{asset('storage/' . $login_banner->second_image)}}" class="uploaded_image" alt="{{$login_banner->second_image}}">
                                    <div class="form-group">
                                        <label >Image (580x340)</label>
                                        <input type="file" name="second_image" class="form-control">
                                    </div>
                                    @if($errors->first('second_image')) <small class="form-text text-danger">{{$errors->first('second_image')}}</small> @endif
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Active</label>
                                    <select name="is_active" id="" class="form-control">
                                        <option value="1" {{$login_banner->is_active ? 'selected' : ''}}>Active</option>
                                        <option value="0" {{!$login_banner->is_active ? 'selected' : ''}}>Deactive</option>
                                    </select>
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

