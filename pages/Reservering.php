<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservering overzicht</title>
</head>

<body>
    <?php
    //Reserveren tabel
    include("pages/reserveren.php");
    ?>
    <div class="content">
        <?php
        $vandaag = date('Y-m-d');
        $vandaag = strtotime($vandaag);
        $vandaag = date('Y-m-d', $vandaag);
        $listReserv = $db->run('SELECT * FROM reserveringen WHERE Datum = ?',[$vandaag]);
        ?>
        <table id="overzicht">
            <caption style="caption-side:top">
                <h4>Overzicht van reservering</h4>
            </caption>
            <thead>
                <tr>
                    <th> Datum</th>
                    <th> Tijd</th>
                    <th> Tafel</th>
                    <th> Klantnaam</th>
                    <th> Telefoonnummer</th>
                    <th> Aantal</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>

                <?php
                if ($listReserv->rowCount() > 0) {
                    while ($fetch_reserv = $listReserv->fetch(PDO::FETCH_ASSOC)) {
                        $getNaamKlant=$db->run('SELECT Naam FROM klanten WHERE ID = ? LIMIT 1', [$fetch_reserv['Klant_ID']])->fetch(PDO::FETCH_ASSOC);
                        foreach ($getNaamKlant as $fetch_Klant_Naam) {
                            $KlantNaam = $fetch_Klant_Naam;
                        }
                        $getTelefoonKlant=$db->run('SELECT Telefoon FROM klanten WHERE ID = ? LIMIT 1', [$fetch_reserv['Klant_ID']])->fetch(PDO::FETCH_ASSOC);
                        foreach ($getTelefoonKlant as $fetch_Klant_Tele) {
                            $KlantTelefoon = $fetch_Klant_Tele;
                        }
                        $editLink = "<a href='index.php?page=editReserv&reservid=" . $fetch_reserv['ID'] . "'>Reservering bewerken</a>";
                ?>
                        <tr>
                            <td><span><?= $fetch_reserv['ID'] ?></span></td>
                            <td><span><?= $fetch_reserv['Tijd'] ?></span></td>
                            <td><span><?= $fetch_reserv['Tafel'] ?></span></td>
                            <td><span><?= $KlantNaam ?></span></td>
                            <td><span><?= $KlantTelefoon ?></span></td>
                            <td><span><?= $fetch_reserv['Aantal'] ?></span></td>
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