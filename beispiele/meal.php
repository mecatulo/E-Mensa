<?php
const GET_PARAM_MIN_STARS = 'search_min_stars';
const GET_PARAM_SEARCH_TEXT = 'search_text';
const GET_PARAM_SHOW_DESCRIPTION = 'show_description';
$language = (isset($_GET['sprache']) ? $_GET['sprache'] : null);

/**
 * Liste aller möglichen Allergene.
 */
$allergens = array(
    11 => 'Gluten',
    12 => 'Krebstiere',
    13 => 'Eier',
    14 => 'Fisch',
    17 => 'Milch')
;

$meal = [ // Kurzschreibweise für ein Array (entspricht = array())
    'name' => 'Süßkartoffeltaschen mit Frischkäse und Kräutern gefüllt',
    'description' => 'Die Süßkartoffeln werden vorsichtig aufgeschnitten und der Frischkäse eingefüllt.',
    'price_intern' => 2.90,
    'price_extern' => 3.90,
    'allergens' => [11, 13],
    'amount' => 42   // Anzahl der verfügbaren Gerichte.
];

$ratings = [
    [   'text' => 'Die Kartoffel ist einfach klasse. Nur die Fischstäbchen schmecken nach Käse. ',
        'author' => 'Ute U.',
        'stars' => 2 ],
    [   'text' => 'Sehr gut. Immer wieder gerne',
        'author' => 'Gustav G.',
        'stars' => 4 ],
    [   'text' => 'Der Klassiker für den Wochenstart. Frisch wie immer',
        'author' => 'Renate R.',
        'stars' => 4 ],
    [   'text' => 'Kartoffel ist gut. Das Grüne ist mir suspekt.',
        'author' => 'Marta M.',
        'stars' => 3 ]
];

$showRatings = [];
if (!empty($_GET[GET_PARAM_SEARCH_TEXT])) {
    $searchTerm = $_GET[GET_PARAM_SEARCH_TEXT];
    foreach ($ratings as $rating) {
        if (stripos($rating['text'], $searchTerm) !== false) {
            $showRatings[] = $rating;
        }
    }
} else if (!empty($_GET[GET_PARAM_MIN_STARS])) {
    $minStars = $_GET[GET_PARAM_MIN_STARS];
    foreach ($ratings as $rating) {
        if ($rating['stars'] >= $minStars) {
            $showRatings[] = $rating;
        }
    }
} else {
    $showRatings = $ratings;
}

function calcMeanStars($ratings) : float { // : float gibt an, dass der Rückgabewert vom Typ "float" ist
    $sum = 0; //war 1
    //$i = 1;
    foreach ($ratings as $rating) {
        $sum += $rating['stars']; // / $i;
        //$i++;
    }
    return $sum / count($ratings);
}

?>
<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="UTF-8"/>
        <title><?php if($language == "de") {
                echo "Gericht: ";
            }
            elseif ($language == "en") {
                echo "Meal: ";
            }
            else {
                echo "Meal: ";
            }
            echo $meal['name']; ?></title>
        <style type="text/css">
            * {
                font-family: Arial, serif;
            }
            .rating {
                color: darkgray;
            }
        </style>
    </head>
    <body>
        <h1><?php if($language == "de") {
                echo "Gericht: ";
            }
            elseif ($language == "en") {
                echo "Meal: ";
            }
            else {
                echo "Meal: ";
            }
            echo $meal['name']; ?></h1>
        <?php
            if($_GET[GET_PARAM_SHOW_DESCRIPTION] == "true") {
                echo "<p>", $meal['description'], "</p>";
            }
            ?>
        <?php if($language == "de") {
            echo "Allergene: ";
        }
        elseif ($language == "en") {
            echo "Allergens: ";
        }
        else {
            echo "Allergens: ";
        }?>
        <ul>
            <?php foreach($meal['allergens'] as $key) {
                echo "<li>", $allergens[$key], "</li>";
            } ?>
        </ul>
        <?php if($language == "de") {
            echo "Preis: ";
        }
        elseif ($language == "en") {
            echo "Price: ";
        }
        else {
            echo "Price: ";
        }
        echo number_format($meal['price_extern'], 2), "€"; ?>
        <h1><?php
            if($language == "de") {
                echo "Bewertungen (Insgesamt: ";
            }
            elseif ($language == "en") {
                echo "Reviews (total: ";
            }
            else {
                echo "Reviews (total: ";
            }
            echo calcMeanStars($ratings); ?>)</h1>
        <form method="get">
            <label for="search_text">Filter:</label>
            <input id="search_text" type="text" name="search_text" value=<?php echo $_GET[GET_PARAM_SEARCH_TEXT]?>>
            <input id="show_description" type="hidden" name="show_description" value="true">
            <input type="submit" value=<?php if($language == "de") {
                echo "Suchen";
            }
            elseif ($language == "en") {
                echo "Search";
            }
            else {
                echo "Search";
            } ?>>
        </form>
        <table class="rating">
            <thead>
            <tr>
                <td>Author</td>
                <td>Text</td>
                <td><?php if($language == "de") {
                    echo "Sterne";
                    }
                    elseif ($language == "en") {
                    echo "Stars";
                    }
                    else {
                    echo "Stars";
                    } ?></td>
            </tr>
            </thead>
            <tbody>
            <?php
        foreach ($showRatings as $rating) {
            echo "<tr><td class='rating_author'>{$rating['author']}</td>
                      <td class='rating_text'>{$rating['text']}</td>
                      <td class='rating_stars'>{$rating['stars']}</td>
                  </tr>";
        }
        ?>
            </tbody>
        </table>
        <a href="meal.php?sprache=de">Deutsch</a>
        <a href="meal.php?sprache=en">English</a>
    </body>
</html>