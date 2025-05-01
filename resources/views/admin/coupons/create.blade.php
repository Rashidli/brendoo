@include('admin.includes.header')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <form action="{{ route('coupons.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Əlavə et</h4>
                        <div class="row">
                            <div class="col-6">

                                <!-- Coupon Code Input -->
                                <div class="mb-3">
                                    <label class="col-form-label">Kupon Kodu</label>
                                    <input class="form-control" type="text" name="code" value="{{ old('code') }}" required>
                                    @if($errors->first('code'))
                                        <small class="form-text text-danger">{{ $errors->first('code') }}</small>
                                    @endif
                                </div>

                                <!-- Discount Input -->
                                <div class="mb-3">
                                    <label class="col-form-label">Endirim</label>
                                    <input class="form-control" type="number" name="discount" value="{{ old('discount') }}" required>
                                    @if($errors->first('discount'))
                                        <small class="form-text text-danger">{{ $errors->first('discount') }}</small>
                                    @endif
                                </div>

                                <!-- Type Input (Percentage or Amount) -->
                                <div class="mb-3">
                                    <label class="col-form-label">Endirim Tipi</label>
                                    <select class="form-control" name="type" required>
                                        <option value="percentage" {{ old('type') == 'percentage' ? 'selected' : '' }}>Faiz</option>
                                        <option value="amount" {{ old('type') == 'amount' ? 'selected' : '' }}>Məbləğ</option>
                                    </select>
                                    @if($errors->first('type'))
                                        <small class="form-text text-danger">{{ $errors->first('type') }}</small>
                                    @endif
                                </div>

                                <!-- Valid From Date -->
                                <div class="mb-3">
                                    <label class="col-form-label">Başlanğıc Tarixi</label>
                                    <input class="form-control" type="date" name="valid_from" value="{{ old('valid_from') }}" required>
                                    @if($errors->first('valid_from'))
                                        <small class="form-text text-danger">{{ $errors->first('valid_from') }}</small>
                                    @endif
                                </div>

                                <!-- Valid Until Date -->
                                <div class="mb-3">
                                    <label class="col-form-label">Bitmə Tarixi</label>
                                    <input class="form-control" type="date" name="valid_until" value="{{ old('valid_until') }}" required>
                                    @if($errors->first('valid_until'))
                                        <small class="form-text text-danger">{{ $errors->first('valid_until') }}</small>
                                    @endif
                                </div>

                                <!-- Active Checkbox -->
{{--                                <div class="mb-3">--}}
{{--                                    <label class="col-form-label">Aktiv</label>--}}
{{--                                    <input class="form-control" type="checkbox" name="is_active" {{ old('is_active') ? 'checked' : '' }}>--}}
{{--                                </div>--}}

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
