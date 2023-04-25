const buyForm = document.getElementById('buy-form');
const sellForm = document.getElementById('sell-form');
const buyButton = document.getElementById('buy-button');
const sellButton = document.getElementById('sell-button');
var chooseMethod = null;

buyButton.addEventListener('click', function() {
  buyForm.style.display = 'block';
  sellForm.style.display = 'none';
  chooseMethod = 1;
});

sellButton.addEventListener('click', function() {
  buyForm.style.display = 'none';
  sellForm.style.display = 'block';
  chooseMethod = 2;
});

function apiBuySellCrypto() 
{
    // Créer un objet JSON avec les données à envoyer
    const data = {name: "John", test: "hebefhgbejh", method: chooseMethod};

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
        div.innerHTML = JSON.stringify(data);
    })
    .catch(error => console.error(error));    
}