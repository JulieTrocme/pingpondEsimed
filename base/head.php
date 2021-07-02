<?php
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}

error_reporting(E_ALL);
ini_set('display_errors', 'on');
?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Esimed pingpong 2021</title>
    <link rel="shortcut icon" href="/assets/images/logomini.png" />

    <link rel="stylesheet" href="assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.addons.css">
    <link rel="stylesheet" href="assets/vendors/cropper/cropper.min.css">

    <link rel="stylesheet" href="assets/vendors/iconfonts/font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" href="assets/css/style.css?version=1.2">
</head>