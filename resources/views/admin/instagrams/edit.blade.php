@include('admin.includes.header')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            @if(session('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif
            <form action="{{ route('instagrams.update', $instagram->id) }}" method="post" enctype="multipart/form-data">
                {{ method_field('PUT') }}
                @csrf
                <div class="card">
                    <div class="card-body">
                       <div class="row">
                           <div class="col-6">
                               <nav aria-label="breadcrumb" style="margin-bottom: 20px;">
                                   <ol class="breadcrumb bg-light p-3 rounded">
                                       <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                                       <li class="breadcrumb-item"><a href="{{ route('instagrams.index') }}">Siyahı</a></li>
                                       <li class="breadcrumb-item active" aria-current="page">{{ $instagram->translate('en')?->title }}</li>
                                   </ol>
                               </nav>

                               <!-- Language Tabs -->
                               <ul class="nav nav-tabs" id="langTabs" role="tablist">
                                   @foreach([ 'en', 'ru'] as $lang)
                                       <li class="nav-item" role="presentation">
                                           <a class="nav-link {{ $loop->first ? 'active' : '' }}" id="{{ $lang }}-tab" data-bs-toggle="tab" href="#{{ $lang }}" role="tab" aria-controls="{{ $lang }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}">{{ strtoupper($lang) }}</a>
                                       </li>
                                   @endforeach
                               </ul>

                               <div class="tab-content" id="langTabsContent">
                                   @foreach([ 'en', 'ru'] as $lang)
                                       <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ $lang }}" role="tabpanel" aria-labelledby="{{ $lang }}-tab">
                                           <div class="mb-3">
                                               <label class="col-form-label">Başlıq {{ strtoupper($lang) }}</label>
                                               <input class="form-control" type="text" name="{{ $lang }}_title" value="{{ $instagram->translate($lang)?->title }}">
                                               @if($errors->first("{$lang}_title")) <small class="form-text text-danger">{{ $errors->first("{$lang}_title") }}</small> @endif
                                           </div>
                                       </div>
                                   @endforeach
                               </div>
                               <div class="mb-3">
                                   <img style="width: 100px; height: 100px;" src="{{ asset('storage/' . $instagram->image) }}" class="uploaded_image" alt="{{ $instagram->image }}">
                                   <div class="form-group">
                                       <label>Şəkil (480x824)</label>
                                       <input type="file" name="image" class="form-control">
                                   </div>
                                   @if($errors->first('image')) <small class="form-text text-danger">{{ $errors->first('image') }}</small> @endif
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

<!-- Include Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
