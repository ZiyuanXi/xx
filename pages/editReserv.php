<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php
    $reservID = $_GET['reservid'];
    $getReserv = $db->run("SELECT * FROM reserveringen WHERE ID = ?", [$reservID]);
    ?>

    <title>Reservering Nr: <?php echo $reservID; ?></title>
</head>

<body>
    <?php
    if ($getReserv->rowCount() > 0) {
        while ($fetch_reserv = $getReserv->fetch(PDO::FETCH_ASSOC)) {
            $getNaamKlant = $db->run('SELECT Naam FROM klanten WHERE ID = ? LIMIT 1', [$fetch_reserv['Klant_ID']])->fetch(PDO::FETCH_ASSOC);
            foreach ($getNaamKlant as $fetch_Klant_Naam) {
                $KlantNaam = $fetch_Klant_Naam;
            }
            $getTelefoonKlant = $db->run('SELECT Telefoon FROM klanten WHERE ID = ? LIMIT 1', [$fetch_reserv['Klant_ID']])->fetch(PDO::FETCH_ASSOC);
            foreach ($getTelefoonKlant as $fetch_Klant_Tele) {
                $KlantTelefoon = $fetch_Klant_Tele;
            }
            
    ?>
            <div class="content">
                <form method="POST" action="index.php?page=editReserv&reservid=<?php echo $reservID; ?>">
                    <h5>Reservering bewerken</h5>
                    <br>
                    <p class="listInfo">Reserveringnummer: <?php echo $fetch_reserv['ID']; ?></p>
                    <label for="date">Datum</label>
                    <input type="date" required name="datum" value="<?= $fetch_reserv['Datum']; ?>" />
                    <br>
                    <label for="tijd">Tijd</label>
                    <input type="time" name="tijd" min="09:00" max="20:00" required value="<?= $fetch_reserv['Tijd']; ?>">
                    <br>
                    <label for="tafel">Tafel</label>
                    <input type="number" required name="tafel" value="<?= $fetch_reserv['Tafel']; ?>" />
                    <br>
                    <label for="aantal">Aantal</label>
                    <input type="number" name="aantal" value="<?= $fetch_reserv['Aantal']; ?>" />
                    <br>
                    <label for="klantnaam">Klantnaam</label>
                    <input type="text" required name="klantnaam" value="<?= $KlantNaam; ?>"/>
                    <br>
                    
                    <label for="allergieen">Allergieen</label>
                    <input type="text" name="allergieen" value="<?= $fetch_reserv['Allergieen']; ?>"/>
                    <br>
                    <label for="opmerkingen">Opmerkingen</label>
                    <input type="text" name="opmerkingen" value="<?= $fetch_reserv['Opmerkingen']; ?>"/>
                    <br>
                    <p class="listInfo">Klantnummer: <?php echo $fetch_reserv['Klant_ID']; ?> <a href="index.php?page=editKlant&klantId=<?= $fetch_reserv['Klant_ID'] ?>">Klant gegevens bewerken</a></p>

                    <input type="submit" class="icon" id="submit" name="bewerken" value="Reservering bijwerken" />
                    <input type="submit" class="icon" id="submit" name="deleten" value="Reservering verwijderen" />
                    <a href="index.php?page=Reservering">Terug naar overzicht</a>
                </form>
            </div>
    <?php
        }
    } else {
        echo '<p class="empty">Er zijn geen reservering</p>';
    }
    ?>
</body>
<?php
if (isset($_POST['bewerken'])) {
    $newDatum = htmlspecialchars($_POST['datum']);
    $newTafel = htmlspecialchars($_POST['tafel']);
    $newTijd = htmlspecialchars($_POST['tijd']);
    $newAantal = htmlspecialchars($_POST['aantal']);

    $updateReservSql = "UPDATE reserveringen SET Tafel =:Tafel, Datum =:Datum, Tijd =:Tijd, Aantal =:Aantal, Status =:Status WHERE ID =:ID";
    $updateReserv = $db->run($updateReservSql, [
        'Tafel' => $newTafel,
        'Datum' => $newDatum,
        'Tijd' => $newTijd,
        'Aantal' => $newAantal,
        'ID' => $reservID
    ]);



    if ($updateReserv) {
        // echo $query;
        echo "<script>alert('Reservering is geupdate');
                        location.href='index.php?page=reservOverzicht';</script>";
    } else {
        echo "<script>alert('Kan geen profiel updaten');
                        location.href='index.php?page=reservOverzicht';</script>";
    }
}
if (isset($_POST["deleten"])) {

    $deleteSql = "DELETE FROM Reserveringen WHERE ID =$reservID";
    $delete = $db->run($deleteSql);
    $melding = "Reservering verwijdert.";
    if ($delete) {
        echo "<div id='melding'>
                <script type='text/javascript'>
                    alert('$melding');
                    location.href='index.php?page=Reservering';
                </script>
            </div>";
    }
}
?>

</html>