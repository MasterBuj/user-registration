<?php

session_start();
if (isset($_SESSION["username"])) {
    $username = $_SESSION["username"];
    session_write_close();
    $url = "home.view.php";
    header("Location: $url");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["signup-btn"])) {
    require_once '../Model/Member.php';
    $member = new Member();
    $response = $member->registerMember();
}
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>User Registration</title>
        <link rel="stylesheet" type="text/css" href="../dist/css/bootstrap4-neon-glow.min.css">

    </head>

    <body>
        <div class="d-flex align-items-center justify-content-center" style="height: 250px;">
            <div class="container col-md-4 p-5 m-auto ">

                <form name="sign-up" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"
                    onsubmit="">
                    <h1 class="mb-5">
                        <span class="text-primary">Sign up</span>
                        <a href="login.view.php" class="text-muted text-10">| Login</a>
                    </h1>

                    <?php

                    if (!empty($response["status"]) && $response["status"] == "error") { ?>

                    <div class="alert alert-danger" role="alert">
                        <strong>Oh snap! </strong>
                        <?php echo $response["message"]; ?>
                    </div>

                    <?php }

                    if (!empty($response["status"]) && $response["status"] == "success") { ?>

                    <div class="alert alert-success" role="alert">
                        <strong>Congrations! </strong>
                        <?php echo $response["message"]; ?>
                    </div>

                    <?php } ?>


                    <div class="mb-3">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" autocomplete="off"
                            placeholder="Username" required />
                    </div>

                    <div class="mb-3">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" autocomplete="off"
                            placeholder="Email" required />
                    </div>

                    <div class="mb-3">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" autocomplete="off"
                            minlength="8" placeholder="Password" required />
                    </div>

                    <div class="mb-3">
                        <label for="confirm-password">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm-password" name="confirmpassword"
                            autocomplete="off" minlength="8" placeholder="Confirm Password" required />
                    </div>

                    <input class="btn btn-primary btn-lg btn-block" type="submit" name="signup-btn" id="signup-btn" />
                </form>
            </div>
        </div>
    </body>


    <script src="../dist/js/jquery-3.2.1.slim.min.js" type="text/javascript"></script>
    <script src="../dist/js/form-validation.js"></script>
    <script>
    $(function() {
        $("form[name='sign-up']").validate({
            errorClass: 'text-danger',
            // validClass: 'success',
            // errorElement: 'span',
            rules: {
                username: "required",
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 8
                },
                confirmpassword: {
                    required: true,
                    minlength: 8,
                    equalTo: "#password"
                }
            },
            messages: {
                username: "Please enter your username",
                email: "Please enter a valid email address",
                password: {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 8 characters long"
                },
                confirmpassword: {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 8 characters long",
                    equalTo: "Please enter the same password as above"
                }
            },
            submitHandler: function(form) {
                return true;
            }
        });
    });
    </script>


</html>