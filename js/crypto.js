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
        // Récupérer l'élément HTML <tbody> où on va ajouter les wallets
        const tbody = document.querySelector("#wallet tbody");
        // Récupérer le paragraphe avec la balance total pour la modifier
        const pWalletBalance = document.querySelector("#balanceTotal p");
        // Stocker la balanceTotal
        var totalBalance = null;

        if (JSON.stringify(data[0]) != "erreur") // Si l'api ne revoie d'erreur
        {
          if (JSON.stringify(data[2]) == 1) // Si c'est achat
          {
            pAPI.innerHTML = "Vous avez achetez " + JSON.stringify(data[0]) + " unité(s) pour un total de " + JSON.stringify(data[1]) + " euro(s)";

          }
          else if (JSON.stringify(data[2]) == 2) // Si c'est une vente
          {
            pAPI.innerHTML = "Vous avez vendu " + JSON.stringify(data[0]) + " unité(s) pour un total de " + JSON.stringify(data[1]) + " euro(s)";
          }

          // Vider le contenu HTML du tbody
          tbody.innerHTML = "";

          data["walletUser"].forEach(wallet => {
            // Créer une nouvelle ligne de tableau
            const row = document.createElement("tr");
          
            // Ajouter une cellule pour le nom du wallet
            const nameCell = document.createElement("td");
            nameCell.textContent = wallet.name;
            row.appendChild(nameCell);
          
            // Ajouter une cellule pour la quantité de la crypto-monnaie
            const amountCell = document.createElement("td");
            amountCell.textContent = wallet.amount;
            row.appendChild(amountCell);
          
            // Ajouter une cellule pour le solde en EUR
            const balanceCell = document.createElement("td");
            balanceCell.textContent = wallet.balanceEUR + " €";
            totalBalance += wallet.balanceEUR;
            row.appendChild(balanceCell);
          
            // Ajouter la ligne au tableau
            tbody.appendChild(row);
          });

          pWalletBalance.innerHTML = "Total du Portefeuille: " + totalBalance + " €";
        }
    })
    .catch(error => console.error(error));    
}