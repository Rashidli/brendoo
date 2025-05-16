@include('admin.includes.header')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            @if(session('message'))
                <div class="alert alert-success">{{session('message')}}</div>
            @endif
            <form action="{{route('regions.update', $region->id)}}" method="post" enctype="multipart/form-data">
                {{ method_field('PUT') }}
                @csrf
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{$region->name}}</h4>
                        <div class="row">
                            <div class="col-6">

                                <div class="mb-3">
                                    <label class="col-form-label">Region adı</label>
                                    <input class="form-control" type="text" name="regionName" value="{{$region->regionName}}">
                                    @if($errors->first('regionName')) <small class="form-text text-danger">{{$errors->first('regionName')}}</small> @endif
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Region Id</label>
                                    <input class="form-control" type="number" name="regionId" value="{{$region->regionId}}">
                                    @if($errors->first('regionId')) <small class="form-text text-danger">{{$errors->first('regionId')}}</small> @endif
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

