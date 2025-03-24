<!doctype html>

<html class="no-js" lang="">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Admin</title>

    <meta name="description" content="Admin">

    <meta name="viewport" content="width=device-width, initial-scale=1">



    <link rel="apple-touch-icon" href="apple-icon.png">

    <link rel="shortcut icon" href="favicon.ico">



    <link rel="stylesheet" href="{{asset('templates-assets/myadminweb/css/bootstrap.min.css')}}">

    <link rel="stylesheet" href="{{asset('templates-assets/myadminweb/css/font-awesome.min.css')}}">

    <link rel="stylesheet" href="{{asset('templates-assets/myadminweb/css/main.css')}}">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet'>

</head>

<body style="background: url('{{ asset('templates-assets/myadminweb/images/bg_image.jpg') }}') no-repeat center center fixed; background-size: cover;">

    <div class="login">

        <div class="col-lg-12" style="text-align: center;">
            <div class="card" style="margin-top: 15%;">
                <p>Sign in to continue</p>

                <div class="card-body card-block">
                    @if (Session::has('error'))
                        <div class="alert alert-warning">{{ Session::get('error') }}</div>
                    @endif

                    {!! Form::open(['method' => 'POST', 'url' => 'adminlogin']) !!}

                    <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-user"></i></div>
                            <input type="text" id="username" name="username" placeholder="Username" class="form-control" value="{{old('username')}}"><br/>
                            <small class="text-danger">{{ $errors->first('username') }}</small>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-lock"></i></div>
                            <input type="password" id="password" name="password" placeholder="Password" class="form-control"><br/>
                            <small class="text-danger">{{ $errors->first('password') }}</small>
                        </div>
                    </div>

                    <div class="form-actions form-group">
                        <button type="submit" class="btn btn-success btn-sm" id="btnlogin">SIGN IN</button>
                    </div>

                    {!! Form::close() !!}
                    <!-- <a href="#">Forgot Password?</a> -->
                </div>
            </div>
            <br/>
        </div>
    </div>
</body>

</html>
