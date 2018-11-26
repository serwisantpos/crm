<?php
session_start();
require_once "connect.php";
$komentarz = $_POST['komentarz'];
$numer_zlecenia = $_SESSION['numer_zlecenia'];
if (strlen($komentarz) == 0) {
    $_SESSION['blad_komentarza'] = '<span style="color:red;">Pole komentarza nie może być puste!</span>';
    header('Location: komentarz.php');
    exit();
} else {
    try {
        $cl = new mysqli($host_name, $database_username, $database_password, "Zlecenia");
        if ($cl->connect_errno != 0) {
            throw new Exception(mysqli_connect_errno());
        } else {
            if ($cl->query("INSERT INTO Komentarze VALUE(NULL,'$numer_zlecenia', '$komentarz', now())")) {
                $_SESSION['wyslano'] = true;
                header('Location: komentarz.php');

            } else {
                throw new Exception($cl->error);
                header('Location: komentarz.php');
            }
        }
        $cl->close();
    } catch (Exception $error) {
        echo "Błąd połączenia" . $error;
    }
}
