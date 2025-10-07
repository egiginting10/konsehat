<!DOCTYPE html>
<html lang="en">

<head>
  <title>Konsehat - Register</title>
  <link rel="icon" href="{{ asset('img/konsehat.png') }}">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="{{ asset('login/vendor/bootstrap/css/bootstrap.min.css') }}">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="{{ asset('login/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css"
    href="{{ asset('login/fonts/iconic/css/material-design-iconic-font.min.css') }}">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="{{ asset('login/vendor/animate/animate.css') }}">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="{{ asset('login/vendor/css-hamburgers/hamburgers.min.css') }}">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="{{ asset('login/vendor/animsition/css/animsition.min.css') }}">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="{{ asset('login/vendor/select2/select2.min.css') }}">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="{{ asset('login/vendor/daterangepicker/daterangepicker.css') }}">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="{{ asset('login/css/util.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('login/css/main.css') }}">
  <!--===============================================================================================-->
</head>

<body>

  <div class="limiter">
    <div class="container-login100" style="background-image: url('/img/login.jpg');">
      <div class="wrap-login100">
        <form action="{{ route('register.user') }}" class="login100-form validate-form" method="POST">
          @csrf
          <span class="login100-form-logo">
            <img src="{{ asset('img/konsehat.png') }}" width="100" alt="">
          </span>

          <span class="login100-form-title p-b-34 p-t-27">
            Register
          </span>

          <div class="row">
            <!-- Kolom Kiri -->
            <div class="col-md-6">
              <div class="wrap-input100 validate-input mb-3" data-validate="Masukkan Nama">
                <input class="input100" type="text" name="nama" placeholder="Nama Lengkap" required>
                <span class="focus-input100" data-placeholder="&#xf207;"></span>
              </div>

              <div class="wrap-input100 validate-input mb-3" style="margin-top: 30px" data-validate="Masukkan Email">
                <input class="input100" type="email" name="email" placeholder="Email" required>
                <span class="focus-input100" data-placeholder="&#xf15a;"></span>
              </div>

              <div class="wrap-input100 validate-input mb-3" style="margin-top: 30px">
                <input class="input100" type="text" name="no_hp" placeholder="Nomor HP" required>
                <span class="focus-input100" data-placeholder="&#xf2b9;"></span>
              </div>
            </div>

            <!-- Kolom Kanan -->
            <div class="col-md-6">
              <div class="wrap-input100 validate-input mb-3">
                <input class="input100" type="text" name="alamat" placeholder="Alamat" required>
                <span class="focus-input100" data-placeholder="&#xf1a3;"></span>
              </div>

              <div class="wrap-input100 validate-input mb-3" style="margin-top: 30px" data-validate="Masukkan Password">
                <input class="input100" type="password" name="password" placeholder="Password" required>
                <span class="focus-input100" data-placeholder="&#xf191;"></span>
              </div>
            </div>
          </div>

          <div class="container-login100-form-btn mt-3">
            <button type="submit" class="login100-form-btn">Register</button>
          </div>

          <div class="text-center p-t-90 text-white ml-2">
            Sudah punya akun? <a href="{{ route('get.login') }}" style="color: maroon; font-weight: bold">Login</a>
          </div>
        </form>
      </div>
    </div>
  </div>


  <div id="dropDownSelect1"></div>

  <!--===============================================================================================-->
  <script src="{{ asset('login/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
  <!--===============================================================================================-->
  <script src="{{ asset('login/vendor/animsition/js/animsition.min.js') }}"></script>
  <!--===============================================================================================-->
  <script src="{{ asset('login/vendor/bootstrap/js/popper.js') }}"></script>
  <script src="{{ asset('login/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
  <!--===============================================================================================-->
  <script src="{{ asset('login/vendor/select2/select2.min.js') }}"></script>
  <!--===============================================================================================-->
  <script src="{{ asset('login/vendor/daterangepicker/moment.min.js') }}"></script>
  <script src="{{ asset('login/vendor/daterangepicker/daterangepicker.js') }}"></script>
  <!--===============================================================================================-->
  <script src="{{ asset('login/vendor/countdowntime/countdowntime.js') }}"></script>
  <!--===============================================================================================-->
  <script src="{{ asset('login/js/main.js') }}"></script>

</body>

</html>
