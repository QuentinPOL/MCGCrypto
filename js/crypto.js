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
        // Récupérer les données de la réponse et les afficher dans le paragraphe
        const pAPI = document.getElementById("textAPI");

        if (JSON.stringify(data[2]) == 1) // Si c'est achat
        {
          pAPI.innerHTML = "Vous avez achetez " + JSON.stringify(data[0]) + " unité(s) pour un total de " + JSON.stringify(data[1]) + " euro(s)";
        }
        else if (JSON.stringify(data[2]) == 2) // Si c'est une vente
        {
          pAPI.innerHTML = "Vous avez vendu " + JSON.stringify(data[0]) + " unité(s) pour un total de " + JSON.stringify(data[1]) + " euro(s)";
        }
    })
    .catch(error => console.error(error));    
}