<!DOCTYPE html>
<html lang="nl">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title>Nieuw gerecht sub groep</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body>
    <div class="content">
        <form method="POST">
            <h4>Nieuw Sub groep egevens invoeren</h4>
            <label for="code">Code: </label>
            <input type="text" required name="code" />
            <br>
            <label for="naam">Naam: </label>
            <input type="text" required name="naam" />
            <br>
            <label for="cato">Valt onder: </label>
            <input list="cato" required name="cato">
            <datalist id="cato">
                <option value="Hapjes">
                <option value="Dranken">
                <option value="Voorgerechten">
                <option value="Hoofdgerechten">
                <option value="Nagerechten">
            </datalist>
            <br>
            <input type="submit" class="icon" id="submit" name="Invoeren" value="Invoeren" />
            <a href="index.php?page=GerechtSubgroep">Terug naar overzicht</a>
        </form>
    </div>
</body>
<?php
if (isset($_POST["Invoeren"])) {

    $code = htmlspecialchars($_POST['code']);
    $naam = htmlspecialchars($_POST['naam']);
    $cato = htmlspecialchars($_POST['cato']);

    $checkCode = $db->run("SELECT * FROM gerechtsoorten WHERE Code = ?", [$code])->fetch(PDO::FETCH_ASSOC);
    $checkNaam = $db->run("SELECT * FROM gerechtsoorten WHERE Naam = ?", [$naam])->fetch(PDO::FETCH_ASSOC);
    $getCato = $db->run("SELECT ID FROM gerechtcategorien WHERE Naam = ? LIMIT 1", [$cato])->fetch(PDO::FETCH_ASSOC);
    foreach ($getCato as $fetch_Cato) {
        $CatoID = $fetch_Cato;
    }

    //Check of code of naam al bestaat
    if (!$checkCode && !$checkNaam) {
        $sql = "INSERT INTO gerechtsoorten (ID,
        Code, Naam, Gerechtcategorie_ID) VALUE (null, ?, ?, ?)";
        $inschrijven = $db->run($sql, array(
            $code,
            $naam,
            $CatoID
        ));
        $melding = "Gegevens ingevoerd";
    } elseif ($checkCode || $checkNaam) {
        $melding = "Code of naam wordt al gebruikt";
    }
    echo "<div id='melding'><script type='text/javascript'>alert('$melding');</script></div>";
}
?>

</html>