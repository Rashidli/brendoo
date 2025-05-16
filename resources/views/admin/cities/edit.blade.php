@include('admin.includes.header')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            @if(session('message'))
                <div class="alert alert-success">{{session('message')}}</div>
            @endif
            <form action="{{route('cities.update', $city->id)}}" method="post" enctype="multipart/form-data">
                {{ method_field('PUT') }}
                @csrf
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{$city->name}}</h4>
                        <div class="row">
                            <div class="col-6">

                                <div class="mb-3">
                                    <label class="col-form-label">Region seç</label>
                                    <select name="regionId" id="" class="form-control">
                                        @foreach($regions as $region )
                                            <option value="{{$region->regionId}}" {{$region->regionId == $city->regionId}} >{{$region->regionName}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Şəhər adı</label>
                                    <input class="form-control" type="text" name="cityName" value="{{$city->cityName}}">
                                    @if($errors->first('cityName')) <small class="form-text text-danger">{{$errors->first('cityName')}}</small> @endif
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Şəhər Id</label>
                                    <input class="form-control" type="text" name="cityId" value="{{$city->cityId}}">
                                    @if($errors->first('cityId')) <small class="form-text text-danger">{{$errors->first('cityId')}}</small> @endif
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

