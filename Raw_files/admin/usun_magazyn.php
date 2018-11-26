<?php

session_start();

if (!isset($_SESSION['udanelogowanie']) && $_SESSION['udanelogowanie'] != true) {
    header('Location: index.php');
    exit();

}
?>
<?php
session_start();
require_once "connect.php";

mysqli_report(MYSQLI_REPORT_STRICT);

$id = $_GET['id'];

if (isset($id)) {

    try {
        $cl = new mysqli($host_name, $database_username, $database_password, $database_name);
        if ($cl->connect_errno != 0) {
            throw new Exception(mysqli_connect_errno());
        } else {
            $cl->query("DELETE from Magazyn WHERE id_magazyn = '$id'");

            header('Location: zestawienie_urzadzen.php');
            $cl->close();
        }
    } catch (Exception $er) {

        echo '<span style="color:red">Błąd serwera! </span>';
        echo '<br/>Indormacja developerska:' . $er;
    }
}
