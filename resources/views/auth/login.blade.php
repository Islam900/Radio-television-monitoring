
<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>RTY Login</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/styles/css/themes/lite-purple.min.css')}}">
    <style>
        .auth-layout-wrap {
            background-image: url({{ asset('assets/images/bg-main.png') }});
            backdrop-filter: invert(20%);
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.min.css" rel="stylesheet">

</head>

<body>
<div class="auth-layout-wrap">
    <div class="auth-content">
        <div class="card o-hidden">
            <div class="row">
                <div class="col-md-12">
                    <div class="p-4">
                        <div class="text-center mb-4">
                            <div class="d-flex justify-content-between align-items-center">
                                    <img src="{{asset('assets/images/gradient_black.png')}}" alt="" height="60px;">
                                    <img src="{{asset('assets/images/logo.svg')}}" alt="" height="60px;">
                            </div>
                        </div>
                        <hr>
                        <form action="{{route('post-login')}}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input id="email" class="form-control" name="email" placeholder="Email ünvanınızı daxil edin..." type="email">
                            </div>
                            <div class="form-group">
                                <label for="password">Şifrə</label>
                                <input id="password" class="form-control" name="password" placeholder="********" type="password">
                            </div>
                            <button class="btn btn-primary btn-block mt-2">Daxil olun</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('assets/js/common-bundle-script.js') }}"></script>

<script src="{{ asset('assets/js/script.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.all.min.js"></script>


    <script>

        @if (session('login_error'))
        const loginError = "{{ session('login_error') }}";
        const ErrorAlert = Swal.fire({
            title: "Xəta!",
            text: loginError,
            icon: "error"
        })
        ErrorAlert.fire();

        @php session()->forget('login_error') @endphp
        @endif
    </script>

</body>
</html>
