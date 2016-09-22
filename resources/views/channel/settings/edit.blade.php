@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Channel Settings</div>

                    <div class="panel-body">

                        <form action="{{ url('/channel/'. $channel->slug . '/edit') }}" method="post">
                            <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                                <label for="name">Name</label>
                                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') ? old('name') : $channel->name }}">

                                @if ($errors->has('name'))
                                    <div class="help-block">{{ $errors->first('name') }}</div>
                                @endif
                            </div>

                            <div class="form-group {{ $errors->has('slug') ? 'has-error' : ''}}">
                                <label for="slug">Unique URL</label>
                                <div class="input-group">
                                    <div class="input-group-addon">{{ config('app.url') }}/channel/</div>
                                    <input type="text" id="slug" name="slug" class="form-control" value="{{ old('slug') ? old('slug') : $channel->slug }}">
                                </div>

                                @if ($errors->has('slug'))
                                    <div class="help-block">{{ $errors->first('slug') }}</div>
                                @endif
                            </div>

                            <div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" class="form-control">{{ old('description') ? old('description') : $channel->description }}</textarea>

                                @if ($errors->has('description'))
                                    <div class="help-block">{{ $errors->first('description') }}</div>
                                @endif
                            </div>

                            <button class="btn btn-default" type="submit">Update</button>

                            {{ csrf_field() }}
                            {{ method_field('put') }}
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
