@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="media">
                            <div class="media-left">
                                <img src="{{ $channel->getImage() }}" alt="{{ $channel->name }} image" class="media-object img-rounded">
                            </div>
                            <div class="media-body">
                                {{ $channel->name }}

                                <ul class="list-inline">
                                    <li>
                                        <subscribe-button channel-slug="{{ $channel->slug }}"></subscribe-button>
                                    </li>
                                    <li>
                                        {{ $channel->totalVideoViews() }} video {{ str_plural('view', $channel->totalVideoViews()) }}
                                    </li>
                                </ul>

                                @if($channel->description)
                                    <hr>

                                    <p>{{ $channel->description }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">Videos</div>

                    <div class="panel-body">
                        @if($videos->count())
                            @foreach($videos as $video)
                                <div class="well">
                                    @include('videos.partials._video_result', ['video' => $video])
                                </div>
                            @endforeach

                            {{ $videos->links() }}
                        @else
                            <p>{{ $channel->name }} has no videos.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
