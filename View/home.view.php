<?php
session_start();
if (isset($_SESSION["username"])) {
    $username = $_SESSION["username"];
    session_write_close();
} else {
    session_unset();
    session_write_close();
    $url = "../index.php";
    header("Location: $url");
}

?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home Page</title>
        <link rel="stylesheet" href="../dist/css/bootstrap4-neon-glow.min.css">
    </head>

</html>

<body>
    <div class="">
        <div class="d-flex flex-column align-items-center justify-content-center" style="height: 250px;">
            <h1 class="m-5"> Welcome
                <span class="text-primary text-uppercase strong">
                    <?php echo $username; ?>
                </span>
            </h1>
            <a href="../logout.php">
                <button class="btn btn-danger">
                    Logout
                </button>
            </a>

        </div>
    </div>
</body>

</html>