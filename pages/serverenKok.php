<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overzicht voor kok</title>
</head>

<body>
    <div class="content">
        <?php
        $listMed = $db->run('SELECT * FROM Medewerkers');
        ?>
        <table id="overzicht">
            <caption style="caption-side:top">
                <h4>Overzicht van Medewerkers</h4>
            </caption>
            <thead>
                <tr>
                    <th> Medewerker nummer</th>
                    <th> Voornaam</th>
                    <th> Achternaam</th>
                    <th> Email</th>
                    <th> Account</th>
                    <th> Account status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>

                <?php
                if ($listMed->rowCount() > 0) {
                    while ($fetch_medewerkers = $listMed->fetch(PDO::FETCH_ASSOC)) {
                        $editLink = "<a href='index.php?page=editMed&medid=" . $fetch_medewerkers['MedewerkerID'] . "'>Gegevens beerken</a>";
                ?>
                        <tr>
                            <td><span><?= $fetch_medewerkers['MedewerkerID'] ?></span></td>
                            <td><span><?= $fetch_medewerkers['VoorNaam'] ?></span></td>
                            <td><span><?= $fetch_medewerkers['AchterNaam'] ?></span></td>
                            <td><span><?= $fetch_medewerkers['Email'] ?></span></td>
                            <td><span><?= $fetch_medewerkers['Account'] ?></span></td>
                            <td><span><?= $fetch_medewerkers['Rol'] ?></span></td>
                            <td><span><?= $editLink ?></span></td>

                        </tr>

                <?php
                    }
                } else {
                    echo '<p class="empty">Er zijn geen reservering</p>';
                }
                ?>

            </tbody>
        </table>

    </div>

</body>

</html>