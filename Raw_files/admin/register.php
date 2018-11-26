<?php

session_start();

if (!isset($_SESSION['udanelogowanie']) && $_SESSION['udanelogowanie'] != true) {
    header('Location: index.php');
    exit();

}
if ($_SESSION['admin'] == 0) {
    $_SESSION['e_dostep_pracowniczy'] = '<span style="color:red">Nie masz uprawnień do zarejestrowania nowego pracownika!</span>';
    header('Location: Raw_files/admin/indexx.php');
    exit();
}
if (isset($_POST['email'])) {
    $wszystko_ok = true;
    $login = $_POST['login'];
    $imie = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];
    $email = $_POST['email'];
    $haslo1 = $_POST['password'];
    $haslo2 = $_POST['password2'];
    $adres = $_POST['adres'];
    //sprawdzenie długości loginu

    if ((strlen($login) < 3) || (strlen($login) > 20)) {
        $wszystko_ok = false;
        $_SESSION['e_login'] = '<span style="color:red">Login musi posiadać od 3 do 20 znaków</span>';
    }

    if (ctype_alnum($login) == false) {
        $wszystko_ok = false;
        $_SESSION['e_login'] = '<span style="color:red">Nick może składać się tylko z liter i cyfr(bez polskich znaków)</span>';
    }

    //sprawdź poprawność hasła

    if ((strlen($haslo1) < 8) || (strlen($haslo1) > 20)) {
        $wszystko_ok = false;
        $_SESSION['e_haslo'] = '<span style="color:red">Hasło musi posiadać od 8 do 20 znaków</span>';
    }

    if ($haslo1 != $haslo2) {
        $wszystko_ok = false;
        $_SESSION['e_haslo'] = '<span style="color:red">Podane hasła nie są identyczne!</span>';
    }

    $haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);

    require_once "connect.php";

    mysqli_report(MYSQLI_REPORT_STRICT);
    try {
        $cl = new mysqli($host_name, $database_username, $database_password, $database_name);
        if ($cl->connect_errno != 0) {
            throw new Exception(mysqli_connect_errno());
        } else {
            //sprawdzenie czy e-mail istnieje w bazie danych?

            $result = $cl->query("SELECT id_pracownika FROM Pracownicy WHERE email = '$email'");

            if (!$result) {
                throw new Exception($cl->error);
            }

            $number = $result->num_rows;
            if ($number > 0) {
                $wszystko_ok = false;
                $_SESSION['e_email'] = "Podany e-mail już istnieje w bazie!";
            }
            if ($wszystko_ok == true) {
                //Hurra! Wszystko się udało! Wprowadzamy użytkownika do bazy!

                if ($cl->query("INSERT INTO Pracownicy VALUES (NULL,'$login','$imie','$nazwisko','$email','$haslo_hash','$adres', '0', now())")) {
                    $_SESSION['udanarejestracja'] = true;
                    $_SESSION['udanarejestracja_tekst'] = "Pomyślnie udało się zarejestrować nowego pracownika";
                    header('Location: Profile.php');
                } else {
                    throw new Exception($cl->error);
                }
            }
            $cl->close();

        }
    } catch (Exception $e) {
        echo '<span style="color:red">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
        echo '<br/>Indormacja developerska:' . $e;
    }

}

?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Rejestracja</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/flat/blue.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="plugins/morris/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-blue register-page">
<div class="wrapper">

 <header class="main-header">
    <!-- Logo -->
    <a href="indexx.php" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>C</b>RM</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b><?php echo $_SESSION['imie'] . ' </b>' . $_SESSION['nazwisko'] . '</span>'; ?>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $_SESSION['imie'] . ' ' . $_SESSION['nazwisko']; ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

                <p>
                  <?php echo $_SESSION['imie'] . ' ' . $_SESSION['nazwisko']; ?>
                  <small>Członek od <?php echo $_SESSION['data_rejestracji']; ?></small>
                </p>
              </li>


              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="Profile.php" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="wyloguj.php" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>-->
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $_SESSION['imie'] . ' ' . $_SESSION['nazwisko']; ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-edit"></i> <span>Zlecenia</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
          <?php
if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
    echo <<<znacznik

          <li><a href="dodawanie_zlecenia.php"><i class="fa fa-circle-o"></i> Dodaj zlecenie</a></li>
znacznik;
}
?>
          <li><a href="zlecenia_otwarte.php"><i class="fa fa-circle-o"></i> Zlecenia otwarte</a></li>
          <li><a href="zlecenia_zamkniete.php"><i class="fa fa-circle-o"></i> Zlecenia zamknięte</a></li>
          <?php
if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
    echo <<<znacznik
          <li><a href="wszystkie_zlecenia.php"><i class="fa fa-circle-o"></i> Wszystkie zlecenia</a></li>
znacznik;
}
?>

          </ul>
        </li>
<?php
if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
    echo <<<znacznik
        <li class="treeview">
          <a href="#">
            <i class="fa fa-edit"></i> <span>Magazyn</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
          <li><a href="dodawanie_urzadzenia.php"><i class="fa fa-circle-o"></i> Dodaj urządzenie</a></li>
          <li><a href="zestawienie_urzadzen.php"><i class="fa fa-circle-o"></i> Zestawienie urządzeń</a></li>
          </ul>
        </li>
znacznik;
}
?>
        <li>
          <a href="quick.php">
            <i class="fa fa-calendar"></i> <span>Szybki e-mail</span>

          </a>
        </li>

<?php
if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
    echo <<<znacznik
        <li class="treeview">
          <a href="#">
            <i class="fa fa-folder"></i> <span>Administracja</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">

            <li><a href="Profile.php"><i class="fa fa-circle-o"></i> Profile użytkowników</a></li>

            <li><a href="register.php"><i class="fa fa-circle-o"></i> Rejestracja użytkownika</a></li>

          </ul>
        </li>
znacznik;
}
?>


      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>


<div class="register-box">
  <div class="register-logo">
    <b><span style="color:red">Administracja</span></b>
  </div>

  <div class="register-box-body">
    <p class="login-box-msg">Register a new membership</p>

    <form action="" method="post">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" name="login" placeholder="Login" required>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
        <?php
if (isset($_SESSION['e_login'])) {
    echo $_SESSION['e_login'];
    unset($_SESSION['e_login']);
}
?>
      </div>
      <div class="form-group has-feedback">
        <input type="text" class="form-control" name="imie" placeholder="Name" required>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
        <?php
if (isset($_SESSION['e_name'])) {
    echo $_SESSION['e_name'];
    unset($_SESSION['e_name']);
}
?>
      </div>
      <div class="form-group has-feedback">
        <input type="text" class="form-control" name="nazwisko" placeholder="Surname" required>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
        <?php
if (isset($_SESSION['e_surname'])) {
    echo $_SESSION['e_surname'];
    unset($_SESSION['e_surname']);
}
?>
      </div>
      <div class="form-group has-feedback">
        <input type="email" class="form-control" name="email" placeholder="Email" required>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        <?php
if (isset($_SESSION['e_email'])) {
    echo $_SESSION['e_email'];
    unset($_SESSION['e_email']);
}
?>

      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" name="password" placeholder="Password" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        <?php
if (isset($_SESSION['e_haslo'])) {
    echo $_SESSION['e_haslo'];
    unset($_SESSION['e_haslo']);
}
?>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" name="password2" placeholder="Retype password" required>
        <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-12">
        <div class="form-group has-feedback">
        <input type="text" class="form-control" name="adres" placeholder="Adress" required>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>


      </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
        </div>
        <!-- /.col -->
      </div>
    </form>




  </div>
  <!-- /.form-box -->
</div>
<!-- /.register-box -->


<!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-birthday-cake bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                <p>Will be 23 on April 24th</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-user bg-yellow"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                <p>New phone +1(800)555-1234</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                <p>nora@example.com</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-file-code-o bg-green"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                <p>Execution time 5 seconds</p>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

        <h3 class="control-sidebar-heading">Tasks Progress</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Custom Template Design
                <span class="label label-danger pull-right">70%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Update Resume
                <span class="label label-success pull-right">95%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-success" style="width: 95%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Laravel Integration
                <span class="label label-warning pull-right">50%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Back End Framework
                <span class="label label-primary pull-right">68%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

      </div>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Allow mail redirect
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Other sets of options are available
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Expose author name in posts
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Allow the user to show his name in blog posts
            </p>
          </div>
          <!-- /.form-group -->

          <h3 class="control-sidebar-heading">Chat Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Show me as online
              <input type="checkbox" class="pull-right" checked>
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Turn off notifications
              <input type="checkbox" class="pull-right">
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Delete chat history
              <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
            </label>
          </div>
          <!-- /.form-group -->
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>

</div>
<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="plugins/morris/morris.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/knob/jquery.knob.js"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>


<!-- iCheck -->
<script src="plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>
