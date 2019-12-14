<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>登录</title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
  <!-- CSS Files -->
  <link href="/assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="/assets/css/paper-dashboard.css?v=2.0.1" rel="stylesheet" />

</head>

<body class="login-page">
  <nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent">
    <div class="container">
      <div class="navbar-wrapper">
        <a class="navbar-brand" href="javascript:;">在线匹配系统</a>
      </div>
    </div>
  </nav>
  <!-- End Navbar -->
  <div class="wrapper wrapper-full-page ">
    <div class="full-page section-image" filter-color="black" data-image="/assets/img/bg/david-marcu.jpg">
      <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->
      <div class="content">
        <div class="container">
          <div class="col-lg-4 col-md-6 ml-auto mr-auto">
            <form class="form" method="POST" action="{{ route('auth.login') }}">
                @csrf
              <div class="card card-login">

                <div class="card-header ">
                  <div class="card-header ">
                    <h3 class="header text-center">Match Online</h3>
                  </div>
                </div>

                <div class="card-body ">

                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="nc-icon nc-single-02"></i>
                      </span>
                    </div>
                    <input id="mobile" name="mobile" value="{{ old('mobile') }}" type="text" class="form-control" placeholder="手机号..." required autofocus>
                  </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-warning btn-round btn-block mb-3">{{ __('登录') }}</button>
                </div>

              </div>
            </form>
          </div>
        </div>
      </div>
      <footer class="footer footer-black  footer-white ">
        <div class="container-fluid">
          <div class="row">
            <nav class="footer-nav">
              <ul>
                <li>
                  <a href="#" target="_blank">Brill Team</a>
                </li>
              </ul>
            </nav>
            <div class="credits ml-auto">
              <span class="copyright">
                ©
                <script>
                  document.write(new Date().getFullYear())
                </script>, made with <i class="fa fa-heart heart"></i> by Brill
              </span>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </div>
  <div class="alert alert-warning">
      <button type="button" data-dismiss="alert" aria-hidden="false" class="close">×</button>
      <span>123123123</span>
  </div>
  <!--   Core JS Files   -->
  <script src="/assets/js/core/jquery.min.js"></script>
  <script src="/assets/js/core/popper.min.js"></script>
  <script src="/assets/js/core/bootstrap.min.js"></script>
  <script src="/assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <script src="/assets/js/plugins/sweetalert2.min.js"></script>
  <script src="/assets/js/plugins/jquery.validate.min.js"></script>
  <script src="/assets/js/plugins/jasny-bootstrap.min.js"></script>
  <script src="/assets/js/plugins/bootstrap-notify.js"></script>
  <script src="/assets/js/paper-dashboard.min.js?v=2.0.1" type="text/javascript"></script>
  <script src="/assets/js/app.js"></script>
  @if ($errors->has('message'))
  <script>
    app.alertError("{{ $errors->first('message') }}")
  </script>
  @endif

  <script>
    $(document).ready(function() {
      app.checkFullPageBackgroundImage();
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });

    $('form').on('submit', function (e) {
        var that = this;
        // 取消事件的默认提交动作
        e.preventDefault();

        $(this).find('button[type=submit]').attr('disabled', 'disabled');

        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            data: $(this).serializeArray(),
            beforeSend: function (xhr) {
            // 提交前准备事件
            }
        }).done(function (data) {
            console.log(data);
            if (data.auth) {
                window.location.href = '/match';
            }
        });
    });
  </script>
</body>

</html>