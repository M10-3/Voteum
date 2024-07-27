const axios = require('axios');
const { AptosClient, AptosAccount } = require('aptos');

// URL du client fullnode pour Devnet
const client = new AptosClient('https://fullnode.devnet.aptoslabs.com/v1');
const faucetUrl = 'https://faucet.devnet.aptoslabs.com/mint';

async function mintNFT() {
    // Créer un nouveau compte
    const account = new AptosAccount();
    console.log("Account created in mintNFT:", account);

    // Financer le compte
    console.log("Creating and funding new account...");
    await fundAptosAccount(account);

    console.log("Waiting for the account to be funded...");
    await new Promise(resolve => setTimeout(resolve, 20000)); // Augmentez le délai d'attente à 20 secondes

    // Récupérer l'adresse du portefeuille
    const walletAddress = account.address().hex();
    console.log("New wallet address: ", walletAddress);

    // Vérifier le solde du compte
    const balance = await getAccountBalance(walletAddress);
    console.log(`Account balance: ${balance} coins`);

    if (balance <= 0) {
        throw new Error("Account is not funded properly.");
    }

    // Définir la transaction de mint NFT
    const transaction = {
        type: "entry_function_payload",
        function: "0x62a4d83a8af7e21c07ba0c10f74c647f322d820bc501a1672ae79d75694f135b::VotingNFT::mint",
        arguments: [walletAddress, new Date().getTime()],
    };

    // Générer, signer et soumettre la transaction
    const txnRequest = await client.generateTransaction(account.address(), transaction);
    const signedTxn = await client.signTransaction(account, txnRequest);
    const transactionRes = await client.submitTransaction(signedTxn);
    await client.waitForTransaction(transactionRes.hash);
    console.log("NFT minted and sent to: ", walletAddress);
}

// Fonction pour financer le compte
async function fundAptosAccount(account) {
    try {
        const response = await axios.post(faucetUrl, {
            amount: 10000,
            address: account.address().hex()
        }, {
            headers: {
                'Content-Type': 'application/json',
                'Content-Length': JSON.stringify({
                    amount: 10000,
                    address: account.address().hex()
                }).length
            }
        });
        console.log('Account funded successfully:', response.data);
    } catch (error) {
        console.error('Error funding account:', error.response ? error.response.data : error.message);
    }
}

// Fonction pour vérifier le solde du compte
async function getAccountBalance(address) {
    try {
        const response = await client.getAccount(address);
        // Assurez-vous que la réponse contient les informations de solde correctes
        console.log('Account details:', response);
        return response.balances ? response.balances[0].amount : 0;
    } catch (error) {
        console.error('Error checking balance:', error.response ? error.response.data : error.message);
        return 0;
    }
}

mintNFT();
