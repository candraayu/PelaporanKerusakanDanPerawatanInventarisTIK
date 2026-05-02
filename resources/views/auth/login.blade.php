<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="keyword" content="">
    <meta name="author" content="theme_ocean">
    <title>Siketik || Pemkab Pati</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/favicon.ico') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/theme.min.css') }}">
</head>

<body>
    <main class="auth-cover-wrapper">
        <div class="auth-cover-content-inner" style="padding: 0 !important; margin: 0 !important;">
            <div class="auth-cover-content-wrapper" style="padding: 0 !important; margin: 0 !important; max-width: 100% !important;">
                <div class="auth-img" style="height: 100vh; width: 100%; display: flex; align-items: center; justify-content: center; overflow: hidden; padding: 0; margin: 0;">
                    <img src="{{ asset('assets/images/auth/2.png') }}" alt="" style="width: 100%; height: 100%; object-fit: contain;">
                </div>
            </div>
        </div>
        <div class="auth-cover-sidebar-inner">
            <div class="auth-cover-card-wrapper">
                <div class="auth-cover-card p-sm-5">
                    <div class="d-flex justify-content-center mb-4">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="" class="img-fluid" style="height: 100px; width: auto;">
                    </div>
                    <div class="text-center">
                        <h2 class="fs-20 fw-bolder mb-4">Masuk</h2>
                        <h4 class="fs-13 fw-bold mb-2">Selamat Datang Di SIKETIK</h4>
                        <p class="fs-12 fw-medium text-muted">Masukkan email dan password untuk mengakses akun Anda.</p>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger mt-3 pb-0">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ url('login') }}" method="POST" class="w-100 mt-4 pt-2">
                        @csrf
                        <div class="mb-4">
                            <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required autofocus>
                        </div>
                        <div class="mb-4">
                            <div class="input-group field">
                                <input type="password" name="password" class="form-control password" id="password" placeholder="Password" required>
                                <div class="input-group-text border-start bg-gray-2 c-pointer show-pass" data-bs-toggle="tooltip" title="Show/Hide Password"><i></i></div>
                            </div>
                        </div>
                        <div class="mt-5">
                            <button type="submit" class="btn btn-lg btn-primary w-100">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script src="{{ asset('assets/vendors/js/vendors.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/lslstrength.min.js') }}"></script>
    <script src="{{ asset('assets/js/common-init.min.js') }}"></script>
    <script src="{{ asset('assets/js/theme-customizer-init.min.js') }}"></script>
</body>

</html>
