<?php

session_start();

if (isset($_POST['id'])) {

    require_once "connect.php";

    $wszystko_dobrze = true;
    $numer_zlecenia = $_POST['numer_zlecenia'];
    $typ_zlecenia = $_POST['typ_zlecenia'];
    $opis_zlecenia = $_POST['opis_zlecenia'];
    $sla = $_POST['sla'];
    $kontrahent = $_POST['kontrahent'];
    $adres = $_POST['adres'];
    $kontakt = $_POST['kontakt'];
    $pracownik = $_POST['pracownik'];
    $status = $_POST['status'];
    $sprzet = $_POST['sprzet'];
    $sn = $_POST['sn'];
    $tid = $_POST['tid'];
    $id = $_POST['id'];
    $realizacja_data = $_POST['realizacja_data'];
    // $status_zlecenia = $_POST['status_zlecenia'];

    mysqli_report(MYSQLI_REPORT_STRICT);
    try
    {
        $cl = new mysqli($host_name, $database_username, $database_password, $database_name);
        if ($cl->connect_errno != 0) {
            throw new Exception(mysqli_connect_errno());
        } else {

            if ($wszystko_dobrze == true) {
                //Hurra! Wszystko się udało! Edytujemy rekord!
                if ($cl->query("UPDATE Zlecenia SET id_zlecenia = '$id', numer_zlecenia = '$numer_zlecenia', typ_zlecenia = '$typ_zlecenia', opis = '$opis_zlecenia', sla = '$sla', data_wprowadzenia = now(), nazwa_kontrahenta = '$kontrahent', adres_kontrahenta = '$adres', kontakt = '$kontakt', pracownik = '$pracownik', status = '$status', sprzet = '$sprzet', sn = '$sn', tid = '$tid', data_realizacji = '$realizacja_data' WHERE id_zlecenia = '$id'")) {

                    $_SESSION['udaneedytowanie'] = true;
                    header('Location: wszystkie_zlecenia.php');
                    exit();

                } else {
                    throw new Exception($cl->error);
                }
            }
            $cl->close();

        }} catch (Exception $e) {
        echo '<span style="color:red">Błąd serwera! Prosimy o edycję zlecenia w późniejszym terminie!</span>';
        echo '<br/>Indormacja developerska:' . $e;
    }

}
