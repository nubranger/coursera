<!DOCTYPE html>
<html lang="en">
<head>
    <title>MD5 Cracker</title>
</head>
<body>
<h1>MD5 cracker</h1>
<p>This application takes an MD5 hash of a four digit pin and check all 10,000 possible four digit PINs to determine the
    PIN.</p>

<pre>
Debug Output:
<?php
$goodtext = "Not found";
if (isset($_GET['md5'])) {
    $time_pre = microtime(true);
    $md5 = $_GET['md5'];

    $txt = "0123456789AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz";
    $show = 15;

    for ($a = 0; $a < strlen($txt); $a++) {
        $ch1 = $txt[$a];

        for ($b = 0; $b < strlen($txt); $b++) {
            $ch2 = $txt[$b];

            for ($c = 0; $c < strlen($txt); $c++) {
                $ch3 = $txt[$c];

                for ($d = 0; $d < strlen($txt); $d++) {
                    $ch4 = $txt[$d];

                    $try = $ch1 . $ch2 . $ch3 . $ch4;

                    $check = hash('md5', $try);
                    if ($check == $md5) {
                        $goodtext = $try;
                        break;
                    }

                    if ($show > 0) {
                        print "$check $try\n";
                        $show = $show - 1;
                    }
                }
            }
        }

    }
    $time_post = microtime(true);
    echo "<br>";
    print "Elapsed time: ";
    print $time_post - $time_pre;
    print "\n";
    echo "<hr>";
}
?>
</pre>

<p>PIN: <?= htmlentities($goodtext); ?></p>
<form>
    <input type="text" name="md5" size="60"/>
    <input type="submit" value="Crack MD5"/>
</form>
<ul>
    <li><a href="index.php">Reset</a></li>
    <li><a href="md5.php">MD5 Encoder</a></li>
</ul>
</body>
</html>

