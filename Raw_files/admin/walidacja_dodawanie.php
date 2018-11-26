<?php

session_start();

if (!isset($_SESSION['udanelogowanie']) && $_SESSION['udanelogowanie'] != true) {
    header('Location: index.php');
    exit();

}
?>
<?php

if (isset($_POST['numer_zlecenia'])) {
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

    // $status_zlecenia = $_POST['status_zlecenia'];

    mysqli_report(MYSQLI_REPORT_STRICT);
    try
    {

        $cl = new mysqli($host_name, $database_username, $database_password, $database_name);

        if ($cl->connect_errno != 0) {
            throw new Exception(mysqli_connect_errno());
        } else {

            $result = $cl->query("SELECT * FROM Zlecenia WHERE numer_zlecenia = '$numer_zlecenia'");

            if (!$result) {
                throw new Exception($cl->error);
            }

            $number = $result->num_rows;
            if ($number > 0) {
                $wszystko_dobrze = false;
                $_SESSION['e_numer_zlecenia'] = '<span style="color:red">Podany numer zlecenia już istnieje w bazie!</span>';
                header('Location: dodawanie_zlecenia.php');
                exit();
            }
            if ($wszystko_dobrze == true) {
                //Hurra! Wszystko się udało! Wprowadzamy zlecenie do bazy!
                //,,,'$status_zlecenia')"))
                if ($cl->query("INSERT INTO Zlecenia VALUES (NULL,'$numer_zlecenia','$typ_zlecenia','$opis_zlecenia','$sla',now(),'$kontrahent', '$adres','$kontakt','$pracownik','otwarte')")) {

                    $_SESSION['udanedodawanie'] = true;

                    header('Location: wszystkie_zlecenia.php');

                } else {
                    throw new Exception($cl->error);
                    header('Location: wszystkie_zlecenia.php');
                }
            }
            $cl->close();
        }
    } catch (Exception $e) {
        echo '<span style="color:red">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
        echo '<br/>Indormacja developerska:' . $e;
        header('Location: wszystkie_zlecenia.php');
    }

} else {
    header('Location: dodawanie_urzadzenia.php');
    exit();
}
