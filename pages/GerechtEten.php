<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Onderhoud Eten</title>
</head>

<body>
    <div class="content">
        <?php
        $listEten = $db->run('SELECT * FROM menuitems WHERE Gerechtsoort_ID = 1 or Gerechtsoort_ID = 5 or Gerechtsoort_ID = 6 or Gerechtsoort_ID = 7 or Gerechtsoort_ID = 8 or Gerechtsoort_ID = 9');
        ?>
        <table id="overzicht">
            <caption style="caption-side:top">
                <h4>Onderhoud Eten</h4>
            </caption>
            <thead>
                <tr>
                    <th> Code</th>
                    <th> Omschrijving</th>
                    <th> Prijs</th>
                    <th> Valt onder</th>
                    <th> <a href="index.php?page=newGerechtEten"><i class="bi bi-plus-square-fill"></i></a></th>
                </tr>
            </thead>
            <tbody>

                <?php
                if ($listEten->rowCount() > 0) {
                    while ($fetch_Eten = $listEten->fetch(PDO::FETCH_ASSOC)) {
                        $getNaamSub=$db->run('SELECT Naam FROM gerechtsoorten WHERE ID = ? LIMIT 1', [$fetch_Eten['Gerechtsoort_ID']])->fetch(PDO::FETCH_ASSOC);
                        foreach ($getNaamSub as $fetch_Sub) {
                            $SubNaam = $fetch_Sub;
                        }
                        $editLink = "<a href='index.php?page=editGerechtEten&ID=" . $fetch_Eten['Code'] . "'><i class='bi bi-pen-fill'></i></a>";
                ?>
                        <tr>
                            <td><span><?= $fetch_Eten['Code'] ?></span></td>
                            <td><span><?= $fetch_Eten['Naam'] ?></span></td>
                            <td><span><?= $fetch_Eten['Prijs'] ?></span></td>
                            <td><span><?= $SubNaam ?></span></td>
                            <td><span><?= $editLink ?></span></td>
                            <td><span><a href="index.php?page=GerechtEten&ID=<?= $fetch_Eten['ID'] ?>"><i class="bi bi-trash-fill"></i></a></span></td>

                        </tr>

                <?php
                    }
                } else {
                    echo '<p class="empty">Er zijn geen Eten gevonden</p>';
                }
                ?>

            </tbody>
        </table>

    </div>

</body>
<!-- verwijderen -->
<?php
if (isset($_GET['ID'])) {
    $ID = $_GET['ID'];
    $deleteSql = "DELETE FROM gerechtcategorien WHERE ID =$ID";
    $delete = $db->run($deleteSql);
    $melding = "Eten verwijdert.";
    if ($delete) {
        echo "<div id='melding'><script type='text/javascript'>alert('$melding');
    location.href='index.php?page=GerechtEten'</script></div>";
    }
}
?>

</html>