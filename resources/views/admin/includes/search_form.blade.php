
<form action="{{route($route)}}" method="get">
    <div class="row">
        <div class="col-1">
            <div class="mb-3">
                <label class=" col-form-label">Limit</label>
                <select class="form-control" type="text" name="limit">
                    <option value="10" {{ request()->limit == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ request()->limit == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ request()->limit == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ request()->limit == 100 ? 'selected' : '' }}>100</option>
                    <option value="500" {{ request()->limit == 500 ? 'selected' : '' }}>500</option>
                </select>
            </div>
        </div>
        <div class="col-2">
            <div class="mb-3">
                <label class="col-form-label" >Tarixi</label>
                <input class="form-control" id="text" value="{{ request()->date}}" type="date" name="date">
            </div>
        </div>
        <div class="col-2">
            <div class="mb-3">
                <label class=" col-form-label">Status</label>
                <select class="form-control" id="is_active" type="text" name="is_active">
                    <option selected value="">---</option>
                    <option value="1" {{ request()->is_active == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ request()->is_active == 0 && request()->is_active != null ? 'selected' : '' }}>Deactive</option>
                </select>
            </div>
        </div>
        <div class="col-2">
            <div class="mb-3">
                <label class="col-form-label">Text</label>
                <input class="form-control" value="{{ request()->text}}" id="text" type="text" name="text">
            </div>
        </div>
        <div class="col-1">
            <div class="mb-3">
                <div class="pt-4 mt-3">
                    <button value="submit" class="btn btn-primary">Axtar</button>
                </div>
            </div>
        </div>
        <div class="col-1">
            <div class="mb-3">
                <div class="pt-4 mt-3">
                    <a class="btn btn-primary" href="{{route($route)}}">Sıfırla</a>
                </div>
            </div>
        </div>
        <div class="col-1">
            <div class="mb-3">
                <div class="pt-4 mt-3">
                    <p class="text-primary">Nəticə: {{$data['count']}}</p>
                </div>
            </div>
        </div>
    </div>
</form>
