@include('admin.includes.header')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            @if(session('message'))
                <div class="alert alert-success">{{session('message')}}</div>
            @endif
            <form action="{{route('on_boardings.update', $on_boarding->id)}}" method="post" enctype="multipart/form-data">
                {{ method_field('PUT') }}
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">

                                <div class="mb-3">
                                    <label class="col-form-label">Başlıq en</label>
                                    <input class="form-control" type="text" name="en_title" value="{{$on_boarding->translate('en')?->title}}">
                                    @if($errors->first('en_title')) <small class="form-text text-danger">{{$errors->first('en_title')}}</small> @endif
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Başlıq ru</label>
                                    <input class="form-control" type="text" name="ru_title" value="{{$on_boarding->translate('ru')?->title}}">

                                    @if($errors->first('ru_title')) <small class="form-text text-danger">{{$errors->first('ru_title')}}</small> @endif
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Alt Başlıq en</label>
                                    <input class="form-control" type="text" name="en_sub_title" value="{{$on_boarding->translate('en')?->sub_title}}">
                                    @if($errors->first('en_sub_title')) <small class="form-text text-danger">{{$errors->first('en_sub_title')}}</small> @endif
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Alt Başlıq ru</label>
                                    <input class="form-control" type="text" name="ru_sub_title" value="{{$on_boarding->translate('ru')?->sub_title}}">

                                    @if($errors->first('ru_sub_title')) <small class="form-text text-danger">{{$errors->first('ru_sub_title')}}</small> @endif
                                </div>

                                <div class="mb-3">
                                    <img src="{{asset('storage/' . $on_boarding->image)}}" width="50px" height="50px" alt="">
                                    <div class="form-group">
                                        <label>Şəkil</label>
                                        <input type="file" name="image" class="form-control">
                                    </div>
                                    @if($errors->first('image'))
                                        <small class="form-text text-danger">{{$errors->first('image')}}</small>
                                    @endif
                                </div>


                                <div class="mb-3">
                                    <label class="col-form-label">Active</label>
                                    <select name="is_active" id="" class="form-control">
                                        <option value="1" {{$on_boarding->is_active  ? 'selected' : ''}}>Active</option>
                                        <option value="0" {{!$on_boarding->is_active  ? 'selected' : ''}}>Deactive</option>
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
