<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>PACC IMS v2.0</title>

    <!-- bs5 icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <script src="../styles/sidebars.js"></script>
    <link rel="shortcut icon" href="../assets/brand/pacclogoWhite.ico" type="image/x-icon">

    <!-- Bootstrap core CSS -->
    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../styles/dataTableStyle/css/bootstrap5.0.1.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../styles/dataTableStyle/css/datatables-1.10.25.min.css" />
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        .pagination .page-item.active .page-link {
            background-color: gainsboro;
            color: black;
            border: 1px solid grey;
        }

        .pagination .page-link {
            color: black;
        }

        .pagination .page-link:hover {
            background-color: lightgray;
            color: black;

        }


        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .h2 {
            letter-spacing: 2px;
        }

        thead th {
            text-transform: uppercase;
        }
    </style>
    <!-- Custom styles for this template -->
    <link href="../styles/sidebars.css" rel="stylesheet">
    <link rel="../stylesheet" href="css/index-style.css">
</head>

<body>

    <header class="navbar navbar-dark bg-dark sticky-top flex-md-nowrap p-0 shadow bg-gradient">
        <a class="navbar-brand bg-dark col-md-3 col-lg-2 me-0 px-3 bg-gradient" href="#"><img src="assets/brand/pacclogo.png" alt="" width="25" style="margin-bottom: 3px;"> PACC IMS v2.0</a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- <input class="form-control form-control w-100" type="text" placeholder="Search" aria-label="Search"> -->
        <div class="navbar-nav">
            <div class="nav-item text-nowrap">
                <a class="nav-link px-3" href="../php/logout-inc.php" title="Sign-Out">Sign out <i class="bi bi-box-arrow-left"></i></a>
            </div>
        </div>
    </header>