<?php
session_start();

if (!isset($_POST['email']) or !isset($_POST['password'])) {
    header('Location: index.php');
    exit();
}

require_once "connect.php";

$cl = @new mysqli($host_name, $database_username, $database_password, $database_name);

if ($cl->connect_errno != 0) {
    echo "Error:" . $cl->connect_errno;
} else {
    $email = $_POST['email'];
    $passwrd = $_POST['password'];

    $email = htmlentities($email, ENT_QUOTES, "UTF-8");

    if ($result = @$cl->query(
        sprintf("SELECT * FROM Pracownicy WHERE email='%s'",
            mysqli_real_escape_string($cl, $email)))) {
        $number = $result->num_rows;
        if ($number > 0) {
            $row = $result->fetch_assoc();

            if (password_verify($passwrd, $row['haslo'])) {
                $_SESSION['log'] = true;

                $_SESSION['email'] = $row['email'];
                $_SESSION['admin'] = $row['admin'];

                //$_SESSION['password'] = $row['password'];
                $_SESSION['udanelogowanie'] = true;
                unset($_SESSION['error']);
                $result->free_result();
                header('Location: Raw_files/admin/indexx.php');
            } else {
                $_SESSION['error'] = '<span style="color:red">E-mail or password error</span>';
                header('Location: index.php');

            }
        } else {
            $_SESSION['error'] = '<span style="color:red">E-mail or password error</span>';
            header('Location: index.php');
        }
    }

    $cl->close();
}
