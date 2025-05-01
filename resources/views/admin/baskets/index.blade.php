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
                            <h4 class="card-title">Məhsullar</h4>
                            <div class="table-responsive">
                                <table class="table table-centered mb-0 align-middle table-hover table-nowrap">

                                    <thead>
                                    <tr>
                                        <th>Kod</th>
                                        <th>Şəkil</th>
                                        <th>Məhsul</th>
                                        <th>Miqdar</th>
                                        <th>Məhsulun filteri</th>
                                        <th>Sifariş qiyməti</th>
                                    </tr>
                                    </thead>

                                    <tbody>

                                    @foreach($basketItems as $key => $product)

                                        <tr>

                                            <td>{{$product->product?->code}}</td>
                                            <td><img src="{{$product->product?->image}}"
                                                     style="width: 70px; height: 90px" alt=""></td>
                                            <td>
                                                <a href="{{route('products.edit', $product->product_id)}}">{{$product->product?->title}}</a>
                                            </td>
                                            <td>{{$product->quantity}}</td>
                                            <td>

                                                @foreach($product->options as $option)
                                                    {{$option->filter->title}} : {{$option->option->title}}
                                                @endforeach
                                                {{--                                                {{$product->product?->price}}--}}
                                            </td>
                                            <td>{{$product->price}}</td>

                                        </tr>

                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.includes.footer')
