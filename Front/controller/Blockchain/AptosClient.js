const { AptosClient, AptosAccount, FaucetClient } = require('aptos');

// URL du client fullnode pour Devnet
const client = new AptosClient('https://fullnode.devnet.aptoslabs.com/v1'); 
const faucetClient = new FaucetClient('https://faucet.devnet.aptoslabs.com', client);

async function createAndFundAccount() {
    const account = new AptosAccount();
    console.log('Aptos account created:', account);

    try {
        await faucetClient.fundAccount(account.address(), 10000); // Financer le compte
        console.log('Account funded successfully');
    } catch (error) {
        console.error('Error funding account:', error.message);
    }
}

async function checkBalance(address) {
    try {
        const response = await client.getAccount(address);
        console.log('Account Balance:', response);
    } catch (error) {
        console.error('Error checking balance:', error.message);
    }
}

(async () => {
    await createAndFundAccount();
    await checkBalance('0xf11a5b7c2f01bb930316c8aa7eabedd98bef7dc96ec5ab0095e36a9cf75827b7');
})();
