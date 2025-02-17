<?php
$userConnected = isset($_SESSION['idUser']) ? Models\ARUsers::readById($_SESSION['idUser']) : null;
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flag game - <?= $title ?></title>
</head>

<body>
    <?php if (isset($drawHeader) && $drawHeader) { ?>
        <nav>
            <img src="assets/img/flagLogo_no_bg.png" alt="">
            <h1>
                <li><a href="/">Flag Game</a></li>
            </h1>
            <div id="navDroite">
                <ul>
                    <li><a href="/game">Jouer</a></li>
                    <li><a href="/scoreboard">ScoreBoard</a></li>
                    <?php if ($userConnected != null && $userConnected['isAdmin'] === 1) { ?>
                        <li><a href="/logs">Logs</a></li>
                    <?php } ?>
                    <li><a href="/account">Compte</a></li>
                </ul>
            </div>
        </nav>
    <?php } ?>
    <?= $content ?>
</body>

</html>