<?php
/**
 * Praktikum DBWT. Authoren:
 * Marco, Ermes Catulo, 3124518
 * Shafiq, Azam, 3241745
 */

$famousMeals = [
    1 => ['name' => 'Currywurst mit Pommes', 'winner' => [2001, 2003, 2007, 2010, 2020]],
    2 => ['name' => 'Hähnchencrossies mit Paprikareis', 'winner' => [2002, 2004, 2008]],
    3 => ['name' => 'Spaghetti Bolognese', 'winner' => [2011, 2012, 2017]],
    4 => ['name' => 'Jägerschnitzel mit Pommes', 'winner' => 2019],
];

function getWinner($arr) {
    $winner = array();
    for($i = 2000; $i <= 2020; $i++) {
        foreach($arr as $key => $value) {
            if (is_array($value['winner'])) {
                foreach($value['winner'] as $key) {
                    if ($key == $i) { array_push($winner, $key); }
                }
            }
            else {
                if ($value['winner'] == $i) { array_push($winner, $value['winner']); }
            }
        }
    }
    return $winner;
}

?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8"
    <title></title>
    <style>
        * { font-family: Arial, sans-serif; }
        li { margin-top: 0.5em; }
    </style>
</head>
<body>
<ol>
    <?php
    foreach($famousMeals as $key => $value) {
        echo "<li>", $value['name'], "</li>";
        if (is_array($value['winner'])) {
            echo implode(', ', $value['winner']), "<br>\n";
        }
        else {
            echo $value['winner'], "<br>\n";
        }
    }
    ?>
</ol>

<?php
$win = getWinner($famousMeals);
for($i = 2000; $i <= 2020; $i++) {
    if(!in_array($i, $win)) {
        echo $i, "<br>\n";
    }
}
?>
</body>
</html>
