<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php
    $klantId = $_GET['klantId'];
    $getKlant = $db->run('SELECT * FROM klanten WHERE ID = ?', [$klantId]);
    ?>

    <title>Klant Nr: <?php echo $klantId; ?></title>
</head>

<body>
    <?php
    if ($getKlant->rowCount() > 0) {
        while ($fetch_klant = $getKlant->fetch(PDO::FETCH_ASSOC)) {
            $klantId = $fetch_klant['ID'];
    ?>
            <div class="content">
                <form method="POST" action="index.php?page=editKlant&klantId=<?php echo $klantId; ?>">
                    <h5>Klant gegevens bewerken</h5>
                    <br>
                    <p class="reservering">Klantnummer: <?= $klantId; ?></p>
                    <label for="naam">Naam</label>
                    <input type="text" required name="naam" value="<?= $fetch_klant['Naam']; ?>" />
                    <br>
                    <label for="telefoonnummer">Telefoonnummer</label>
                    <input type="number" required name="telefoonnummer" value="<?= $fetch_klant['Telefoon']; ?>" />
                    <br>
                    <label for="email">Email</label>
                    <input type="email" name="email" value="<?= $fetch_klant['Email']; ?>" />
                    <br>
                    <input type="submit" class="icon" id="submit" name="bewerken" value="Gegevens bijwerken" />
                    <input type="submit" class="icon" id="submit" name="deleten" value="Gegevens verwijderen" />
                    <a href="index.php?page=Klanten">Terug naar overzicht</a>
                </form>
            </div>
    <?php
        }
    } else {
        echo '<p class="empty">Er zijn geen klant gegevens gevonden</p>';
    }
    ?>
</body>
<?php
if (isset($_POST['bewerken'])) {
    $newNaam = htmlspecialchars($_POST['naam']);
    $newTelefoon = htmlspecialchars($_POST['telefoonnummer']);
    $newEmail = htmlspecialchars($_POST['email']);

    $updateKlantSql = "UPDATE klanten SET Naam =:Naam, Telefoon =:Telefoon, Email =:Email WHERE ID =$klantId";
    $updateKlant = $db->run($updateKlantSql, [
        'Naam' => $newNaam,
        'Telefoon' => $newTelefoon,
        'Email' => $newEmail
    ]);



    if ($updateKlant) {
        // echo $query;
        echo "<script>alert('Klant gegevens is geupdate');
                        location.href='index.php?page=Klanten';</script>";
    } else {
        echo "<script>alert('Kan geen gegevens updaten');
                        location.href='index.php?page=Klanten';</script>";
    }
}
?>

</html>