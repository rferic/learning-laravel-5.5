<form method="POST" action="/forums/search">
    {{ csrf_field() }}

    <div class="row">
        <div class="col-xs-12">
            <div class="input-group input-group-xs">
                <input type="text" name="search" value="{{ session('search') }}" class="form-control" />
                <div class="input-group-btn">
                    <button type="submit" class="btn btn-primary">{{ __('Search') }}</button>
                    <a href="{{ route('forums.clear_search') }}" class="btn btn-default">
                        {{ __('Clear') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>
