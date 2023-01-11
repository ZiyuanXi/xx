<?php

include('htmlforms\reserveren.html');
$melding = "";
if (isset($_POST["Reserveren"])) {

    $datum = htmlspecialchars($_POST['datum']);
    $tijd = htmlspecialchars($_POST['tijd']);
    $tafel = htmlspecialchars($_POST['tafel']);
    $aantal = htmlspecialchars($_POST['aantal']);
    $klantnaam = htmlspecialchars($_POST['klantnaam']);
    $telefoonnummer = htmlspecialchars($_POST['telefoonnummer']);
    $email = htmlspecialchars($_POST['email']);
    $opmerkingen = htmlspecialchars($_POST['opmerkingen']);
    $allergieen = htmlspecialchars($_POST['allergieen']);
    

    $checkKlant = $db->run("SELECT * FROM klanten WHERE Telefoon = ?", [$telefoonnummer])->fetch(PDO::FETCH_ASSOC);

    //klant inschrijven op database
    if (!$checkKlant) {
        $sql = "INSERT INTO klanten (ID,
        Naam, Telefoon, Email) VALUE (null, ?, ?, ?)";
        $inschrijven = $db->run($sql, array(
            $klantnaam,
            $telefoonnummer,
            $email
        ));
    }
    $getKlant = $db->run("SELECT * FROM klanten WHERE Telefoon = ? LIMIT 1", [$telefoonnummer])->fetch(PDO::FETCH_ASSOC);
    if ($getKlant) { //na inschrijving van klant
        $klantID = $getKlant['ID'];
        $sql = "INSERT INTO reserveringen (ID, Tafel, Klant_ID, Datum, Tijd, Aantal, Allergieen, Opmerkingen) VALUE (null, ?, ?, ?, ?, ?, ?, ?)";
        $resultaat = $db->run($sql, array(
            $tafel,
            $klantID,
            $datum,
            $tijd,
            $aantal,
            $opmerkingen,
            $allergieen
        ));
        $melding = "Reservering aangemaakt.";
    } else {
        $melding = "Reservering mislukt";
    }
    //alert voor melding
echo "<div id='melding'><script type='text/javascript'>alert('$melding');</script></div>";
}

?>