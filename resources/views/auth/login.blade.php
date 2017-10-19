@extends('template.login.main')

@section('content')

<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>Inicio Sesion</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
            {!! csrf_field() !!}

            <div class="form-group has-feedback">
                <input id="NOM_USUA" type="text" class="form-control" name="NOM_USUA" value="{{ old('NOM_USUA') }}" required autofocus placeholder="Usuario">

                @if ($errors->has('NOM_USUA'))
                <span class="help-block">
                    <strong>{{ $errors->first('NOM_USUA') }}</strong>
                </span>
                @endif
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input id="CON_USUA" type="password" class="form-control" name="CON_USUA" required placeholder="Contraseña">

                @if ($errors->has('CON_USUA'))
                <span class="help-block">
                    <strong>{{ $errors->first('CON_USUA') }}</strong>
                </span>
                @endif 
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Recordarme
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Ingresar</button>
                </div>
                <!-- /.col -->
            </div>
        </form>
        <br/>
        <a href="{{ route('password.request') }}">Olvide mi contraseña</a><br>

    </div>
    <!-- /.login-box-body -->
</div>
@endsection
