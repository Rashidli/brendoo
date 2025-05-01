@include('admin.includes.header')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <form action="{{ route('blogs.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Əlavə et</h4>
                    </div>
                    <div class="card-body">
                        <!-- Language Tabs -->
                        <ul class="nav nav-tabs" id="languageTab" role="tablist">
                            @foreach(['en', 'ru'] as $lang)
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link @if($loop->first) active @endif" id="{{ $lang }}-tab" data-bs-toggle="tab" href="#{{ $lang }}" role="tab" aria-controls="{{ $lang }}" aria-selected="true">
                                        {{ strtoupper($lang) }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        <div class="tab-content" id="languageTabContent">
                            @foreach(['en', 'ru'] as $lang)
                                <div class="tab-pane fade @if($loop->first) show active @endif" id="{{ $lang }}" role="tabpanel" aria-labelledby="{{ $lang }}-tab">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h5 class="mb-3">Başlıq və Mətn</h5>
                                            <div class="mb-3">
                                                <label class="col-form-label">Başlıq* {{ $lang }}</label>
                                                <input class="form-control" type="text" value="{{old($lang . '_title')}}" name="{{ $lang }}_title">
                                                @if($errors->first("{$lang}_title"))
                                                    <small class="form-text text-danger">{{ $errors->first("{$lang}_title") }}</small>
                                                @endif
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label">Text* {{ $lang }}</label>
                                                <textarea id="editor_{{ $lang }}" class="form-control" name="{{ $lang }}_description">{{old($lang . '_description')}}</textarea>
                                                @if($errors->first("{$lang}_description"))
                                                    <small class="form-text text-danger">{{ $errors->first("{$lang}_description") }}</small>
                                                @endif
                                            </div>

                                            <h5 class="mb-3">Şəkil Etiketləri</h5>
                                            <div class="mb-3">
                                                <label class="col-form-label">Title tag {{ $lang }}</label>
                                                <input class="form-control" type="text" name="{{ $lang }}_img_title" value="{{old($lang . '_img_title')}}">
                                                @if($errors->first("{$lang}_img_title"))
                                                    <small class="form-text text-danger">{{ $errors->first("{$lang}_img_title") }}</small>
                                                @endif
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label">Alt tag {{ $lang }}</label>
                                                <input class="form-control" type="text" name="{{ $lang }}_img_alt" value="{{old($lang . '_img_alt')}}">
                                                @if($errors->first("{$lang}_img_alt"))
                                                    <small class="form-text text-danger">{{ $errors->first("{$lang}_img_alt") }}</small>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <h5 class="mb-3">Meta Tags</h5>
                                            <div class="mb-3">
                                                <label class="col-form-label">Meta title {{ $lang }}</label>
                                                <input class="form-control" type="text" name="{{ $lang }}_meta_title" value="{{ old("{$lang}_meta_title") }}">
                                                @if($errors->first("{$lang}_meta_title"))
                                                    <small class="form-text text-danger">{{ $errors->first("{$lang}_meta_title") }}</small>
                                                @endif
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label">Meta description {{ $lang }}</label>
                                                <textarea class="form-control" name="{{ $lang }}_meta_description">{{ old("{$lang}_meta_description") }}</textarea>
                                                @if($errors->first("{$lang}_meta_description"))
                                                    <small class="form-text text-danger">{{ $errors->first("{$lang}_meta_description") }}</small>
                                                @endif
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label">Meta keywords {{ $lang }}</label>
                                                <textarea class="form-control" name="{{ $lang }}_meta_keywords">{{ old("{$lang}_meta_keywords") }}</textarea>
                                                @if($errors->first("{$lang}_meta_keywords"))
                                                    <small class="form-text text-danger">{{ $errors->first("{$lang}_meta_keywords") }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="col-form-label">Şəkil*(780-480)</label>
                                    <input class="form-control" type="file" name="image">
                                    @if($errors->first('image'))
                                        <small class="form-text text-danger">{{ $errors->first('image') }}</small>
                                    @endif
                                </div>
                                <div class="mb-3 text-end">
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
