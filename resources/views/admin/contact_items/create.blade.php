@include('admin.includes.header')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <form action="{{ route('contact_items.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Əlavə et</h4>

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
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label class="col-form-label">Başlıq {{ strtoupper($lang) }}</label>
                                                <input class="form-control" type="text" name="{{ $lang }}_title" value="{{ old("{$lang}_title") }}">
                                                @if($errors->first("{$lang}_title")) <small class="form-text text-danger">{{ $errors->first("{$lang}_title") }}</small> @endif
                                            </div>


                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label class="col-form-label">Value {{ strtoupper($lang) }}</label>
                                                <input class="form-control" type="text" name="{{ $lang }}_value" value="{{ old("{$lang}_value") }}">
                                                @if($errors->first("{$lang}_value")) <small class="form-text text-danger">{{ $errors->first("{$lang}_value") }}</small> @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                                <div class="mb-3">
                                    <label class="col-form-label">Icon(24x24)</label>
                                    <input class="form-control" type="file" name="image">
                                    @if($errors->first('image')) <small class="form-text text-danger">{{ $errors->first('image') }}</small> @endif
                                </div>

                                <div class="mb-3">
                                    <label class="col-form-label">Footer icon(20x20)</label>
                                    <input class="form-control" type="file" name="footer_icon">
                                    @if($errors->first('footer_icon')) <small class="form-text text-danger">{{ $errors->first('footer_icon') }}</small> @endif
                                </div>
                        </div>

                        <div class="mb-3">
                            <button class="btn btn-primary">Yadda saxla</button>
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
