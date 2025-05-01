@include('admin.includes.header')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <form action="{{route('holiday_banners.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">əlavə et</h4>
                            <div class="row">
                                <div class="col-6">

                                    <div class="mb-3">
                                        <label class="col-form-label">Başlıq en</label>
                                        <input class="form-control" type="text" name="en_title">
                                        @if($errors->first('en_title')) <small class="form-text text-danger">{{$errors->first('en_title')}}</small> @endif
                                    </div>

                                    <div class="mb-3">
                                        <label class="col-form-label">Başlıq ru</label>
                                        <input class="form-control" type="text" name="ru_title">
                                        @if($errors->first('ru_title')) <small class="form-text text-danger">{{$errors->first('ru_title')}}</small> @endif
                                    </div>

                                    <div class="mb-3">
                                        <label class="col-form-label">İkinci söz en</label>
                                        <input class="form-control" type="text" name="en_value">
                                        @if($errors->first('en_value')) <small class="form-text text-danger">{{$errors->first('en_value')}}</small> @endif
                                    </div>

                                    <div class="mb-3">
                                        <label class="col-form-label">İkinci söz ru</label>
                                        <input class="form-control" type="text" name="ru_value">
                                        @if($errors->first('ru_value')) <small class="form-text text-danger">{{$errors->first('ru_value')}}</small> @endif
                                    </div>

                                    <div class="mb-3">
                                        <label class="col-form-label">Text en</label>
                                        <textarea  class="form-control" type="text" name="en_description"></textarea>
                                        @if($errors->first('en_description')) <small class="form-text text-danger">{{$errors->first('en_description')}}</small> @endif
                                    </div>

                                    <div class="mb-3">
                                        <label class="col-form-label">Text ru</label>
                                        <textarea  class="form-control" type="text" name="ru_description"></textarea>
                                        @if($errors->first('ru_description')) <small class="form-text text-danger">{{$errors->first('ru_description')}}</small> @endif
                                    </div>

                                    <div class="mb-3">
                                        <label class="col-form-label">Şəkli</label>
                                        <input class="form-control" type="file" name="image">
                                        @if($errors->first('image')) <small class="form-text text-danger">{{$errors->first('image')}}</small> @endif
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

