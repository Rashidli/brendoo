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
                            <h4 class="card-title">İstifadəçilər</h4>
                            <a href="{{route('users.create')}}" class="btn btn-primary">+</a>
                            <br>
                            <br>
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Ad</th>
                                        <th>Rol</th>
                                        <th>Email</th>
                                        <th>Əməliyyat</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($users as $key => $user)
                                        <tr>
                                            <th scope="row">{{ $user->id }}</th>
                                            <td>{{ $user->name }}</td>
                                            <td>
                                                {{ $user->roles->first()->name }}
                                            </td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                @if($user->id !== 1)
                                                    <a href="{{ route('users.edit', $user->id) }}"
                                                       class="btn btn-sm btn-primary"
                                                       style="margin-right: 10px;">
                                                        <i class="fas fa-edit"></i> Redaktə
                                                    </a>
                                                    <form action="{{ route('users.destroy', $user->id) }}"
                                                          method="POST"
                                                          style="display: inline-block;"
                                                          onsubmit="return confirm('Bu istifadəçini silmək istədiyinizə əminsiniz?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            <i class="fas fa-trash-alt"></i> Sil
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
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
