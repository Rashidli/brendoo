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
                                <h4 class="card-title">Əlaqələr</h4>
{{--                                    <a href="{{route('contacts.create')}}" class="btn btn-primary">+</a>--}}
                                <br>
                                <br>

                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0">

                                        <thead>
                                            <tr>
                                                <th>№</th>
                                                <th>Müştəri ID</th>
                                                <th>Ad Soyad</th>
                                                <th>Telefon</th>
                                                <th>Email</th>
                                                <th>Kateqoriya</th>
                                                <th>Mesaj</th>
                                                <th>Əməliyyat</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                        @foreach($contacts as $contact)

                                            <tr>
                                                <th scope="row">{{$contact->id}}</th>
                                                <th scope="row">{{$contact->customer?->id}}</th>
                                                <th scope="row">{{$contact->name}} {{$contact->surname}}</th>
                                                <th scope="row">{{$contact->phone}}</th>
                                                <th scope="row">{{$contact->email}}</th>
                                                <th scope="row">{{$contact->category}}</th>
                                                <th scope="row" style="max-width: 150px">{{$contact->message}}</th>
                                                <td>
{{--                                                    <a href="{{route('contacts.edit',$contact->id)}}" class="btn btn-primary" style="margin-right: 15px" >Edit</a>--}}
                                                    <form action="{{route('contacts.destroy', $contact->id)}}" method="post" style="display: inline-block">
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
                                    {{ $contacts->links('admin.vendor.pagination.bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>



@include('admin.includes.footer')
