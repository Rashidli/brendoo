@include('admin.includes.header')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <form action="{{route('shops.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">əlavə et</h4>
                            <div class="row">
                                <div class="col-6">

                                    <div class="mb-3">
                                        <label class="col-form-label">Adı en</label>
                                        <input class="form-control" type="text" name="en_title">
                                        @if($errors->first('en_title')) <small class="form-text text-danger">{{$errors->first('en_title')}}</small> @endif
                                    </div>

                                    <div class="mb-3">
                                        <label class="col-form-label">Adı ru</label>
                                        <input class="form-control" type="text" name="ru_title">
                                        @if($errors->first('ru_title')) <small class="form-text text-danger">{{$errors->first('ru_title')}}</small> @endif
                                    </div>

                                    <div class="mb-3">
                                        <label class="col-form-label">Ünvan en</label>
                                        <textarea class="form-control" type="text" name="en_address"></textarea>
                                        @if($errors->first('en_address')) <small class="form-text text-danger">{{$errors->first('en_address')}}</small> @endif
                                    </div>

                                    <div class="mb-3">
                                        <label class="col-form-label">Ünvan ru</label>
                                        <textarea class="form-control" type="text" name="ru_address"></textarea>
                                        @if($errors->first('ru_address')) <small class="form-text text-danger">{{$errors->first('ru_address')}}</small> @endif
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
