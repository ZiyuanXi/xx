<!DOCTYPE html>
<html lang="nl">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title>Nieuw drank</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body>
    <div class="content">
        <form name="Reserveren" class="form" method="POST">
            <h4>Drank gegevens invoeren</h4>
            <label for="code">Code: </label>
            <input type="text" required name="code" />
            <br>
            <label for="naam">Naam: </label>
            <input type="text" required name="naam" />
            <br>
            <label for="naam">Prijs: </label>
            <input type="number" step="any" required name="prijs" />
            <br>
            <label for="soort">Valt onder: </label>
            <input list="soort" name="soort">
            <datalist id="soort" name="soort">
                <option value="Frisdrank">
                <option value="Bieren">
            </datalist>
            <br>
            <input type="submit" class="icon" id="submit" name="Invoeren" value="Invoeren" />
            <a href="index.php?page=GerechtDrinken">Terug naar overzicht</a>
        </form>
    </div>
</body>
<?php
if (isset($_POST["Invoeren"])) {

    $code = htmlspecialchars($_POST['code']);
    $naam = htmlspecialchars($_POST['naam']);
    $prijs = htmlspecialchars($_POST['prijs']);
    $soort = htmlspecialchars($_POST['soort']);

    $checkCode = $db->run("SELECT * FROM menuitems WHERE Code = ?", [$code])->fetch(PDO::FETCH_ASSOC);
    $checkNaam = $db->run("SELECT * FROM menuitems WHERE Naam = ?", [$naam])->fetch(PDO::FETCH_ASSOC);
    $getSoort = $db->run("SELECT ID FROM gerechtsoorten WHERE Naam = ? LIMIT 1", [$soort])->fetch(PDO::FETCH_ASSOC);
    foreach ($getSoort as $fetch_Soort) {
        $soortID = $fetch_Soort;
    }

    //Check of code of naam al bestaat
    if (!$checkCode && !$checkNaam) {
        $sql = "INSERT INTO menuitems (ID,
        Code, Naam, Gerechtsoort_ID, Prijs) VALUE (null, ?, ?, ?,?)";
        $inschrijven = $db->run($sql, array(
            $code,
            $naam,
            $soortID,
            $prijs
        ));
        $melding = "Gegevens ingevoerd";
    } elseif ($checkCode || $checkNaam) {
        $melding = "Code of naam wordt al gebruikt";
    }
    echo "<div id='melding'><script type='text/javascript'>alert('$melding');</script></div>";
}
?>

</html>