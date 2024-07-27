module VotingNFT::VotingNFT {
    use std::signer;
    struct VotingNFT has copy, drop, store ,key{
        id: u64,
        owner: address,
    }

    public fun mint(owner: &signer, id: u64) {
        let nft = VotingNFT { id, owner: signer::address_of(owner) };
        move_to(owner, nft);
    }
}
