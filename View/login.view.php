<?php

session_start();
if (isset($_SESSION["username"])) {
    $username = $_SESSION["username"];
    session_write_close();
    $url = "home.view.php";
    header("Location: $url");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["login-btn"])) {
    require_once '../Model/Member.php';
    $member = new Member();
    $response = $member->loginMember();
}
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <link rel="stylesheet" href="../dist/css/bootstrap4-neon-glow.min.css">
    </head>

</html>

<body>
    <div class="d-flex align-items-center justify-content-center" style="height: 250px;">
        <div class="container col-md-4 p-5 m-auto ">

            <form name="login" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" onsubmit="">
                <h1 class="mb-5"><span class="text-primary">Login</span>
                    <a href="registration.view.php" class="text-muted text-10">| Sign up</a>
                </h1>

                <?php if (!empty($response)) { ?>
                <div class="alert alert-danger" role="alert">
                    <strong>Oh snap!</strong>
                    <?php echo $response; ?>
                </div>
                <?php } ?>

                <div class="mb-3">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username"
                        autocomplete="off" required />
                </div>

                <div class="mb-3">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password"
                        required />
                </div>

                <input class="btn btn-primary btn-lg btn-block" type="submit" name="login-btn" id="login-btn" />
            </form>

        </div>
    </div>


</body>
<script src="../dist/js/jquery-3.2.1.slim.min.js" type="text/javascript"></script>
<script src="../dist/js/form-validation.js"></script>
<script>
$(function() {
    $("form[name='login']").validate({
        errorClass: 'text-danger',
        // validClass: 'success',
        // errorElement: 'span',

        rules: {
            username: "required",
            password: {
                required: true,
                minlength: 8
            }
        },
        messages: {
            username: "Please enter your username",
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 8 characters long"
            }
        },
        submitHandler: function(form) {
            return true;
        }
    });
});
</script>

</html>