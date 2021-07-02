<?php
require 'session.php';
require 'bdd.php';


error_reporting(E_ALL);
ini_set('display_errors', 'on');

if(isset($_POST['avatar64']) && isset($_POST['avatar64name'])) {
    $filename = $_POST['avatar64name'];
    $filename = preg_replace('/[^A-Za-z0-9\-.]/', '', $filename);
    $img = $_POST['avatar64'];
    $img = str_replace('data:image/jpeg;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $data = base64_decode($img);
    file_put_contents('../assets/images/pieces/'.$filename, $data);

    $dataUpd = $bdd->prepare('UPDATE t_piece SET pi_image = ? WHERE pi_id = ?');
    $dataUpd->execute(['/assets/images/pieces/'.$filename, $_POST['pi_id']]);
    $dataUpd->closeCursor();
}

