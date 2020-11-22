@extends('base')

@section('page')
    <div class="card card-default">
        <div class="card-body">
            <form action="{{ $formRoute ?? '' }}" method="POST">
                @csrf
                @method($formMethod ?? 'POST')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">
                                @lang('cities.create.name')
                            </label>
                            <input type="text" required value="{{ old('name') ?? ($city->name ?? '') }}"
                                   class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                   name="name">
                            @if($errors->has('name'))
                                <div class="error invalid-feedback">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <div class="row">
                    <div class="col-12">
                        @include('includes.buttons-form', ['cancelRoute' => route('cities.index')])
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop
