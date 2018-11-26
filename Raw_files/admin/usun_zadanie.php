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
            $cl->query("DELETE from todolist WHERE id_todolist = '$id'");

            header('Location: indexx.php');
            $cl->close();
        }
    } catch (Exception $er) {

        echo '<span style="color:red">Błąd serwera! </span>';
        echo '<br/>Indormacja developerska:' . $er;
    }
}
