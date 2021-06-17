<?php
require "pdo.php";
session_start();

//if (!isset($_GET['auto_id'])) {
//    $_SESSION['error'] = "Missing auto_id";
//    header('Location: index.php');
//    return;
//}

if (isset($_POST['cancel'])) {
    header('Location: index.php');
    return;
}

if (isset($_POST['make']) && isset($_POST['model']) && isset($_POST['year']) && isset($_POST['mileage']) && isset($_POST['auto_id'])) {

    $make = htmlentities($_POST['make']);
    $model = htmlentities($_POST['model']);
    $year = htmlentities($_POST['year']);
    $mileage = htmlentities($_POST['mileage']);
    $auto_id = $_POST['auto_id'];

    if ((strlen($make) < 1) || (strlen($model) < 1) || (strlen($year) < 1) || (strlen($mileage) < 1)) {
        $_SESSION['error'] = "All fields are required";
        header("Location: edit.php?auto_id=$auto_id");
        return;
    } elseif (!is_numeric($year)) {
        $_SESSION['error'] = "Year must be numeric";
        header("Location: edit.php?auto_id=$auto_id");
        return;
    } elseif (!is_numeric($mileage)) {
        $_SESSION['error'] = "Mileage must be numeric";
        header("Location: edit.php?auto_id=$auto_id");
        return;
    } else {

        $sql = "UPDATE autos SET make = :make, model = :model, year = :year, mileage = :mileage WHERE auto_id = :auto_id";

        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':make' => $make,
            ':model' => $model,
            ':year' => $year,
            ':mileage' => $mileage,
            ':auto_id' => $auto_id));

        $_SESSION['success'] = 'Record edited';
        header("Location: index.php");
        return;
    }
}

$stmt = $pdo->prepare("SELECT * FROM autos where auto_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['auto_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);


$ma = htmlentities($row['make']);
$mo = htmlentities($row['model']);
$y = htmlentities($row['year']);
$mi = htmlentities($row['mileage']);
$auto_id = $row['auto_id'];
?>

<!DOCTYPE html>
<html lang="">
<head>
    <title>Automobile Tracker</title>
</head>
<body>
<div class="container">
    <h1>Editing Automobile</h1>

    <?php
    if (isset($_SESSION['error'])) {
        echo('<p style="color: red;">' . htmlentities($_SESSION['error']) . "</p>\n");
        unset($_SESSION['error']);
    }
    ?>

    <form method="post">
        <p>Make:
            <input type="text" name="make" value="<?= $ma ?>" size="40"/></p>
        <p>Model:
            <input type="text" name="model" value="<?= $mo ?>" size="40"/></p>
        <p>Year:
            <input type="text" name="year" value="<?= $y ?>" size="10"/></p>
        <p>Mileage:
            <input type="text" name="mileage" value="<?= $mi ?>" size="10"/></p>
        <input type="hidden" name="auto_id" value="<?= $auto_id ?>">
        <input type="submit" value="Save">
        <a href="index.php">Cancel</a>
    </form>
    <p>
</div>
</body>
</html>
