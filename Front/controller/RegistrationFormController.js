document.getElementById("registrationForm").addEventListener("submit", async function(event) {
    event.preventDefault();
    const walletAddress = document.getElementById("walletAddress").value;

    try {
        const response = await fetch('controller/RegistrationUser.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ walletAddress }),
        });

        const result = await response.json();
        if (response.ok) {
            console.log("NFT minted successfully:", result);
        } else {
            console.error("Error minting NFT:", result);
        }
    } catch (error) {
        console.error("Request failed:", error);
    }
});