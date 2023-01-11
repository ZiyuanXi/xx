<!DOCTYPE html>
<html lang="nl">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title>Nieuw gerechtcategorie</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body>
    <div class="content">
        <form name="Reserveren" class="form" method="POST">
            <h4>Nieuw groep gegevens invoeren</h4>
            <label for="code">Code voor de categorie: </label>
            <input type="text" required name="code" />
            <br>
            <label for="naam">Naam voor de categorie: </label>
            <input type="text" required name="naam" />
            <br>
            <input type="submit" class="icon" id="submit" name="Invoeren" value="Invoeren" />
            <a href="index.php?page=GerechtHoofdgroep">Terug naar overzicht</a>
        </form>
    </div>
</body>
<?php
if (isset($_POST["Invoeren"])) {

    $code = htmlspecialchars($_POST['code']);
    $naam = htmlspecialchars($_POST['naam']);

    $checkCode = $db->run("SELECT * FROM gerechtcategorien WHERE Code = ?", [$code])->fetch(PDO::FETCH_ASSOC);
    $checkNaam = $db->run("SELECT * FROM gerechtcategorien WHERE Naam = ?", [$naam])->fetch(PDO::FETCH_ASSOC);

    //klant inschrijven op database
    if (!$checkCode && !$checkNaam) {
        $sql = "INSERT INTO gerechtcategorien (ID,
        Code, Naam) VALUE (null, ?, ?)";
        $inschrijven = $db->run($sql, array(
            $code,
            $naam
        ));
        $melding = "Gegevens ingevoerd";
    } elseif ($checkCode || $checkNaam) {
        $melding = "Code of naam wordt al gebruikt";
    }
    echo "<div id='melding'><script type='text/javascript'>alert('$melding');</script></div>";
}
?>

</html>