@include('admin.includes.header')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <form action="{{route('settlements.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">əlavə et</h4>
                            <div class="row">
                                <div class="col-6">

                                    <div class="mb-3">
                                        <label class="col-form-label">Bölgə</label>
                                        <select name="district_id" id="" class="form-control">
                                            @foreach($districts as $district )
                                                <option value="{{$district->id}}" >{{$district->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="col-form-label">Qəsəbə</label>
                                        <input class="form-control" type="text" name="name">
                                        @if($errors->first('name')) <small class="form-text text-danger">{{$errors->first('name')}}</small> @endif
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

