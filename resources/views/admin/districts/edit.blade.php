@include('admin.includes.header')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            @if(session('message'))
                <div class="alert alert-success">{{session('message')}}</div>
            @endif
            <form action="{{route('districts.update', $district->id)}}" method="post" enctype="multipart/form-data">
                {{ method_field('PUT') }}
                @csrf
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{$district->name}}</h4>
                        <div class="row">
                            <div class="col-6">

                                <div class="mb-3">
                                    <label class="col-form-label">Şəhər</label>
                                    <select name="city_id" id="" class="form-control">
                                        @foreach($cities as $city )
                                            <option value="{{$city->id}}" {{$city->id == $district->city_id ? 'selected' : ''}}>{{$city->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Bölgə</label>
                                    <input class="form-control" type="text" name="name" value="{{$district->name}}">
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

