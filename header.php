<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTf-8" />
        <meta name="viewport" content="width=device-width,intial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <meta http-equiv='cache-control' content='no-cache'>
        <meta http-equiv='expires' content='0'>
        <meta http-equiv='pragma' content='no-cache'>
        <title>Face Recognition</title>
        <!-- bootstrap css -->
        <link href="assets/bootstrap5/css/bootstrap.min.css" type="text/css" rel="stylesheet">
        <!-- Datatable CSS -->
        <link rel="stylesheet" href="assets/datatable/jquery.dataTables.css">
        <!-- Bootstrap Font Icon CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
        <script defer src="face-api.min.js"></script>
        <!-- bootstrap js -->
        <script type="text/javascript" src="assets/bootstrap5/js/bootstrap.bundle.js"></script>
        <!--Sweetalert2 -->
        <script src="assets/sweetalert2/sweetalert2@11.js"></script>
        <!-- Option Jquery -->
        <script src="assets/jquery/jquery.js"></script>
        <!-- Datatable Js -->
        <script type="text/javascript" charset="utf8" src="assets/datatable/jquery.dataTables.js">
        </script>
        <style>
        body {
            margin: 0;
            padding: 0px;
            width: 100vw;
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        canvas {
            display: block;
            margin: 0 auto;
            position: absolute;
            top: 0px;
            left: 0px;
        }

        .preview {
            display: block;
            margin: 0 auto;
            position: relative;
            top: 0px;
            left: 0px;
        }

        </style>
    </head>
    <body>
        <nav class="navbar navbar-dark bg-dark fixed-top">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Find Face</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar"
                    aria-labelledby="offcanvasDarkNavbarLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Find Face</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                            aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                            <li class="nav-item">
                                <a class="nav-link active" href="index.php">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " aria-current="page" href="search.php">Search</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
