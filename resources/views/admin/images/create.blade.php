@include('admin.includes.header')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <form action="{{route('images.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Add image</h4>
                            <div class="row">
                                <div class="col-6">


                                    <div class="mb-3">
                                        <label class="col-form-label">Logo(148x34)</label>
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
<script src="https://cdn.ckeditor.com/ckeditor5/38.1.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create( document.querySelector( '#editor_az' ) )
        .catch( error => {
            console.error( error );
        } );

</script>
