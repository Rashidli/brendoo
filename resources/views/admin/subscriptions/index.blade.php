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
                                <h4 class="card-title">Abunələr</h4>
{{--                                    <a href="{{route('subscriptions.create')}}" class="btn btn-primary">+</a>--}}
                                <br>
                                <br>

                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0">

                                        <thead>
                                            <tr>
                                                <th>№</th>
                                                <th>Email</th>
                                                <th>Əməliyyat</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                        @foreach($subscriptions as $key => $subscription)

                                            <tr>
                                                <th scope="row">{{$key+1}}</th>
                                                <th scope="row">{{$subscription->email}}</th>
                                                <td>
{{--                                                    <a href="{{route('subscriptions.edit',$subscription->id)}}" class="btn btn-primary" style="margin-right: 15px" >Edit</a>--}}
                                                    <form action="{{route('subscriptions.destroy', $subscription->id)}}" method="post" style="display: inline-block">
                                                        {{ method_field('DELETE') }}
                                                        @csrf
                                                        <button onclick="return confirm('Məlumatın silinməyin təsdiqləyin')" type="submit" class="btn btn-danger">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>

                                        @endforeach

                                        </tbody>
                                    </table>
                                    <br>
                                    {{ $subscriptions->links('admin.vendor.pagination.bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>



@include('admin.includes.footer')
