@include('admin.includes.header')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            @if(session('message'))
                <div class="alert alert-success">{{session('message')}}</div>
            @endif
            <form action="{{route('tags.update', $tag->id)}}" method="post" enctype="multipart/form-data">
                {{ method_field('PUT') }}
                @csrf
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{$tag->title}}</h4>
                        <div class="row">
                            <div class="col-6">

                                <div class="mb-3">
                                    <label class="col-form-label">Başlıq</label>
                                    <input class="form-control" type="text" name="title" value="{{$tag->title}}">
                                    @if($errors->first('title')) <small class="form-text text-danger">{{$errors->first('title')}}</small> @endif
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Text</label>
                                    <textarea  class="form-control" type="text" name="description">{{$tag->description}}</textarea>
                                    @if($errors->first('description')) <small class="form-text text-danger">{{$errors->first('description')}}</small> @endif
                                </div>


                                <div class="mb-3">
                                    <label class="col-form-label">Active</label>
                                    <select name="is_active" id="" class="form-control">
                                        <option value="1" {{$tag->is_active == true ? 'selected' : ''}}>Active</option>
                                        <option value="0" {{$tag->is_active == false ? 'selected' : ''}}>Deactive</option>
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

