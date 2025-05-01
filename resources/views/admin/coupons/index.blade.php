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
                            <h4 class="card-title">Kuponlar</h4>
                            <a href="{{route('coupons.create')}}" class="btn btn-primary">+</a>
                            <br>
                            <br>
                            <div class="table-responsive">
                                <table class="table table-centered mb-0 align-middle table-hover table-nowrap">
                                    <thead class="table-light">
                                    <tr>
                                        <th>№</th>
                                        <th>Başlıq</th>
                                        <th>Başlama tarixi</th>
                                        <th>Bitmə tarixi</th>
                                        <th>Status</th>
                                        <th>Əməliyyat</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($coupons as $key => $coupon)

                                        <tr >
                                            <th scope="row">{{$key+1}}</th>
                                            <th  scope="row">{{$coupon->code}}</th>
                                            {{--                                                <td><img src="{{asset('storage/'.$coupon->image)}}" style="width: 100px; height: 50px" alt=""></td>--}}
                                            <td>{{$coupon->valid_from}}</td>
                                            <td>{{$coupon->valid_until}}</td>
                                            <td>
                                                @if(now()->between($coupon->valid_from, $coupon->valid_until))
                                                    <i
                                                        class="ri-checkbox-blank-circle-fill font-size-10 text-success align-middle me-2"></i>Active
                                                @else
                                                    Deactive
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{route('coupons.edit',$coupon->id)}}" class="btn btn-primary"
                                                   style="margin-right: 15px">Edit</a>
                                                <form action="{{route('coupons.destroy', $coupon->id)}}" method="post"
                                                      style="display: inline-block">
                                                    {{ method_field('DELETE') }}
                                                    @csrf
                                                    <button onclick="return confirm('Məlumatın silinməyin təsdiqləyin')"
                                                            type="submit" class="btn btn-danger">Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>

                                    @endforeach
                                    </tbody>
                                </table>
                                <br>
                                {{ $coupons->links('admin.vendor.pagination.bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.includes.footer')
