<?php
  if (session_status() == PHP_SESSION_NONE) {
      session_start();
  }

  if(!isset($_SESSION['admin_login']) || $_SESSION['admin_login']['ou_login'] == '') {
      $_SESSION['flash']['warning'] = "Merci de vous connecter afin d'accéder à cette page";
      header('Location: login');
      exit();
  }

?>