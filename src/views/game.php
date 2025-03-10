<?php
$addonPath = '';
$slashCount = substr_count($_SERVER['REQUEST_URI'], '/');
for ($i = $slashCount; $i > 1; $i--) {
    $addonPath .= '../';
}
?>
<link rel="stylesheet" href="<?= $addonPath ?>styles/index.css">
<style>
    /* Style pour organiser les drapeaux */
    #drapeaux {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 20px;
    }

    .row {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-bottom: 20px;
        align-items: center;
    }

    div img {
        width: 13%;
        height: fit-content;
        cursor: pointer;
        border: 2px solid transparent;
        transition: border 0.3s;
        border-radius: 5px;
        transform: rotate(0deg);
        transition: all 0.2s;
    }

    img:hover {
        border: 2px solid #3F51B5;
        transform: rotate(-3deg);
        transition: all 0.2s;
    }

    .button-with-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #0f988e;
        font-family: "Istok Web", sans-serif;
        padding: 12px;
        width: 120px;
        height: 40px;
        font-size: 14px;
        text-transform: uppercase;
        background: #15ccbe;
        color: white;
        cursor: pointer;
        transition: 150ms all ease-in-out;
        margin: auto;
    }

    .button-with-icon:hover {
        background: #0f988e;
    }
</style>
<h2>Quel est le drapeau de ce pays ?</h2>
<h2 id="nomPays">Nom du pays</h2>
<h3 style="text-align: center;" id="scorecont">Score: <span id="scoreResult"></span></h3>

<div id="drapeaux">
    <div id="drapeaux-haut" class="row"></div>
    <div id="drapeaux-bas" class="row"></div>
</div>

<p id="afficherResultat" style="text-align: center; font-size: 60px; ">Resultat score: <span style="font-size: 60px;"
        id="resultatScore"></span>
</p>

<button id="btnPlay" onclick="recuperer()" class="button-with-icon">Rejouer</button>

<script>
    const URLAPI = "https://restcountries.com/v3.1/all";
    let paysListe = [];
    let paysChoisis = [];
    let btn = document.getElementById("btnPlay");
    let scoreResult = document.getElementById("scoreResult");
    btn.style.visibility = "hidden";
    let score = 0;
    let nomPaysElement = document.getElementById("nomPays");
    let drapeaux = document.getElementById("drapeaux");
    let drapeauxHaut = document.getElementById("drapeaux-haut");
    let drapeauxBas = document.getElementById("drapeaux-bas");
    scoreResult.textContent = score;
    let ResultatScore = document.getElementById("resultatScore")
    let AffichageResultatScore = document.getElementById("afficherResultat");
    AffichageResultatScore.style.visibility = "hidden";

    const CACHE_TIMEOUT = 3600000; // 1 heure en millisecondes (3600000 ms)

    async function recuperer() {
        const storedData = localStorage.getItem('paysListe');
        const lastFetchTime = localStorage.getItem('lastFetchTime');

        const currentTime = new Date().getTime();

        if (storedData && lastFetchTime && (currentTime - lastFetchTime) < CACHE_TIMEOUT) {
            // Utiliser les données en cache si elles ne sont pas expirées
            paysListe = JSON.parse(storedData);
            console.log('Données récupérées depuis le cache');
            nbrDrapeauCalcule = Math.floor(4 + Math.log((score / 10) + 1) / Math.log(3));
            afficherDrapeauxUniques(nbrDrapeauCalcule);
        } else {
            try {
                const reponse = await fetch(URLAPI);
                if (!reponse.ok) {
                    throw new Error("Erreur lors de la récupération des données");
                }
                const pays = await reponse.json();
                paysListe = pays.map(element => ({
                    nom: element.name.common,
                    drapeau: element.flags.svg
                }));

                // Stocker les données dans le localStorage avec un timestamp
                localStorage.setItem('paysListe', JSON.stringify(paysListe));
                localStorage.setItem('lastFetchTime', currentTime.toString());

                console.log('Données récupérées depuis l\'API');
                nbrDrapeauCalcule = Math.floor(4 + Math.log((score / 10) + 1) / Math.log(3));
                afficherDrapeauxUniques(nbrDrapeauCalcule);
            } catch (error) {
                console.error("Erreur :", error);
            }
        }
    }

    let nbrDrapeau = 4;
    let compteurTours = 0;
    const toursAvantAugmentation = 5;

    function afficherDrapeauxUniques(nbr) {
        drapeauxHaut.innerHTML = "";
        drapeauxBas.innerHTML = "";
        paysChoisis = [];
        let copiePays = [...paysListe];

        for (let i = 0; i < nbr; i++) {
            let random = Math.floor(Math.random() * copiePays.length);
            let paysSelectionne = copiePays[random];

            let drapeau = document.createElement("img");
            drapeau.src = paysSelectionne.drapeau;
            drapeau.alt = paysSelectionne.nom;
            drapeau.addEventListener("click", () => verifierReponse(paysSelectionne.nom));

            if (Math.floor(i) < Math.ceil(nbr / 2)) {
                drapeauxHaut.appendChild(drapeau);
            } else {
                drapeauxBas.appendChild(drapeau);
            }
            paysChoisis.push(paysSelectionne);
            copiePays.splice(random, 1);
        }
        let randomPays = Math.floor(Math.random() * paysChoisis.length);
        nomPaysElement.textContent = paysChoisis[randomPays].nom;
    }

    let audioSuccess = new Audio('<?= $addonPath ?>assets/sound/success.mp3');
    let audioError = new Audio('<?= $addonPath ?>assets/sound/error.mp3');
    audioSuccess.load();
    audioError.load();

    function verifierReponse(nomClique) {
        compteurTours++;
        let nomCorrect = nomPaysElement.textContent;
        if (nomClique === nomCorrect) {
            audioSuccess.currentTime = 0;
            audioSuccess.play();
            score += 10;
            scoreResult.textContent = score;
            recuperer();
        } else {
            audioError.play();
            drapeaux.style.display = "none";
            AffichageResultatScore.style.visibility = "visible";
            ResultatScore.textContent = score;
            nomPaysElement.style.visibility = "hidden";
            btn.style.visibility = "visible";
            btn.addEventListener('click', () => {
                window.location.reload();
            });
            document.getElementById('scorecont').style.visibility = "hidden";
        }
        fetch(`http://flaglog/saveScore/${score}`);
    }

    recuperer(); // Charger les données au début
</script>