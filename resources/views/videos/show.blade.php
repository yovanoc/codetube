@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">

                @if ($video->isPrivate() && Auth::check() && $video->ownedByUser(Auth::user()))
                    <div class="alert alert-info">
                        Your video is currently private. Only you can see it.
                    </div>
                @endif

                    @if ($video->isProcessed() && $video->canBeAccessed(Auth::user()))
                        <video-player video-uid="{{ $video->uid }}" video-url="{{ $video->getStreamUrl() }}" thumbnail-url="{{ $video->getThumbnail() }}"></video-player>
                    @endif

                    @if (!$video->isProcessed())
                        <div class="video-placeholder">
                            <div class="video-placeholder__header">
                                This video is processing. Come back a bit later.
                            </div>
                        </div>
                    @elseif (!$video->canBeAccessed(Auth::user()))
                        <div class="video-placeholder">
                            <div class="video-placeholder__header">
                                This video is private.
                            </div>
                        </div>
                    @endif

                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="panel-heading">
                            <h3>{{ $video->title }} <small>{{ $video->created_at->toDateTimeString() }}</small></h3>
                        </div>
                        <div class="pull-right">
                            <div class="video__views">
                                {{ $video->viewCount() }} {{ str_plural('view', $video->viewCount()) }}
                            </div>

                            @if($video->votesAllowed())
                                <video-voting video-uid="{{ $video->uid }}"></video-voting>
                            @else
                                <p>Votes are disabled for this video.</p>
                            @endif

                        </div>

                        <div class="media">
                            <div class="media-left">
                                <a href="/channels/{{ $video->channel->slug }}">
                                    <img src="{{ $video->channel->getImage() }}" alt="{{ $video->channel->name }} image" class="img-rounded">
                                </a>
                            </div>
                            <div class="media-body">
                                <a href="/channels/{{ $video->channel->slug }}" class="media-heading">{{ $video->channel->name }}</a>
                                <subscribe-button channel-slug="{{ $video->channel->slug }}"></subscribe-button>
                            </div>
                        </div>
                    </div>
                </div>

                @if($video->description)
                    <div class="panel panel-default">
                        <div class="panel-body">
                            {!! nl2br(e($video->description, false)) !!}
                        </div>
                    </div>
                @endif

                <div class="panel panel-default">
                    <div class="panel-body">
                        @if($video->commentsAllowed())
                            <video-comments video-uid="{{ $video->uid }}"></video-comments>
                        @else
                            <p>Comments are disabled for this video.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
