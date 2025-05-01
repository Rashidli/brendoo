@include('admin.includes.header')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            @if(session('message'))
                <div class="alert alert-success">{{session('message')}}</div>
            @endif
            <form action="{{route('shops.update', $shop->id)}}" method="post" enctype="multipart/form-data">
                {{ method_field('PUT') }}
                @csrf
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{$shop->translate('en')->title}}</h4>
                        <div class="row">
                            <div class="col-6">

                                <div class="mb-3">
                                    <label class="col-form-label">Adı en</label>
                                    <input class="form-control" type="text" name="en_title" value="{{$shop->translate('en')->title}}">
                                    @if($errors->first('en_title')) <small class="form-text text-danger">{{$errors->first('en_title')}}</small> @endif
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Adı ru</label>
                                    <input class="form-control" type="text" name="ru_title" value="{{$shop->translate('ru')->title}}">

                                    @if($errors->first('ru_title')) <small class="form-text text-danger">{{$errors->first('ru_title')}}</small> @endif
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Address en</label>
                                    <textarea class="form-control" type="text" name="en_address">{{$shop->translate('en')->address}}</textarea>
                                    @if($errors->first('en_address')) <small class="form-text text-danger">{{$errors->first('en_address')}}</small> @endif
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Address ru</label>
                                    <textarea class="form-control" type="text" name="ru_address">{{$shop->translate('ru')->address}}</textarea>
                                    @if($errors->first('ru_address')) <small class="form-text text-danger">{{$errors->first('ru_address')}}</small> @endif
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Active</label>
                                    <select name="is_active" id="" class="form-control">
                                        <option value="1" {{$shop->is_active ? 'selected' : ''}}>Active</option>
                                        <option value="0" {{!$shop->is_active ? 'selected' : ''}}>Deactive</option>
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
