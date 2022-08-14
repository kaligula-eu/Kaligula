<?php

require("requires.php");

$page = "signup";

check("logged", "signup");

$error = false;
$error_msg = "";

if(isset($_POST["signup"])) {
    $username = clean(mysqli_real_escape_string($conn, $_POST["username"]));
    $password1 = clean(mysqli_real_escape_string($conn, $_POST["password"]));
    $password2 = clean(mysqli_real_escape_string($conn, $_POST["password2"]));
    $invite = clean(mysqli_real_escape_string($conn, $_POST["invite"]));
    $invitecheck = $conn->query("SELECT * FROM `invites` WHERE `token`='$invite' LIMIT 1");
    $usercheck = $conn->query("SELECT * FROM `user` WHERE `username`='$username' LIMIT 1");
    
    // Executing all the checks
    
    if(empty($invite)) {
        $error = true;
        $error_msg = "Invite is needed.";
    }
    if(mysqli_num_rows($invitecheck)==1) {
        $inv = mysqli_fetch_assoc($invitecheck);
        if(!empty($inv["used"])) {
            $error = true;
            $error_msg = "Invite already used.";
        }
    } else {
        $error = true;
        $error_msg = "Invalid Invite.";
    }
    if(mysqli_num_rows($usercheck)==1) {
        $error = true;
        $error_msg = "Username already taken.";
    }
    if($password1!=$password2) {
        $error = true;
        $error_msg = "Passwords don't match.";
    }
    
    // Everything is right?!
    
    if($error==false) {
        // Everything is right!
        $password = password_hash($password1, PASSWORD_BCRYPT);
        $conn->query("UPDATE `invites` SET `used`='1' WHERE `token`='$invite'");
        $conn->query("INSERT INTO `user`(`username`,`password`) VALUES('$username','$password')");
        header("Location: ./login.php");
    }
}

$user["theme"] = 3;

include("parts/header.php");

?>

<title>Signup | <?= $config["title"] ?></title>

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
                            <?php if($config["registration"]==true) { ?>
                            <form accept-charset="UTF-8" role="form" method="post" name="signup">
                                <fieldset>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Username" name="username" type="text">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Repeat Password" name="password2" type="password" value="">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Invite" name="invite" type="text" value="">
                                    </div>
                                    <button class="btn btn-lg btn-success btn-block" type="submit" name="signup"><?= glyph("user-plus", "Signup", "flip") ?> Signup</button>
                                </fieldset>
                            </form>
                            <?php } else { ?>
                            <p style="color:red">Registrations are disabled at the moment. Please check back later.</p>
                            <?php } ?>
                            <hr>
                            <center>
                                <p><a href="<?= $config["url"] ?>login.php">Already have an account?</a></p>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include("parts/footer.php"); ?>
