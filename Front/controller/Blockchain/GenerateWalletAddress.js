const { AptosAccount } = require('aptos');

function uint8ArrayToHexString(uint8Array) {
    return Array.from(uint8Array).map(byte => byte.toString(16).padStart(2, '0')).join('');
}
const account = new AptosAccount();
const publicKeyUint8Array = account.signingKey.publicKey;
const secretKeyUint8Array = account.signingKey.secretKey;

// Conversion des clés en chaînes hexadécimales
const publicKeyHex = uint8ArrayToHexString(publicKeyUint8Array);
const secretKeyHex = uint8ArrayToHexString(secretKeyUint8Array);

console.log('Public Key (Hex):', publicKeyHex);
console.log('Private Key (Hex):', secretKeyHex);

// Fonction pour générer une nouvelle adresse de portefeuille
function generateWalletAddress() {
    
    console.log("Account",account);
    return account.accountAddress.hexString;
}



module.exports = { generateWalletAddress };
console.log(generateWalletAddress());