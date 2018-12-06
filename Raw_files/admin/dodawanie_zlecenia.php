<?php

session_start();

if (!isset($_SESSION['udanelogowanie']) && $_SESSION['udanelogowanie'] != true) {
    header('Location: index.php');
    exit();

}

if ($_SESSION['admin'] == 0) {
    $_SESSION['e_dostep_pracowniczy'] = '<span style="color:red">Nie masz uprawnień do dodawania zleceń!</span>';
    header('Location: indexx.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Dodawanie zlecenia</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="plugins/colorpicker/bootstrap-colorpicker.min.css">

  <!-- Select2 -->
  <link rel="stylesheet" href="plugins/select2/select2.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

  <link rel="stylesheet" href="jquery.datetimepicker.min.css">
  <script src="jquery.js"></script>
  <script src="jquery.datetimepicker.full.js"></script>


  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
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
              <img src="dist/img/user4-128x128.jpg" class="user-image" alt="User Image">

              <span class="hidden-xs"><?php echo $_SESSION['imie'] . ' ' . $_SESSION['nazwisko']; ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">

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
          <img src="dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">
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

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dodawanie nowego zlecenia
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Formularz</a></li>
        <li class="active">Dodawanie zlecenia</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <form role="form" action="walidacja_dodawanie.php" method="post">
        <div class="box-body">
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">

            <!-- /.box-header -->
            <!-- form start -->


                <div class="form-group">
                  <label for="exampleInputEmail1">Numer zlecenia</label>
                  <input type="text" name="numer_zlecenia" class="form-control" id="exampleInputEmail1" placeholder="Numer zlecenia" required>
                  <?php
if (isset($_SESSION['e_numer_zlecenia'])) {
    echo $_SESSION['e_numer_zlecenia'];
    unset($_SESSION['e_numer_zlecenia']);
}
?>
                </div>
                <div class="form-group">
                  <label>Typ zlecenia</label>
                  <select name="typ_zlecenia" class="form-control" required>
                    <option>Instalacja</option>

                    <option>Serwis</option>

                    <option>Wymiana</option>

                    <option>Demontaż</option>

                    <option>Szkolenie</option>

                  </select>
                </div>
                <div class="form-group">
                  <label>Opis</label>
                  <textarea required name="opis_zlecenia" class="form-control" rows="3" placeholder="Opis zlecenia ..."></textarea>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">SLA</label>
                  <input required type="text" name="sla" class="form-control" id="datetime" placeholder="SLA">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Kontrahent</label>
                  <input required type="text" name="kontrahent" class="form-control" id="exampleInputPassword1" placeholder="Kontrahent">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Adres</label>
                  <input required type="text" name="adres" class="form-control" id="exampleInputPassword1" placeholder="Adres">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Kontakt</label>
                  <input required type="text" name="kontakt" class="form-control" id="exampleInputPassword1" placeholder="Kontakt">
                </div>
                <div class="form-group">
                  <label>Wykonawca zlecenia:</label>
                  <select name="pracownik" class="form-control" required>
<?php
require_once "connect.php";
mysqli_report(MYSQLI_REPORT_STRICT);
try {
    $cl = new mysqli($host_name, $database_username, $database_password, $database_name);

    if ($cl->connect_errno != 0) {
        throw new Exception(mysqli_connect_errno());
    } else {

        if ($result = $cl->query("SELECT * FROM Pracownicy")) {

            $numer = $result->num_rows;
            if ($numer > 0) {

                while ($wiersz = $result->fetch_assoc()) {
                    echo '<option>';
                    echo $wiersz['email'];
                    echo '</option>';
                }}
            $result->free_result();
        }
        $cl->close();
    }
} catch (Exception $err) {
    echo '<span style="color:red">Błąd serwera! </span>';
    echo '<br/>Indormacja developerska:' . $err;
}
?>

</select>
                </div>





                <script>
                  $("#datetime").datetimepicker();
                </script>

                <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>



          </div>
          </div>

          <div class="col-md-6">
          <!-- general form elements -->

          </div>

              </div>
          </form>
        </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 0.0.1
    </div>
    <strong>Copyright &copy; 2018-2019 <a href="http://mpeciak.vot.pl">Marek Peciak Studio</a>.</strong> All rights
    reserved.
  </footer>

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
<!-- ./wrapper -->



<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- Select2 -->
<script src="plugins/select2/select2.full.min.js"></script>
<!-- InputMask -->
<script src="plugins/input-mask/jquery.inputmask.js"></script>
<script src="plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="plugins/input-mask/jquery.inputmask.extensions.js"></script>

<!-- SlimScroll 1.3.0 -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- iCheck 1.0.1 -->
<script src="plugins/iCheck/icheck.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page script -->



</body>
</html>
