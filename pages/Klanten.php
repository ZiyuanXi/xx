<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Klant overzicht van .....</title>
</head>

<body>
    <div class="content">
        <?php
        $listKlant = $db->run('SELECT * FROM klanten');
        ?>
        <table id="overzicht">
            <caption style="caption-side:top">
                <h4>Overzicht van Klanten</h4>
            </caption>
            <thead>
                <tr>
                    <th> Naam</th>
                    <th> Telefoonnummer</th>
                    <th> Email</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($listKlant->rowCount() > 0) {
                    while ($fetch_klant = $listKlant->fetch(PDO::FETCH_ASSOC)) {
                        $editLink = "<a href='index.php?page=editKlant&klantId=" . $fetch_klant['ID'] . "'>Klant gegevens bewerken</a>";
                ?>

                        <tr>
                            <td><span><?= $fetch_klant['Naam'] ?></span></td>
                            <td><span><?= $fetch_klant['Telefoon'] ?></span></td>
                            <td><span><?= $fetch_klant['Email'] ?></span></td>
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