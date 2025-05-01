@include('admin.includes.header')

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <form action="{{ route('singles.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">əlavə et</h4>

                        <!-- Tabs Navigation -->
                        <ul class="nav nav-tabs" id="langTabs" role="tablist">
                            @foreach([ 'en', 'ru'] as $lang)
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link {{ $loop->first ? 'active' : '' }}" id="{{ $lang }}-tab" data-bs-toggle="tab" href="#{{ $lang }}" role="tab" aria-controls="{{ $lang }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}">{{ strtoupper($lang) }}</a>
                                </li>
                            @endforeach
                        </ul>

                        <div class="tab-content mt-3" id="langTabsContent">
                            @foreach(['en', 'ru'] as $lang)
                                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ $lang }}" role="tabpanel" aria-labelledby="{{ $lang }}-tab">

                                    <div class="mb-3">
                                        <label class="col-form-label">Başlıq {{ strtoupper($lang) }}</label>
                                        <input class="form-control" type="text" name="{{ $lang }}_title" value="{{ old("{$lang}_title") }}">
                                        @if($errors->first("{$lang}_title")) <small class="form-text text-danger">{{ $errors->first("{$lang}_title") }}</small> @endif
                                    </div>

                                    <div class="mb-3">
                                        <label class="col-form-label">Meta title {{ strtoupper($lang) }}</label>
                                        <input class="form-control" type="text" name="{{ $lang }}_seo_title" value="{{ old("{$lang}_seo_title") }}">
                                        @if($errors->first("{$lang}_seo_title")) <small class="form-text text-danger">{{ $errors->first("{$lang}_seo_title") }}</small> @endif
                                    </div>

                                    <div class="mb-3">
                                        <label class="col-form-label">Meta description {{ strtoupper($lang) }}</label>
                                        <textarea class="form-control" name="{{ $lang }}_seo_description">{{ old("{$lang}_seo_description") }}</textarea>
                                        @if($errors->first("{$lang}_seo_description")) <small class="form-text text-danger">{{ $errors->first("{$lang}_seo_description") }}</small> @endif
                                    </div>

                                    <div class="mb-3">
                                        <label class="col-form-label">Meta keywords {{ strtoupper($lang) }}</label>
                                        <textarea class="form-control" name="{{ $lang }}_seo_keywords">{{ old("{$lang}_seo_keywords") }}</textarea>
                                        @if($errors->first("{$lang}_seo_keywords")) <small class="form-text text-danger">{{ $errors->first("{$lang}_seo_keywords") }}</small> @endif
                                    </div>

                                </div>
                            @endforeach

                            <!-- Non-language specific fields -->
                            <div class="mb-3">
                                <label class="col-form-label">Type</label>
                                <input class="form-control" type="text" name="type" value="{{ old('type') }}">
                                @if($errors->first('type')) <small class="form-text text-danger">{{ $errors->first('type') }}</small> @endif
                            </div>

                            <div class="mb-3">
                                <button class="btn btn-primary">Yadda saxla</button>
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
