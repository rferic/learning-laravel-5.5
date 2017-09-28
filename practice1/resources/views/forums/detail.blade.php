@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <!-- TODO Print translates -->
            <h1 class="text-center text-muted">{{ __("Posts") }}</h1>
            <h3 class="text-center text-muted">{{ __("Forum: :forumTitle", ['forumTitle' => $forum->name]) }}</h3>

            <hr />

            <a href="/" class="btn btn-info pull-right">{{ __("Return to List") }}</a>
            <div class="clearfix"></div>

            <hr />

            @forelse ($posts as $key => $post)

                <div class="panel panel-default">

                    <div class="panel-heading panel-heading-post">
                        <a href="/posts/{{ $post->slug }}">{{ $post->title }}</a>
                        <span class="pull-right">{{ __("Owner :ownerName", ['ownerName' => $post->owner->name]) }}</span>
                    </div>

                    <div class="panel-body">
                        {{ $post->description }}

                        <hr />

                        <b>{{ $post->showCategories($post->categories, __('Categories')) }}</b>

                        @if ($post->attachment)
                            <img src="{{ $post->pathAttachment() }}" class="img-responsive img-rounded" />
                        @endif
                    </div>

                    @if ($post->isOwner())
                        <div class="panel-footer">
                            <form method="POST" action="/posts/{{ $post->slug }}">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-danger">{{ __('Remove post') }}</button>
                            </form>
                        </div>
                    @endif
                </div>

            @empty

                <div class="alert alert-danger">
                    {{ __("Posts not found") }}
                </div>

            @endforelse

            @if($posts->count())
                <div class="panel-footer">
                    {{ $posts->links() }}
                </div>
            @endif

            @Logged()
                <h3 class="text-muted">{{ __('Add new post in :forum', ['forum' => $forum->name]) }}</h3>
                @include('partials.errors')

                <form method="POST" action="/posts" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="forum_id" value="{{ $forum->id }}" />

                    <div class="form-group">
                        <label for="title" class="col-md-12 control-label">{{ __('Title') }}</label>
                        <input id="title" name="title" class="form-control" value="{{ old('title') }}" required />
                    </div>

                    <div class="form-group">
                        <label for="description" class="col-md-12 control-label">{{ __('Description') }}</label>
                        <textarea id="description" name="description" class="form-control" required>{{ old('description') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="categories">{{ __('Categories') }}</label>
                        <select multiple id="categories" name="categories[]" class="form-control" size="11">
                            <option value="">{{ __('Select a category') }}</option>
                            <!-- TODO pluck: $id => $name -->
                            @foreach($categories AS $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <label class="btn btn-warning" for="file">
                        <input id="file" name="file" type="file" style="display: none" />
                        {{ __('Upload file') }}
                    </label>

                    <button name="addPost" type="submit" class="btn btn-default">{{ __('Add new post') }}</button>
                </form>
            @else
                @include('partials.login_link', ['message' => __('Login')])
            @endLogged()
        </div>
    </div>
    <hr />
@endsection
