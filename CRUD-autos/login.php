<?php
session_start();

if (isset($_POST['cancel'])) {
    header("Location: logout.php");
    return;
}

$stored_hash = '81dc9bdb52d04dc20036dbd8313ed055';  // Pw is 1234

if (isset($_POST['email']) && ($_POST['email'] != null) && isset($_POST['pass'])) {
    unset($_SESSION["name"]);

    if (strlen(htmlentities($_POST['email'])) < 1 || strlen(htmlentities($_POST['pass'])) < 1) {

        $_SESSION['error'] = "User name and password are required";
        header("Location: login.php");
        return;

    } elseif (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", htmlentities($_POST['email']))) {

        $_SESSION['error'] = "Email must have an at-sign (@)";
        header("Location: login.php");
        return;

    } else {
        $check = hash('md5', htmlentities($_POST['pass']));

        if (($check == $stored_hash) && (htmlentities($_POST['email']) === "admin@mail.com")) {
            $_SESSION['name'] = htmlentities($_POST['email']);
            header("Location: index.php");
            return;
        } else {
            $_SESSION['error'] = "Incorrect password";
            header("Location: login.php");
            return;

        }
    }
}

// Fall through into the View
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login Page</title>
</head>
<body>
<div class="container">
    <h1>Please Log In</h1>

    <?php
    if (isset($_SESSION['error'])) {
        echo('<p style="color: red;">' . htmlentities($_SESSION['error']) . "</p>\n");
        unset($_SESSION['error']);
    }
    ?>

    <form method="POST">
        User Name <input type="text" name="email"><br/>
        Password <input type="password" name="pass"><br/>
        <input type="submit" value="Log In">
        <a href="logout.php">Cancel</a>
    </form>
</div>
</body>
