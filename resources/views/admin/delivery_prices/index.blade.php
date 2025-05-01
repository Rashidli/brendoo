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
                                <h4 class="card-title">Çatdırılma qiyməti</h4>
{{--                                    <a href="{{route('delivery_prices.create')}}" class="btn btn-primary">+</a>--}}
                                <br>
                                <br>
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0">

                                        <thead>
                                            <tr>
                                                <th>№</th>
                                                <th>Qiymət</th>
{{--                                                <th>Status</th>--}}
                                                <th>Əməliyyat</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                        @foreach($delivery_prices as $delivery_price)

                                            <tr>
                                                <th scope="row">{{$delivery_price->id}}</th>
                                                <th scope="row">{{$delivery_price->title}}</th>
{{--                                                <td><img src="{{asset('storage/'.$delivery_price->image)}}" style="width: 100px; height: 50px" alt=""></td>--}}
{{--                                                <td>{{$delivery_price->is_active ? 'Active' : 'Deactive'}}</td>--}}
                                                <td>
                                                    <a href="{{route('delivery_prices.edit',$delivery_price->id)}}" class="btn btn-primary" style="margin-right: 15px" >Edit</a>
{{--                                                    <form action="{{route('delivery_prices.destroy', $delivery_price->id)}}" method="post" style="display: inline-block">--}}
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
                                    {{ $delivery_prices->links('admin.vendor.pagination.bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>



@include('admin.includes.footer')
