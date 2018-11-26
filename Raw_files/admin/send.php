<?php
session_start();

if (!isset($_POST['emailto']) && !isset($_POST['subject']) && !isset($_POST['message'])) {
    header('Location: quick.php');
    exit();
}
if (isset($_POST['emailto'])) {
    $emailto = $_POST['emailto'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    mail($emailto, $subject, $message);
    $_SESSION['wyslano'] = '<span style="color:red">Wysłano wiadomość</span>';
    header('Location: quick.php');
    exit();

}
