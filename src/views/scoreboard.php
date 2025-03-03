<?php

use Models\ARUsers;

$addonPath = '';
$slashCount = substr_count($_SERVER['REQUEST_URI'], '/');
for ($i = $slashCount; $i > 1; $i--) {
    $addonPath .= '../';
}
?>
<link rel="stylesheet" href="<?= $addonPath ?>styles/index.css">
<style>
    .me {
        background-color: #2196f36b;
    }

    .me>td {
        background-color: transparent;
    }
</style>
<h2>Scoreboard</h2>
<section>
    <table>
        <tr>
            <th>Place</th>
            <th>Pseudo</th>
            <th>Score</th>
            <th>Region</th>
        </tr>
        <?php for ($i = 0; $i < count($scoreboard); $i++) { ?>
            <tr <?= ($scoreboard[$i]['username'] == ARUsers::readById($_SESSION['idUser'])['username']) ? 'class="me"' : '' ?>>
                <td><?= ($i + 1) ?></td>
                <td><?= $scoreboard[$i]['username'] ?></td>
                <td><?= $scoreboard[$i]['score'] ?></td>
                <td><?= $scoreboard[$i]['region'] ?></td>
            </tr>
        <?php } ?>
    </table>
</section>