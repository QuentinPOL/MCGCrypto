const buyForm = document.getElementById('buy-form');
const sellForm = document.getElementById('sell-form');
const buyButton = document.getElementById('buy-button');
const sellButton = document.getElementById('sell-button');

buyButton.addEventListener('click', function() {
  buyForm.style.display = 'block';
  sellForm.style.display = 'none';
});

sellButton.addEventListener('click', function() {
  buyForm.style.display = 'none';
  sellForm.style.display = 'block';
});

function apiBuySellCrypto(amountCrypto, amountEuro, type, market, crypto1, crypto2) 
{
    // Créer un objet JSON avec les données à envoyer
    const data = {amountCryp : amountCrypto, amountEur : amountEuro, method: type, marketnumber : market, crypt1 : crypto1, crypt2 : crypto2};

    // Envoyer la requête POST
    fetch("forms/API.php", {
    method: "POST",
    headers: {
        "Content-Type": "application/json"
    },
    body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        // Récupérer les données de la réponse et les afficher dans une div
        const div = document.getElementById("maDiv");
        div.innerHTML = JSON.stringify(data.amountCryp);
    })
    .catch(error => console.error(error));    
}