<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    {{-- <base href="../../"> --}}
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">

    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="./images/favicon.png">
    <!-- Page Title  -->
    <title>Dashboard | Pension Claims Management Portal</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="./assets/css/dashlite.css?ver=3.2.0">
    <link id="skin-default" rel="stylesheet" href="./assets/css/theme.css?ver=3.2.0">
    <link rel="stylesheet" href="{{asset('assets/font-awesome/css/font-awesome.min.css')}}">

    @yield('styles')

</head>

<body class="nk-body bg-lighter npc-general has-sidebar ">
    <div class="nk-app-root">