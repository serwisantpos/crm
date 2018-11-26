<?php

session_start();

if (!isset($_SESSION['udanelogowanie']) && $_SESSION['udanelogowanie'] != true) {
    header('Location: index.php');
    exit();

}
?>
<?php

if (isset($_POST['sn'])) {
    require_once "connect.php";
    $wszystko_dobrze = true;
    $sprzet = $_POST['sprzet'];
    $ilosc = $_POST['ilosc'];
    $sn = $_POST['sn'];
    $tid = $_POST['tid'];

    mysqli_report(MYSQLI_REPORT_STRICT);
    try
    {

        $cl = new mysqli($host_name, $database_username, $database_password, $database_name);

        if ($cl->connect_errno != 0) {
            throw new Exception(mysqli_connect_errno());
        } else {

            $result = $cl->query("SELECT * FROM Magazyn WHERE sn = '$sn'");

            if (!$result) {
                throw new Exception($cl->error);
            }

            $number = $result->num_rows;
            if ($number > 0) {
                $wszystko_dobrze = false;
                $_SESSION['e_sn'] = '<span style="color:red">Podany numer seryjny urządzenia już istnieje w bazie!</span>';
                header('Location: dodawanie_urzadzenia.php');
                exit();
            }
            if ($wszystko_dobrze == true) {
                //Hurra! Wszystko się udało! Wprowadzamy urzadzenie do bazy!
                //,,,'$status_zlecenia')"))
                if ($cl->query("INSERT INTO Magazyn VALUES (NULL,'$sprzet','$ilosc','$sn','$tid')")) {

                    $_SESSION['udanedodawanie'] = true;

                    header('Location: zestawienie_urzadzen.php');

                } else {
                    throw new Exception($cl->error);
                    header('Location: indexx.php');
                }
            }
            $cl->close();
        }
    } catch (Exception $e) {
        echo '<span style="color:red">Błąd serwera! Przepraszamy za niedogodności i prosimy o dodanie urządzenia w innym terminie!</span>';
        echo '<br/>Indormacja developerska:' . $e;
        header('Location: indexx.php');
    }

} else {
    header('Location: dodawanie_urzadzenia.php');
    exit();
}
