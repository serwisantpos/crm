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
<?php

require_once "connect.php";

mysqli_report(MYSQLI_REPORT_STRICT);

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Edycja profilu</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

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



  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edycja
        <small>profilu</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Formularz</a></li>
        <li class="active">Edycja profilu</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">


          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Edycja profilu pracownika</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

             <?php
mysqli_report(MYSQLI_REPORT_STRICT);
$id = $_GET['id'];
try {
    $cl = new mysqli($host_name, $database_username, $database_password, $database_name);
    if ($cl->connect_errno != 0) {
        throw new Exception(mysqli_connect_errno());
    } else {

        if ($result = $cl->query("SELECT * FROM Pracownicy WHERE id_pracownika = '$id'")) {

            $number = $result->num_rows;
            if ($number > 0) {

                $row = $result->fetch_assoc();
                $_SESSION['id_pracownika'] = $row['id_pracownika'];
                $_SESSION['login'] = $row['login'];
                $_SESSION['imie'] = $row['imie'];
                $_SESSION['nazwisko'] = $row['nazwisko'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['haslo'] = $row['haslo'];
                $_SESSION['adres_zamieszkania'] = $row['adres_zamieszkania'];
                $_SESSION['admin'] = $row['admin'];
                $_SESSION['data_rejestracji'] = $row['data_rejestracji'];
                $_SESSION['edukacja'] = $row['edukacja'];
                $_SESSION['skills'] = $row['skills'];
                $_SESSION['degree'] = $row['degree'];
                $_SESSION['notatki'] = $row['notatki'];
            }
            $result->free_result();

        }
        $cl->close();
    }

} catch (Exception $e) {
    echo '<span style="color:red">Błąd serwera! </span>';
    echo '<br/>Indormacja developerska:' . $e;
}
?>
            <form role="form" autocomplete="off" action="walidacja_edycja_profil.php" method="post">
        <div class="box-body">
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">

            <!-- /.box-header -->
            <!-- form start -->


                <div class="form-group">
                  <label for="exampleInputEmail1">Login: <?php echo $_SESSION['login']; ?></label>
                  <input type="text" name="login" class="form-control" id="exampleInputEmail1" placeholder="Login" required>
                  <?php if (isset($_SESSION['e_login'])) {
    echo $_SESSION['e_login'];
}
unset($_SESSION['e_login']);?>
                </div>



                <div class="form-group">
                  <label for="exampleInputPassword1">Imie: <?php echo $_SESSION['imie']; ?></label>
                  <input required type="text" name="imie" class="form-control" id="exampleInputPassword1" placeholder="Imie">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Nazwisko: <?php echo $_SESSION['nazwisko']; ?></label>
                  <input required type="text" name="nazwisko" class="form-control" id="exampleInputPassword1" placeholder="Nazwisko">

                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Email: <?php echo $_SESSION['email']; ?></label>
                  <input required type="email" name="email" class="form-control" id="exampleInputPassword1" placeholder="Email">
                  <?php if (isset($_SESSION['e_email'])) {
    echo $_SESSION['e_email'];
}
unset($_SESSION['e_email']);?>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Stare hasło: </label>
                  <input required type="password" name="passwrd" class="form-control" id="exampleInputPassword1" placeholder="Stare hasło">
                <?php if (isset($_SESSION['e_haslo'])) {
    echo $_SESSION['e_haslo'];
}
unset($_SESSION['e_haslo']);?>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Nowe hasło: </label>
                  <input required type="password" name="passwrd1" class="form-control" id="exampleInputPassword1" placeholder="Nowe hasło">
                  <?php if (isset($_SESSION['e_haslo1'])) {
    echo $_SESSION['e_haslo1'];
}
unset($_SESSION['e_haslo1']);?>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Potwierdź hasło:</label>
                  <input required type="password" name="passwrd2" class="form-control" id="exampleInputPassword1" placeholder="Potwierdź nowe hasło">
                  <?php if (isset($_SESSION['e_haslo2'])) {
    echo $_SESSION['e_haslo2'];
}
unset($_SESSION['e_haslo2']);?>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Adres zamieszkania: <?php echo $_SESSION['adres_zamieszkania']; ?></label>
                  <input required type="text" name="adres_zamieszkania" class="form-control" id="exampleInputPassword1" placeholder="Adres zamieszkania">
                </div>
                <div class="form-group">
                  <label>Typ: <?php echo $_SESSION['admin']; ?></label>
                  <select name="admin" required>
                    <option value="1">Administrator</option>

                    <option value="0">Serwisant</option>



                  </select>
                </div>

                <div class="form-group">
                  <label for="exampleInputPassword1">Edukacja: <?php echo $_SESSION['edukacja']; ?></label>
                  <input required type="text" name="edukacja" class="form-control" id="exampleInputPassword1" placeholder="Edukacja">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Umiejętności: <?php echo $_SESSION['skills']; ?></label>
                  <input required type="text" name="skills" class="form-control" id="exampleInputPassword1" placeholder="Skills">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Stopień naukowy/tytuł zawodowy: <?php echo $_SESSION['degree']; ?></label>
                  <input required type="text" name="degree" class="form-control" id="exampleInputPassword1" placeholder="Stopień naukowy/tytuł zawodowy">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Notatki: <?php echo $_SESSION['notatki']; ?></label>
                  <input required type="text" name="notatki" class="form-control" id="exampleInputPassword1" placeholder="Notatki">
                </div>
                <input name="id" class="form-control" type="hidden" value="<?php echo $_SESSION['id_pracownika']; ?>">
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
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
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

<!-- jQuery 2.2.3 -->
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- page script -->
<script>
  $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  });
</script>

</body>
</html>
