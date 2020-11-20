<?php
 $sort = $_GET['sort'];
 $file = file("./newsletteranmeldungen.txt");
 $table = [];
 $i = 0;
 foreach($file as $key) {
     $table[$i] = explode("; ", $file[$i]);
     $i++;
 }

 foreach ($table as $key => $row) {
     $name[$key] = $row[0];
     $mail[$key] = $row[1];
 }
 if($sort == "Sortiere nach Namen") {
     array_multisort($name, SORT_ASC, $table);
 }
 elseif ($sort == "Sortiere nach Email") {
     array_multisort($mail, SORT_ASC, $table);
 }

 $filter = [];
 if (!empty($_GET['search_text'])) {
    $searchTerm = $_GET['search_text'];
    foreach ($table as $key) {
        if (stripos($key[0], $searchTerm) !== false) {
            $filter[] = $key;
        }
    }
 }
 else {
     $filter = $table;
 }
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>nl-admin</title>
</head>
<body>
    <table>
        <tr>
            <th>Name</th>
            <th>E-Mail</th>
            <th>Sprache</th>
        </tr>
        <?php
        foreach($filter as $key) {
            echo "<tr>\n";
            foreach($key as $value => $data) {
                echo "<td>" . $data . "</td>\n";
            }
            echo "</tr>\n";
        } ?>
    </table>
    <form id="sort" method="get">
        <input type="submit" id="name" value="Sortiere nach Namen" name="sort">
        <input type="submit" id="mail" value="Sortiere nach Email" name="sort">
    </form>
    <form id="filter" method="get">
        <label for="search_text">Filter:</label>
        <input id="search_text" type="text" name="search_text" value=<?php echo $_GET['search_text']?>>
        <input id="show_description" type="hidden" name="show_description" value="true">
        <input type="submit" value="Suche">
    </form>
</body>
</html>
