<!--
- Praktikum DBWT. Autoren:
- Marco, Catulo, 3124518
- Shafiq, Azam, 3241745
-->
<?php
    $meals = [
        [   'name' => "Rindfleisch mit Bambus, Kaiserschoten und rotem Paprika, dazu Mie Nudeln",
            'preis_intern' => "3.50",
            'preis_extern' => "6.20",
            'img' => "./img/meal0.jpg"],
        [   'name' => "Spinatrisotto mit kleinen Samosateigecken und gemischter Salat",
            'preis_intern' => "2.90",
            'preis_extern' => "5.30",
            'img' => "./img/meal1.jpg"],
        [   'name' => "Pizza mit Thunfisch und Oliven",
            'preis_intern' => "4.00",
            'preis_extern' => "7.50",
            'img' => "./img/meal2.jpg"],
        [   'name' => "Lachsfillet mit Kartoffelbrei und Erbsen",
            'preis_intern' => "3.50",
            'preis_extern' => "6.50",
            'img' => "./img/meal3.jpg"]
    ];

    file_put_contents('./meals.txt', serialize($meals));

    $meals = unserialize(file_get_contents('./meals.txt'));

    function checkName() {
        if(empty(trim($_POST['user']))) {
            return false;
        }
        return true;
    }

    function checkEmail() {
        if(empty($_POST['email'])) {
            return false;
        }
        else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        return true;
    }

    function getDomain($email) {
        $arr = explode('@', $email);
        return $arr[1];
    }

    function emailBlacklist() {
        $blacklist = [
            'rcpt.at',
            'damnthespam.at',
            'wegwerfemail.de',
            'trashmail.de',
            'trashmail.com'
        ];

        if (in_array(getDomain($_POST['email']), $blacklist)) {
            return true;
        }
        return false;
    }

    function checkForm() {
        if(isset($_POST['datenschutz']) and isset($_POST['language']) and isset($_POST['user']) and isset($_POST['email'])) {
            if(checkName()) {
                if(checkEmail()){
                    if(emailBlacklist()) {
                        echo "<p style = 'color: red'>Email ist Teil der Blacklist.</p>";
                    }
                    else {
                        $file = fopen('./newsletteranmeldungen.txt', 'a');
                        fwrite($file, $_POST['user']."; ".$_POST['email']."; ".$_POST['language'].PHP_EOL);
                        fclose($file);
                        echo "<p style='color: green'>Erfolgreich zum Newsletter angemeldet.</p>";
                    }
                }
                else {
                    echo "<p style = 'color: red'>Ungültige E-Mail Addresse.</p>";
                }
            }
            else {
                echo "<p style = 'color: red'>Name darf nicht leer sein.</p>";
            }
        }
        else {
            echo "<p style = 'color: red'>Den Datenschutzbestimmungen muss zugestimmt sein.</p>";
        }
    }
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Ihre E-Mensa</title>
    <link rel="stylesheet" href="index-stylesheet.css" media="screen">
    <link rel="icon" href="./img/favicon-96x96.png">
</head>
<body>
    <div class="grid-container">
        <div class="header">
            <div id="logo">
                <img src="./img/E_Mensa_logo.jpg" alt="E-Mensa Logo">
            </div>
            <div id="navigation">
                <ul>
                    <li><a href="#Ankündigungen">Ankündigung</a></li>
                    <li><a href="#Speisekarte">Speisen</a></li>
                    <li><a href="#Statistik">Zahlen</a></li>
                    <li><a href="#form">Kontakt</a></li>
                    <li><a href="#Wichtig">Wichtig für uns</a></li>
                </ul>
            </div>
        </div>
        <div class="body">
            <div id="left"></div>
            <div id="center">
                <div id="banner">
                    <img src="./img/banner.jpg" alt="banner" width="500" height="500">
                </div>
                <div id="Ankündigungen">
                    <h2>Bald gibt es Essen auch online ;)</h2>
                    <p>
                        Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut
                        labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores
                        et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.
                        Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut
                        labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores
                        et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.
                    </p>
                </div>
                <div id="Speisekarte">
                    <h2>Köstlichkeiten, die Sie erwarten</h2>
                    <table>
                        <thead>
                        <tr>
                            <th></th>
                            <th>Preis intern</th>
                            <th>Preis extern</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach($meals as $key) {
                            echo "<tr>\n";
                            foreach($key as $value => $data) {
                                if($value == 'img') {
                                    echo "<td><img src='$data' alt='mealImg'></td>\n";
                                }
                                else {
                                    echo "<td>" . $data . "</td>\n";
                                }
                            }
                            echo "</tr>\n";
                        } ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>...</th>
                            <th>...</th>
                            <th>...</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                <div id="Statistik">
                    <h2>E-Mensa in Zahlen</h2>
                    <ul>
                        <li><?php
                            $handle = fopen("counter.txt", "r");
                            if(!$handle) {
                                echo "???";
                            } else {
                                $counter = (int) fread($handle,20);
                                fclose($handle);
                                $counter++;
                                echo $counter;
                                $handle = fopen("counter.txt", "w");
                                fwrite($handle, $counter);
                                fclose($handle);
                            }
                            ?></li>
                        <li>Besuche</li>
                        <li><?php
                            $handle = fopen("newsletteranmeldungen.txt", "r");
                            if(!$handle) {
                                echo "???";
                            } else {
                                $linecount = 0;
                                while (!feof($handle)) {
                                    $file = fgets($handle);
                                    $linecount++;
                                }
                                fclose($handle);
                                echo $linecount-1;
                            }
                            ?></li>
                        <li>Anmeldungen zum Newsletter</li>
                        <li><?php
                            echo count($meals);
                            ?></li>
                        <li>Speisen</li>
                    </ul>
                </div>
                <div id="form">
                    <h2>Interesse geweckt? Wir informieren Sie!</h2>
                    <form id="newsletteranmeldung" method="post"><!--action="index.php"-->
                        <label for="name">Ihr Name:<br>
                            <input type="text" id="name" name="user" placeholder="Vorname" required>
                        </label>
                        <label for="email">Ihre E-Mail:<br>
                            <input type="text" id="email" name="email" placeholder="" required>
                        </label>
                        <label for="language">Newsletter bitte in:<br>
                            <select id="language" name="language">
                                <option value="de" selected>Deutsch</option>
                                <option value="en">English</option>
                            </select>
                        </label><br>
                        <label for="datenschutz">
                            <input type="checkbox" id="datenschutz" name="datenschutz" required>
                            Den Datenschutzbestimmungen stimme ich zu
                        </label>
                        <input type="submit" id="submit" value="Zum Newsletter anmelden"><!--disabled-->
                        <?php echo '<br>'.checkForm(); ?>
                    </form>
                </div>
                <div id="Wichtig">
                    <h2>Das ist uns wichtig</h2>
                    <ul>
                        <li>Beste frische saisonale Zutaten</li>
                        <li>Ausgewogene abwechslungsreiche Gerichte</li>
                        <li>Sauberkeit</li>
                    </ul>
                </div>
                <div>
                    <h1>Wir freuen uns auf Ihren Besuch!</h1>
                </div>
            </div>
            <div id="right"></div>
        </div>
        <div class="footer">
            <ul>
                <li>&copy; E-Mensa GmbH</li>
                <li>Marco Catulo</li>
                <li>Shafiq Azam</li>
                <li><a href="impressum.html">Impressum</a></li>
            </ul>
        </div>
    </div>
</body>
</html>