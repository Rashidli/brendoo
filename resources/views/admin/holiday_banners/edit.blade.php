@include('admin.includes.header')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            @if(session('message'))
                <div class="alert alert-success">{{session('message')}}</div>
            @endif
            <form action="{{route('holiday_banners.update', $holiday_banner->id)}}" method="post" enctype="multipart/form-data">
                {{ method_field('PUT') }}
                @csrf
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{$holiday_banner->translate('en')->title}}</h4>
                        <div class="row">
                            <div class="col-6">

                                <div class="mb-3">
                                    <label class="col-form-label">Başlıq en</label>
                                    <input class="form-control" type="text" name="en_title" value="{{$holiday_banner->translate('en')->title}}">
                                    @if($errors->first('en_title')) <small class="form-text text-danger">{{$errors->first('en_title')}}</small> @endif
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Başlıq ru</label>
                                    <input class="form-control" type="text" name="ru_title" value="{{$holiday_banner->translate('ru')->title}}">

                                    @if($errors->first('ru_title')) <small class="form-text text-danger">{{$errors->first('ru_title')}}</small> @endif
                                </div>
                                <div class="mb-3">
                                    <label class="col-form-label">İkinci söz en</label>
                                    <input class="form-control" type="text" name="en_value" value="{{$holiday_banner->translate('en')->value}}">
                                    @if($errors->first('en_value')) <small class="form-text text-danger">{{$errors->first('en_value')}}</small> @endif
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">İkinci söz ru</label>
                                    <input class="form-control" type="text" name="ru_value" value="{{$holiday_banner->translate('ru')->value}}">

                                    @if($errors->first('ru_value')) <small class="form-text text-danger">{{$errors->first('ru_value')}}</small> @endif
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Text en</label>
                                    <textarea  class="form-control" type="text" name="en_description">{{$holiday_banner->translate('en')->description}}</textarea>
                                    @if($errors->first('en_description')) <small class="form-text text-danger">{{$errors->first('en_description')}}</small> @endif
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Text ru</label>
                                    <textarea  class="form-control" type="text" name="ru_description">{{$holiday_banner->translate('ru')->description}}</textarea>
                                    @if($errors->first('ru_description')) <small class="form-text text-danger">{{$errors->first('ru_description')}}</small> @endif
                                </div>

                                <div class="mb-3">
                                    <img style="width: 100px; height: 100px;" src="{{asset('storage/' . $holiday_banner->image)}}" class="uploaded_image" alt="{{$holiday_banner->image}}">
                                    <div class="form-group">
                                        <label >Image (1360x500)</label>
                                        <input type="file" name="image" class="form-control">
                                    </div>
                                    @if($errors->first('image')) <small class="form-text text-danger">{{$errors->first('image')}}</small> @endif
                                </div>
                                <div class="mb-3">
                                    <label class="col-form-label">Active</label>
                                    <select name="is_active" id="" class="form-control">
                                        <option value="1" {{$holiday_banner->is_active ? 'selected' : ''}}>Active</option>
                                        <option value="0" {{!$holiday_banner->is_active ? 'selected' : ''}}>Deactive</option>
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

