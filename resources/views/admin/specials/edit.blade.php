@include('admin.includes.header')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            @if(session('message'))
                <div class="alert alert-success">{{session('message')}}</div>
            @endif
            <form action="{{route('specials.update', $special->id)}}" method="post" enctype="multipart/form-data">
                {{ method_field('PUT') }}
                @csrf
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{$special->translate('en')->title}}</h4>
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="col-form-label">Neçə dəqiqədən bir görsənsin?</label>
                                    <input class="form-control" type="text" name="minute" value="{{$special->minute}}">
                                    @if($errors->first('minute')) <small class="form-text text-danger">{{$errors->first('minute')}}</small> @endif
                                </div>
                                <div class="mb-3">
                                    <label class="col-form-label">Endirim en</label>
                                    <input class="form-control" type="text" name="en_discount" value="{{$special->translate('en')->discount}}">
                                    @if($errors->first('en_discount')) <small class="form-text text-danger">{{$errors->first('en_discount')}}</small> @endif
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Endirim ru</label>
                                    <input class="form-control" type="text" name="ru_discount" value="{{$special->translate('ru')->discount}}">
                                    @if($errors->first('ru_discount')) <small class="form-text text-danger">{{$errors->first('ru_discount')}}</small> @endif
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Text en</label>
                                    <textarea  class="form-control" type="text" name="en_description">{{$special->translate('en')->description}}</textarea>
                                    @if($errors->first('en_description')) <small class="form-text text-danger">{{$errors->first('en_description')}}</small> @endif
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Text ru</label>
                                    <textarea  class="form-control" type="text" name="ru_description">{{$special->translate('ru')->description}}</textarea>
                                    @if($errors->first('ru_description')) <small class="form-text text-danger">{{$errors->first('ru_description')}}</small> @endif
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Şəkil* (520x300)</label>
                                    <input class="form-control" type="file" name="image">
                                    <img src="{{ asset('storage/' . $special->image) }}" alt="sdcvas" class="img-thumbnail mt-2" width="150">
                                    @if($errors->first('image'))
                                        <small class="form-text text-danger">{{ $errors->first('image') }}</small>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Active</label>
                                    <select name="is_active" id="" class="form-control">
                                        <option value="1" {{$special->is_active ? 'selected' : ''}}>Active</option>
                                        <option value="0" {{!$special->is_active ? 'selected' : ''}}>Deactive</option>
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

