
const { client, createAptosAccount, fundAptosAccount,getAccountBalance } = require('./AptosClient') ;

 async function mintNFT() {
    // Créer un nouveau compte et le financer
    const account = createAptosAccount();
    console.log(account);
        console.log("Creating and funding new account...");
        await fundAptosAccount(account);
  


    // Récupérer l'adresse du portefeuille
    const walletAddress = account.accountAddress.hexString;
    console.log("New wallet address: ", walletAddress);

     // Attendre que le compte soit financé
     console.log("Waiting for the account to be funded...");
     await new Promise(resolve => setTimeout(resolve, 10000)); // Attendre 10 secondes
     console.log(account);

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

mintNFT();















const { AptosClient, AptosAccount } = require('aptos');
const { AptosFaucetClient } = require('@aptos-labs/aptos-faucet-client');

const NODE_URL = "https://fullnode.devnet.aptoslabs.com/v1";
const FAUCET_URL = "https://faucet.devnet.aptoslabs.com";

// Initialisation du client Aptos
const client = new AptosClient(NODE_URL);

// Initialisation du client Faucet
const faucetClient = new AptosFaucetClient({
    BASE: FAUCET_URL,
});




function createAptosAccount() {
    const account = new AptosAccount();
    return account;
}

async function fundAptosAccount(account, amount = 10000) {
    try {
        const response = await faucetClient.fund({
            amount,
            address: account.address().hex(),
        });
        console.log(`Account funded with ${amount} coins. Transaction hashes:`, response.txn_hashes);
    } catch (error) {
        console.error(`Failed to fund account ${account.address().hex()}:`, error);
    }

    
}

async function getAccountBalance(accountAddress) {
    try {
        const account = await client.getAccount(accountAddress);
        return account?.balances?.[0]?.amount || 0; // Assurez-vous que le solde est retourné correctement
    } catch (error) {
        console.error(`Failed to get account balance for ${accountAddress}:`, error);
        return 0;
    }
}

module.exports = {
    createAptosAccount,
    fundAptosAccount,
    getAccountBalance,
    client,
    faucetClient
};
