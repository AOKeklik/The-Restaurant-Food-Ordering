<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>@yield("title", "Admin")</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset("dist/modules/bootstrap/css/bootstrap.min.css") }}">
  <link rel="stylesheet" href="{{ asset("dist/modules/fontawesome/css/all.min.css") }}">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="{{ asset("dist/modules/iziToast/css/iziToast.min.css") }}">

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset("dist/css/style.css") }}">
  <link rel="stylesheet" href="{{ asset("dist/css/components.css") }}">
  
  @stack("styles")

<!-- Start GA -->
    {{-- <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-94034622-3');
    </script> --}}
<!-- /END GA -->

</head>
<body>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">