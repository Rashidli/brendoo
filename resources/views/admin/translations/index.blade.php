@include('admin.includes.header')

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                @if(session('message'))
                                    <div class="alert alert-success">{{session('message')}}</div>
                                @endif
                                <h4 class="card-title">Sözlər</h4>
                                        <a href="{{route('translations.create')}}" class="btn btn-primary">+</a>
                                <br>
                                    <form action="{{route('translations.index')}}" method="get">
                                        <div class="row">

                                            <div class="col-md-2">
                                                <div class="mb-3">
                                                    <label class="col-form-label"> Söz </label>
                                                    <input type="text" name="name" value="{{request()->name}}"  class="form-control">
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="mb-3">
                                                    <label class="col-form-label"> Axtar </label>
                                                    <input type="submit"  class="form-control btn btn-primary">
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="mb-3">
                                                    <label class="col-form-label"> Sıfırla </label><br>
                                                    <a href="{{route('translations.index')}}" class="btn btn-primary">Sıfırla</a>
                                                </div>
                                            </div>

                                        </div>
                                    </form>
                                <br>

                                <div class="table-responsive">
                                    <table class="table table-centered mb-0 align-middle table-hover table-nowrap">

                                        <thead>
                                        <tr>
                                            <th>№</th>
                                            <th>Başlıq</th>
                                            <th>Əməliyyat</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($translations as $key => $translation)

                                            <tr>
                                                <th scope="row">{{$key}}</th>
                                                <td title="{{$translation->key}}">{{$translation->title}}</td>
                                                <td>
                                                    <a href="{{route('translations.edit',$translation->id)}}" class="btn btn-primary" style="margin-right: 15px" >Edit</a>
{{--                                                    <form action="{{route('translations.destroy', $translation->id)}}" method="post" style="display: inline-block">--}}
{{--                                                        {{ method_field('DELETE') }}--}}
{{--                                                        @csrf--}}
{{--                                                        <button onclick="return confirm('Məlumatın silinməyin təsdiqləyin')" type="submit" class="btn btn-danger">Delete</button>--}}
{{--                                                    </form>--}}
                                                </td>
                                            </tr>

                                        @endforeach

                                        </tbody>
                                    </table>
                                    <br>
{{--                                    {{ $translations->links('vendor.pagination.bootstrap-5') }}--}}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>



@include('admin.includes.footer')
