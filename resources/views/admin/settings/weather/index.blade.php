@extends('base')

@section('page')
    <div class="card card-default">
        <div class="card-body">
            <form action="{{ $formRoute ?? '' }}" method="POST">
                @csrf
                @method($formMethod ?? 'POST')
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="email">
                                @lang('settings.weather.index.key')
                            </label>
                            <input type="text" required value="{{ old('api_key') ?? ($settings->api_key ?? '') }}"
                                   class="form-control {{ $errors->has('api_key') ? 'is-invalid' : '' }}"
                                   name="api_key" autocomplete="off">
                            @if($errors->has('api_key'))
                                <div class="error invalid-feedback">
                                    <strong>{{ $errors->first('api_key') }}</strong>
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="password">
                                @lang('settings.weather.index.schedule_time')
                            </label>
                            <input type="time" min="00:00" max="23:59" value="{{ old('schedule_time') ?? ($settings->schedule_time ?? '') }}"
                                   class="form-control {{ $errors->has('schedule_time') ? 'is-invalid' : '' }}"
                                   name="schedule_time" autocomplete="off">
                            @if($errors->has('schedule_time'))
                                <div class="error invalid-feedback">
                                    <strong>{{ $errors->first('schedule_time') }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <div class="row">
                    <div class="col-12">
                        @include('includes.buttons-form', ['cancelRoute' => route('home')])
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop
