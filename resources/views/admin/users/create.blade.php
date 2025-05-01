@include('admin.includes.header')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-4">
                        <div class="card">
                            <div class="card-body">

                                <h4 class="card-title">İstifadəçi əlavə et</h4>
                                <form action="{{route('users.store')}}" method="post">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="example-email-input" class="col-form-label">Email</label>
                                        <input class="form-control" type="email" name="email" id="example-email-input">
                                        @if($errors->first('email')) <small class="form-text text-danger">{{$errors->first('email')}}</small> @endif
                                    </div>
                                    <div class="mb-3">
                                        <label for="example-text-input" class=" col-form-label">Username</label>
                                        <input class="form-control" type="text" name="name"  id="example-text-input">
                                        @if($errors->first('name')) <small class="form-text text-danger">{{$errors->first('name')}}</small> @endif
                                    </div>


                                    <!-- end row -->
                                    <div class="mb-3">
                                        <label for="example-search-input" class="col-form-label">Password</label>
                                        <div class="input-group">
                                            <input class="form-control" type="password" name="password" id="password-input">
                                            <button type="button" class="btn btn-outline-secondary" id="toggle-password">
                                                👁️
                                            </button>
                                        </div>
                                        @if($errors->first('password'))
                                            <small class="form-text text-danger">{{$errors->first('password')}}</small>
                                        @endif
                                    </div>


                                @foreach($roles as $role)

                                        <input id="{{$role->id}}" type="radio" name="role" value="{{$role->name}}">
                                        <label for="{{$role->id}}">{{$role->name}}</label><br>

                                    @endforeach

                                    <div class="mb-3">
                                        <button class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div> <!-- end col -->
                </div>
            </div>
        </div>
    </div>
@include('admin.includes.footer')
<script>
    document.getElementById('toggle-password').addEventListener('click', function () {
        const passwordInput = document.getElementById('password-input');
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.textContent = type === 'password' ? '👁️' : '🙈';
    });
</script>
