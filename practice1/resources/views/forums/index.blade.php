@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <!-- TODO Print translates -->
            <h1 class="text-center text-muted">{{ __("Forums") }}</h1>

            @include('partials.forums.search')
            <hr />

            @forelse ($forums as $key => $forum)

                <div class="panel panel-default">

                    <div class="panel-heading panel-heading-forum">
                        <a href="/forums/{{ $forum->slug }}">{{ $forum->name }}</a>
                        <span class="pull-right">
                            {{ __("Posts") }}: {{ $forum->posts_count }},
                            {{ __("Replies") }}: {{ $forum->replies_count }}
                        </span>
                    </div>

                    <div class="panel-body">
                        {{ $forum->description }}
                    </div>
                </div>

            @empty

                <div class="alert alert-danger">
                    {{ __("Forums not found") }}
                </div>

            @endforelse

            @if($forums->count())
                <div class="panel-footer">
                    {{ $forums->links() }}
                </div>
            @endif

            <h2>{{ __('Add new forum') }}</h2>

            @include('partials.errors')

            <form method="POST" action="/forums">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="name" class="col-md-12 control-label">{{ __("Name") }}</label>
                    <input id="name" name="name" class="form-control" value="{{ old('name') }}" required />
                </div>
                <div class="form-group">
                    <label for="description" class="col-md-12 control-label">{{ __("Description") }}</label>
                    <textarea id="description" name="description" class="form-control" value="{{ old('description') }}" required>{{ old('description') }}</textarea>
                </div>

                <button type="submit" name="addForum" class="btn btn-default">{{ __('Add forum') }}</button>
            </form>
        </div>
    </div>
@endsection
