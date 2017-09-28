@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <!-- TODO Print translates -->
            <h1 class="text-center text-muted">{{ __("Replies") }}</h1>
            <h3 class="text-center text-muted">{{ __("Post: :postTitle", ['postTitle' => $post->title]) }}</h3>
            <h4 class="text-center text-muted">{{ __("Author") }}: {{ $post->owner->name }}</h4>
            <h4 class="text-center text-muted">{{ __("Forum: :forum", ['forum' => $post->forum->name]) }}</h4>

            <hr />

            <a href="/forums/{{ $post->forum->slug }}" class="btn btn-info pull-right">{{ __("Return to Forum") }}</a>
            <div class="clearfix"></div>

            <hr />

            @forelse ($replies as $key => $reply)

                <div class="panel panel-default">

                    <div class="panel-heading panel-heading-replyt">
                        <p>
                            {{ __("Reply by") }}: {{ $reply->author->name }}
                        </p>
                    </div>

                    <div class="panel-body">
                        {{ $reply->reply }}

                        @if ($reply->attachment)
                            <img src="{{ $reply->pathAttachment() }}" class="img-responsive img-rounded" />
                        @endif
                    </div>

                    @if ($reply->isAuthor())
                        <div class="panel-footer">
                            <form method="POST" action="{{ route('replies.delete', $reply->id) }}">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-danger">{{ __('Remove reply') }}</button>
                            </form>
                        </div>
                    @endif
                </div>

            @empty

                <div class="alert alert-danger">
                    {{ __("Reply not found") }}
                </div>

            @endforelse

            @if($replies->count())
                <div class="panel-footer">
                    {{ $replies->links() }}
                </div>
            @endif

            @Logged()
            <h3 class="text-muted">{{ __('Publish reply') }}</h3>
            @include('partials.errors')

            <form method="POST" action="/replies" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="post_id" value="{{ $post->id }}" />

                <div class="form-group">
                    <label for="title" class="col-md-12 control-label">{{ __('Title') }}</label>
                    <input id="title" name="title" class="form-control" value="{{ old('title') }}" required />
                </div>

                <div class="form-group">
                    <label for="reply" class="col-md-12 control-label">{{ __('Reply') }}</label>
                    <textarea id="reply" name="reply" class="form-control" required>{{ old('reply') }}</textarea>
                </div>

                <label class="btn btn-warning" for="file">
                    <input id="file" name="file" type="file" style="display: none" />
                    {{ __('Upload file') }}
                </label>

                <button name="addPost" type="submit" class="btn btn-default">{{ __('Publish') }}</button>
            </form>
            @else
                @include('partials.login_link', ['message' => __('Login')])
            @endLogged()

            <hr />
        </div>
    </div>
@endsection
