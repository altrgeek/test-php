<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <base href="">
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="images/cogni_logo_reg.png">
    <!-- Page Title  -->
    <title>Cogni™ Dashboard</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="{{asset('assets/css/dashlite.css?ver=2.9.0')}}">
    <link id="skin-default" rel="stylesheet" href="{{asset('assets/css/theme.css?ver=2.9.0')}}">

    <style>
        .login-bg-content {
            background-image: url('{{ asset("images/cogni-ui-background/Group 3285.png") }}');
            background-size: cover;
            background-position: center;
            overflow: hidden;
        }
        .slider-wrap {
            transform: translateY(+30%) !important;
        }
        .login-content {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>

<body class="nk-body bg-white npc-general pg-auth">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- wrap @s -->
            <div class="nk-wrap nk-wrap-nosidebar">
                <!-- content @s -->
                @yield('content')


            <!-- content @e -->
        </div>
        <!-- main @e -->
    </div>
    <!-- app-root @e -->

    <!-- JavaScript -->
    <script src="{{asset('assets/js/bundle.js?ver=2.9.0')}}"></script>
    <script src="{{asset('assets/js/scripts.js?ver=2.9.0')}}"></script>
</html>
