<?php
/**
 * Praktikum DBWT. Authoren:
 * Marco, Ermes Catulo, 3124518
 * Shafiq, Azam, 3241745
 */
?>

<!DOCTYPE html>
<html lang="de">
<head>
<title>4c</title>
</head>
<body>
    <form method="get">
        <label for="parameter_a">a:</label>
        <input id="parameter_a" type="text" name="parameter_a"><br>
        <label for="parameter_b">b:</label>
        <input id="parameter_b" type="text" name="parameter_b"><br>
        <input type="submit" value="addieren" name="form">
        <input type="submit" value="multiplizieren" name="form"><br>
        </form>
    <?php
    if($_GET['form'] == "addieren") {
        echo ($_GET['parameter_a'] + $_GET['parameter_b']);
    }
    else if($_GET['form'] == "multiplizieren") {
        echo ($_GET['parameter_a'] * $_GET['parameter_b']);
    }
    ?>
</body>
</html>