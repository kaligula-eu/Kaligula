<?php

require("requires.php");

$page = "login";

check("logged", "login");

$error = false;
$error_msg = "";

if(isset($_POST["username"]) && isset($_POST["password"])) {
    $username = clean(mysqli_real_escape_string($conn, $_POST["username"]));
    $password = clean(mysqli_real_escape_string($conn, $_POST["password"]));
    if($error==false) {
        // Everything is fine desu~
        $check = $conn->query("SELECT * FROM `user` WHERE `username`='$username' LIMIT 1");
        if(mysqli_num_rows($check)==1) {
            // Account exists!
            $check = mysqli_fetch_assoc($check);
            $check = password_verify($password, $check["password"]);
            if($check==true) {
                // Yay, user exists & passowrd matches!
                $user = $conn->query("SELECT * FROM `user` WHERE `username`='$username' LIMIT 1");
                $user = mysqli_fetch_assoc($user);
                if($user["banned"]==false) {
                    $uid = $user["id"];
                    $token = rand();
                    $token = md5($token);
                    setcookie("".$config["cookie"]."_session", $token, time()+(86400*30), "/");
                    $conn->query("INSERT INTO `sessions`(`user-id`,`token`) VALUES('$uid','$token')");
                    header("Location: home.php");
                } else {
                    // LOLUMAD BANNED ROFL
                    $error = true;
                    $error_msg = "You're banned. Reason: ".$user["banned_reason"];
                }
            } else {
                // Ewww error
                $error = true;
                $error_msg = "Password is wrong.";
            }
        } else {
            // User doesn't exist
            $error = true;
            $error_msg = "Username is wrong.";
        }
    }
}

$user["theme"] = 3;

include("parts/header.php");

?>

<title>Login | <?= $config["title"] ?></title>

<style>
    .white {
        color: #000;
        background-color: #fff;
    }

    .container {
        margin-top: 100px;
    }

    body {
        background: black;
    }

</style>

</head>

<body>

    <div class="container">

        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?= $config["title"]." - ".$config["slogan"] ?></h3>
                        </div>
                        <div class="panel-body">
                            <?php if($error==true) { ?>
                            <div class="alert alert-warning alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong><?= glyph("triangle-exclamation", "Error", "fade") ?></strong> <?= $error_msg ?>
                            </div>
                            <?php } ?>
                            <form accept-charset="UTF-8" role="form" method="post">
                                <fieldset>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Username" name="username" type="text">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                    </div>
                                    <button class="btn btn-lg btn-success btn-block" type="submit" style="--fa-flip-x: 1; --fa-flip-y: 0;"><?= glyph("arrow-right-to-bracket", "Login", "flip") ?> Login</button>
                                </fieldset>
                            </form>
                            <hr>
                            <center>
                                <p><a href="<?= $config["url"] ?>signup.php">Don't have an account but an invite?</a></p>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include("parts/footer.php"); ?>
