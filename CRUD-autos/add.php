<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>add auto</title>
</head>

<?php
if (!isset($_SESSION["name"])) {
    die('ACCESS DENIED');
}

require "pdo.php";


// If the user requested logout go back to index.php
if (isset($_POST['cancel'])) {
    header('Location: index.php');
    return;
}

if (isset($_POST['make']) && isset($_POST['model']) && isset($_POST['year']) && isset($_POST['mileage'])) {

    $make = htmlentities($_POST['make']);
    $model = htmlentities($_POST['model']);
    $year = htmlentities($_POST['year']);
    $mileage = htmlentities($_POST['mileage']);


    if ((strlen($make) < 1) || (strlen($model) < 1) || (strlen($year) < 1) || (strlen($mileage) < 1)) {
        $_SESSION['error'] = "All fields are required";
        header("Location: add.php");
        return;

    } elseif (!is_numeric($year)) {
        $_SESSION['error'] = "Year must be an integer";
        header("Location: add.php");
        return;
    } elseif (!is_numeric($mileage)) {
        $_SESSION['error'] = "Mileage must be integer";
        header("Location: add.php");
        return;
    } else {
        $sql = "INSERT INTO autos (make, model, year, mileage) 
              VALUES (:make, :model, :year, :mileage)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':make' => $make,
            ':model' => $model,
            ':year' => $year,
            ':mileage' => $mileage));

        $_SESSION["success"] = "Record added.";
        header("Location: index.php");
        return;
    }
}

?>
<body>
<div>
    <h1>Tracking Automobiles for <?= $_SESSION["name"] ?></h1>

    <?php
    if (isset($_SESSION['error'])) {
        echo('<p style="color: red;">' . htmlentities($_SESSION['error']) . "</p>\n");
        unset($_SESSION['error']);
    }
    ?>

    <form method="post">
        <p>Make:
            <input type="text" name="make" size="40"/></p>
        <p>Model:
            <input type="text" name="model" size="40"/></p>
        <p>Year:
            <input type="text" name="year" size="10"/></p>
        <p>Mileage:
            <input type="text" name="mileage" size="10"/></p>
        <input type="submit" name='add' value="Add">
        <input type="submit" name="cancel" value="Cancel">
    </form>
    <p>
</div>
</body>
</html>
