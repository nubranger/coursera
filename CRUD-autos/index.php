<?php
session_start();
require_once "pdo.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Index Page</title>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4"
            crossorigin="anonymous">

    </script>


    <style>
        table, th, td {
            border: 1px solid black;
        }
    </style>

</head>
<body>
<div class="container">
    <h2>Welcome to the Automobiles Database</h2>

    <?php

    if (!isset($_SESSION["name"])) {
        ?>
        <p><a href="login.php">Please log in</a></p>
        <p>Attempt to <a href="add.php">add data</a> without logging in</p>
        <?php
    } elseif ((isset($_SESSION["name"]) && ($_SESSION["name"] !== ""))) {

    if (isset($_SESSION['success'])) {
        echo('<p style="color: green;">' . htmlentities($_SESSION['success']) . "</p>\n");
        unset($_SESSION['success']);
    }
    ?>

    <?php
    $stmt = $pdo->query("SELECT * FROM autos");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row === false) {
        echo "<p>No rows found</p>";
    } else {

        echo('<table>');
        echo "<thead><tr>
<th>Make</th>
<th>Model</th>
<th>Year</th>
<th>Mileage</th>
<th>Action</th>
</tr></thead>";
        $stmt = $pdo->query("SELECT * FROM autos");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr><td>";
            echo(htmlentities($row['make']));
            echo("</td><td>");
            echo(htmlentities($row['model']));
            echo("</td><td>");
            echo(htmlentities($row['year']));
            echo("</td><td>");
            echo(htmlentities($row['mileage']));
            echo("</td><td>");
            echo('<a href="edit.php?auto_id=' . $row['auto_id'] . '">Edit</a> / ');
            echo('<a href="delete.php?auto_id=' . $row['auto_id'] . '">Delete</a>');
            echo("</td></tr>\n");
        }
        ?>
        </table>
        <?php
    }
    ?>


    <p><a href="add.php">Add New Entry</a></p>
    <p><a href="logout.php">Logout</a></p>
</div>
</body>
</html>
<?php
} else {
    header("Location: login.php");
}
?>

