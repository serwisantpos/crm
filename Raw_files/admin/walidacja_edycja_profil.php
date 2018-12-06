<?php

session_start();
require_once "connect.php";
if (isset($_POST['id'])) {

    $wszystko_dobrze = true;
    $login = $_POST['login'];
    $imie = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];
    $email = $_POST['email'];
    $haslo = $_POST['passwrd'];
    $haslo1 = $_POST['passwrd1'];
    $haslo2 = $_POST['passwrd2'];
    $adres_zamieszkania = $_POST['adres_zamieszkania'];
    $admin = $_POST['admin'];
    $data_rejestracji = $_POST['data_rejestracji'];
    $edukacja = $_POST['edukacja'];
    $skills = $_POST['skills'];
    $degree = $_POST['degree'];
    $notatki = $_POST['notatki'];
    $id = $_POST['id'];

    mysqli_report(MYSQLI_REPORT_STRICT);
    try
    {
        $cl = new mysqli($host_name, $database_username, $database_password, $database_name);
        if ($cl->connect_errno != 0) {
            throw new Exception(mysqli_connect_errno());
        } else {
            if ($result = $cl->query("SELECT * FROM Pracownicy WHERE id_pracownika = '$id'")) {

                $number = $result->num_rows;
                if ($number > 0) {
                    $row = $result->fetch_assoc();

                    if (!password_verify($haslo, $row['haslo'])) {
                        $wszystko_dobrze = false;
                        $_SESSION['e_haslo'] = '<span style="color: red;">Podane hasło jest nieprawidłowe!</span>';
                        header("Location: edycja_profil.php?id=$id");
                        exit();
                    }
                }
            }
            $result = $cl->query("SELECT * FROM Pracownicy WHERE email = '$email'");

            if (!$result) {
                throw new Exception($cl->error);
            }

            $number = $result->num_rows;
            if ($number > 1) {
                $wszystko_dobrze = false;
                $_SESSION['e_email'] = "Podany e-mail już istnieje w bazie!";
                header("Location: edycja_profil.php?id=$id");
                exit();
            }
            $result = $cl->query("SELECT * FROM Pracownicy WHERE login = '$login'");

            if (!$result) {
                throw new Exception($cl->error);
            }

            $number = $result->num_rows;
            if ($number > 1) {
                $wszystko_dobrze = false;
                $_SESSION['e_login'] = "Podany login już istnieje w bazie!";
                header("Location: edycja_profil.php?id=$id");
                exit();
            }
            if ((strlen($login) < 3) || (strlen($login) > 20)) {
                $wszystko_dobrze = false;
                $_SESSION['e_login'] = '<span style="color:red">Login musi posiadać od 3 do 20 znaków</span>';
                header("Location: edycja_profil.php?id=$id");
                exit();
            }

            if (ctype_alnum($login) == false) {
                $wszystko_dobrze = false;
                $_SESSION['e_login'] = '<span style="color:red">Nick może składać się tylko z liter i cyfr(bez polskich znaków)</span>';
                header("Location: edycja_profil.php?id=$id");
                exit();
            }

            if ((strlen($haslo1) < 8) || (strlen($haslo1) > 20)) {
                $wszystko_dobrze = false;
                $_SESSION['e_haslo1'] = '<span style="color:red">Hasło musi posiadać od 8 do 20 znaków</span>';
                header("Location: edycja_profil.php?id=$id");
                exit();
            }

            if ($haslo1 != $haslo2) {
                $wszystko_dobrze = false;
                $_SESSION['e_haslo2'] = '<span style="color:red">Podane hasła nie są identyczne!</span>';
                header("Location: edycja_profil.php?id=$id");
                exit();
            }

            $haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);

            if ($wszystko_dobrze == true) {
                //Hurra! Wszystko się udało! Edytujemy rekord!
                if ($cl->query("UPDATE Pracownicy SET id_pracownika = '$id', login = '$login', imie = '$imie', nazwisko = '$nazwisko', email = '$email', haslo = '$haslo_hash', adres_zamieszkania = '$adres_zamieszkania', admin = '$admin', edukacja = '$edukacja', skills = '$skills', degree = '$degree', notatki = '$notatki' WHERE id_pracownika = '$id'")) {

                    $_SESSION['udaneedytowanie'] = true;
                    header('Location: Profile.php');
                    exit();

                } else {
                    throw new Exception($cl->error);
                }
            }
            $cl->close();

        }
    } catch (Exception $e) {
        echo '<span style="color:red">Błąd serwera! Prosimy o edycję profilu pracownika w późniejszym terminie!</span>';
        echo '<br/>Indormacja developerska:' . $e;

    }
}
