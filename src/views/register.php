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
<img id="logo" src="assets/img/flagLogo.png" alt="">
<div id="form">
    <?php if ($message) { ?>
        <div class="alert">
            <?= $message ?>
        </div>
    <?php } ?>

    <form action="/register" method="post">
        <label for="username">Nom d'utilisateur</label>
        <input type="text" name="username" id="username" maxlength="85" required>

        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password" required>

        <label for="region">Région</label>
        <select name="region" id="region" required>
            <option value="" selected disabled>Choisissez une région</option>
            <?php foreach ($regions as $region) { ?>
                <option value="<?= $region['id'] ?>"><?= $region['name'] ?></option>
            <?php } ?>
        </select>

        <input type="submit" id="btnSubmitForm" value="Envoyer">
    </form>
</div>
<a style="color: black;" href="/login">Vous possédez déjà un compte ? </a>

<script src="frontend/login.js"></script>