<?php

if (isset($_SESSION['user'])) {
    header("location: php/logout-inc.php");
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>PACC IMS</title>
    <link rel="shortcut icon" href="assets/brand/pacclogoWhite.ico" type="image/x-icon">
    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sign-in/">



    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>


    <!-- Custom styles for this template -->
    <link href="styles/signin.css" rel="stylesheet">
</head>

<body class="text-center" style="background-color: whitesmoke;">
    <div class="container-sm bg-light p-4 shadow" style="width: auto">
        <div class="row">
            <div class="col-12">
                <h1 class="h3 mb-1 fw-normal" style="letter-spacing: 3px;text-transform:uppercase">Inventory Management System</h1>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-5">
                <img class="mt-3" src="assets/brand/login-logo.png" alt="" width="200">
            </div>
            <div class="col-7">
                <form autocomplete="off" action="php/login-inc.php" method="POST">

                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="floatingInput" placeholder="name@example.com" name="username" required>
                        <label for="floatingInput">Username</label>
                    </div>

                    <div class="form-floating mt-3">
                        <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="pwd" required>
                        <label for="floatingPassword">Password</label>
                    </div>
                    <button class="w-100 btn btn-lg btn-secondary bg-gradient mt-3" type="submit" name="submit">Sign in</button>
                </form>
            </div>
        </div>

    </div>

    <?php include "footer.php"; ?>
</body>

</html>