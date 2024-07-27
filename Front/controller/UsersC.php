<?php

require_once "../config.php";
require_once "../model/User.php";

class electorC{
    function addElector($newElector){
        $db = config::getConnexion();

        try {
            
            $query = $db->prepare(
                'INSERT INTO elector (/*id,*/identify_number,username,full_name,email,dob,adresse,password) 
                    VALUES (/*:id,*/:identify_number,:username,:full_name,:email,:dob,:adresse,:password)'
            );
            $query->execute([
                //'id' => $newUser->getId(),
                'identify_number' => $newElector->getIdentify_number(),
                'username' => $newElector->getUsername(),
                'full_name' => $newElector->getFull_name(),
                'email' => $newElector->getEmail(),
                'dob' => $newElector->getDob(),
                'adresse' => $newElector->getAdresse(),
                'password' => $newElector->getPassword()
                /*'confirmation_token' => $newUser->getConfirmation_token(),
                'confirmation_at' => $newUser->getConfirmation_at(),
                'reset_token' => $newUser->getReset_token(),
                'reset_at' => $newUser->getReset_at(),
                'remember_at' => $newUser->getRemember_at()*/
            ]);
        } catch (PDOException $e) {
            echo "Erreur lors de l'ajout de l'utilisateur : " . $e->getMessage();
        }
    }
    function updateElectorUsername($newUsername,$userId){

        $db = config::getConnexion();
        try{
            $query = $db->prepare(
                'UPDATE elector SET username= :username where id_elector = :id_elector'
            );
            $query = $query->execute([
                'username' => $newUsername,
                'id_elector' => $userId
            ]);
            $_SESSION['username'] = $newUsername;
        }catch(PDOException $e){
            $e->getMessage();
        }
    }
    function updateElectorFull_name($newFull_name,$userId){

        $db = config::getConnexion();
        try{
            $query = $db->prepare(
                'UPDATE elector SET full_name= :full_name where id_elector = :id_elector'
            );
            $query = $query->execute([
                'full_name' => $newFull_name,
                'id_elector' => $userId
            ]);
            $_SESSION['full_name'] = $newFull_name;
        }catch(PDOException $e){
            $e->getMessage();
        }
    }
    function updateElectorEmail($newEmail,$userId){
        
        $db = config::getConnexion();
        try{
            $query = $db->prepare(
                'UPDATE elector SET email= :email where id_elector = :id_elector'
            );
            $query = $query->execute([
                'email' => $newEmail,
                'id_elector' => $userId
            ]);
            $_SESSION['email'] = $newEmail;
        }catch(PDOException $e){
            $e->getMessage();
        }
    }
    function updateElectorDob($newDob,$userId){
        
        $db = config::getConnexion();
        try{
            $query = $db->prepare(
                'UPDATE elector SET dob= :dob where id_elector = :id_elector'
            );
            $query = $query->execute([
                'dob' => $newDob,
                'id_elector' => $userId
            ]);
            $_SESSION['dob'] = $newDob;
        }catch(PDOException $e){
            $e->getMessage();
        }
    }
    function updateElectorAdresse($newAdresse,$userId){
        
        $db = config::getConnexion();
        try{
            $query = $db->prepare(
                'UPDATE elector SET adresse= :adresse where id_elector = :id_elector'
            );
            $query = $query->execute([
                'adresse' => $newAdresse,
                'id_elector' => $userId
            ]);
            $_SESSION['adresse'] = $newAdresse;
        }catch(PDOException $e){
            $e->getMessage();
        }
    }
    function updateElectorPassword($newPassword,$userId){
        $db = config::getConnexion();
        try{
            $query = $db->prepare(
                'UPDATE elector SET password= :password where id_elector = :id_elector'
            );
            $query = $query->execute([
                'password' => $newPassword,
                'id_elector' => $userId
            ]);
        }catch(PDOException $e){
            $e->getMessage();
        }
    }
    function deleteElector($userId){

        $db = config::getConnexion();
        try {
            $query = $db->prepare(
                'DELETE FROM elector WHERE id_elector = :id_elector'
            );
            $query->execute([
                'id_elector' => $userId
            ]);
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }
    public function countElector() {
        $db = config::getConnexion();
        try {
            $query = $db->prepare('SELECT COUNT(*) FROM elector');
            $query->execute();
            $result = $query->fetchColumn();
            return $result;
        } catch (PDOException $e) {
            echo "Erreur lors du comptage des utilisateurs : " . $e->getMessage();
        }
        return 0;
    }
}
class CandidatC{
    function addCandidat($newCandidat){
        $db = config::getConnexion();

        try {
            
            $query = $db->prepare(
                'INSERT INTO candidat (id_election,username,full_name,email,dob,adresse,biography,program,political_party,image,password) 
                    VALUES (:id_election,:username,:full_name,:email,:dob,:adresse,:biography,:program,:political_party,:image,:password)'
            );
            $query->execute([
                //'id' => $newAgence->getId(),
                'username' => $newCandidat->getUsername(),
                'id_election' => $newCandidat->getId_election(),
                'full_name' => $newCandidat->getFull_name(),
                'email' => $newCandidat->getEmail(),
                'dob' => $newCandidat->getDob(),
                'adresse' => $newCandidat->getAdresse(),
                'biography' => $newCandidat->getBiography(),
                'program' => $newCandidat->getProgram(),
                'political_party' => $newCandidat->getPolitical_party(),
                'image' => $newCandidat->getImage(),
                'password' => $newCandidat->getPassword()
            ]);
        } catch (PDOException $e) {
            echo "Erreur lors de l'ajout de l'utilisateur : " . $e->getMessage();
        }
    }
    function updateCandidatUsername($newName,$agenceId){

        $db = config::getConnexion();
        try{
            $query = $db->prepare(
                'UPDATE candidat SET username= :username where id_candidat = :id_candidat'
            );
            $query = $query->execute([
                'username' => $newName,
                'id_candidat' => $agenceId
            ]);
            $_SESSION['username'] = $newName;
        }catch(PDOException $e){
            $e->getMessage();
        }
    }
    function updateCandidatId_election($newName,$agenceId){

        $db = config::getConnexion();
        try{
            $query = $db->prepare(
                'UPDATE candidat SET id_election= :id_election where id_candidat = :id_candidat'
            );
            $query = $query->execute([
                'id_election' => $newName,
                'id_candidat' => $agenceId
            ]);
            $_SESSION['id_election'] = $newName;
        }catch(PDOException $e){
            $e->getMessage();
        }
    }
    function updateCandidatFull_name($newFull_name,$userId){

        $db = config::getConnexion();
        try{
            $query = $db->prepare(
                'UPDATE candidat SET full_name= :full_name where id_candidat = :id_candidat'
            );
            $query = $query->execute([
                'full_name' => $newFull_name,
                'id_candidat' => $userId
            ]);
            $_SESSION['full_name'] = $newFull_name;
        }catch(PDOException $e){
            $e->getMessage();
        }
    }
    function updateCandidatImage($newImage,$agenceId){

        $db = config::getConnexion();
        try{
            $query = $db->prepare(
                'UPDATE candidat SET image= :image where id_candidat = :id_candidat'
            );
            $query = $query->execute([
                'image' => $newImage,
                'id_candidat' => $agenceId
            ]);
            $_SESSION['image'] = $newImage;
        }catch(PDOException $e){
            $e->getMessage();
        }
    }
    function updateCandidatAdresse($newAdresse,$agenceId){

        $db = config::getConnexion();
        try{
            $query = $db->prepare(
                'UPDATE candidat SET adresse= :adresse where id_candidat = :id_candidat'
            );
            $query = $query->execute([
                'adresse' => $newAdresse,
                'id_candidat' => $agenceId
            ]);
            $_SESSION['adresse'] = $newAdresse;
        }catch(PDOException $e){
            $e->getMessage();
        }
    }

    function updateCandidatEmail($newEmail,$agenceId){
        
        $db = config::getConnexion();
        try{
            $query = $db->prepare(
                'UPDATE candidat SET email= :email where id_candidat = :id_candidat'
            );
            $query = $query->execute([
                'email' => $newEmail,
                'id_candidat' => $agenceId
            ]);
            $_SESSION['email'] = $newEmail;
        }catch(PDOException $e){
            $e->getMessage();
        }
    }
    function updateCandidatPolitical_party($newPolitical_party,$agenceId){
        
        $db = config::getConnexion();
        try{
            $query = $db->prepare(
                'UPDATE candidat SET political_party= :political_party where id_candidat = :id_candidat'
            );
            $query = $query->execute([
                'political_party' => $newPolitical_party,
                'id_candidat' => $agenceId
            ]);
            $_SESSION['political_party'] = $newPolitical_party;
        }catch(PDOException $e){
            $e->getMessage();
        }
    }
    function updateCandidatProgram($newProgram,$agenceId){
        
        $db = config::getConnexion();
        try{
            $query = $db->prepare(
                'UPDATE candidat SET program= :program where id_candidat = :id_candidat'
            );
            $query = $query->execute([
                'program' => $newProgram,
                'id_candidat' => $agenceId
            ]);
            $_SESSION['program'] = $newProgram;
        }catch(PDOException $e){
            $e->getMessage();
        }
    }
    function updateCandidatBiography($newBiography,$agenceId){
        
        $db = config::getConnexion();
        try{
            $query = $db->prepare(
                'UPDATE candidat SET biography= :biography where id_candidat = :id_candidat'
            );
            $query = $query->execute([
                'biography' => $newBiography,
                'id_candidat' => $agenceId
            ]);
            $_SESSION['biography'] = $newBiography;
        }catch(PDOException $e){
            $e->getMessage();
        }
    }
    function updateCandidatPassword($newPassword,$agenceId){
        $db = config::getConnexion();
        try{
            $query = $db->prepare(
                'UPDATE candidat SET password= :password where id_candidat = :id_candidat'
            );
            $query = $query->execute([
                'password' => $newPassword,
                'id_candidat' => $agenceId
            ]);
        }catch(PDOException $e){
            $e->getMessage();
        }
    }
    function deleteCandidat($agenceId){

        $db = config::getConnexion();
        try {
            $query = $db->prepare(
                'DELETE FROM candidat WHERE id_candidat = :id_candidat'
            );
            $query->execute([
                'id_candidat' => $agenceId
            ]);
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }
    function countCandidat() {
        $db = config::getConnexion();
        try {
            $query = $db->prepare('SELECT COUNT(*) FROM candidat');
            $query->execute();
            $result = $query->fetchColumn();
            return $result;
        } catch (PDOException $e) {
            echo "Erreur lors du comptage des candidat : " . $e->getMessage();
        }
        return 0;
    }
}
class NotificationC{


    function addNotification($newNotif){
        $db = config::getConnexion();

        try {
            
            $query = $db->prepare(
                'INSERT INTO notification (type,userId,message,dateReceived,status) 
                    VALUES (:type,:userId,:message,:dateReceived,:status)'
            );
            $query->execute([
                //'id' => $newAgence->getId(),

               
                'type' => $newNotif->getType(),
                'userId'=> $newNotif->getUserId(),
                'message' => $newNotif->getMessage(),
                'dateReceived' => $newNotif->getDateReceived(),
                'status' => $newNotif->getStatus(),

            ]);
        } catch (PDOException $e) {
            echo "Erreur lors de l'ajout de l'utilisateur : " . $e->getMessage();
        }
    }


    function getMessage($idUser) {
        $db = config::getConnexion();
        $users = [];
        try {
            $query = $db->prepare('SELECT * FROM notification where userId= :idUser');
            $query->execute(['idUser'=>$idUser]);
            $result=$query->fetchAll();
            return $result;
            
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des agences : " . $e->getMessage();
        }
        return $users;
    }
    // Fonction pour compter le nombre de notifications lues
function countReadNotifications() {
    try {
        $pdo = config::getConnexion();
        $query = "SELECT COUNT(*) FROM notification WHERE status = 'read'";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $count_read = $stmt->fetchColumn();
        return $count_read;
    } catch (PDOException $e) {
        // En cas d'erreur lors de la récupération des statistiques, affichez un message d'erreur ou redirigez vers une page d'erreur
        echo "Erreur : " . $e->getMessage();
        return false;
    }
}

// Fonction pour compter le nombre de notifications non lues
function countUnreadNotifications() {
    try {
        $pdo = config::getConnexion();
        $query = "SELECT COUNT(*) FROM notification WHERE status = 'unread'";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $count_unread = $stmt->fetchColumn();
        return $count_unread;
    } catch (PDOException $e) {
        // En cas d'erreur lors de la récupération des statistiques, affichez un message d'erreur ou redirigez vers une page d'erreur
        echo "Erreur : " . $e->getMessage();
        return false;
    }
}

}
class OnligneC{
      function countLoggedInUsers() {
        // Connexion à la base de données
        $pdo = config::getConnexion();
        
        // Préparer la requête pour compter tous les utilisateurs connectés
        $query = "SELECT COUNT(*) FROM onligne";
        $stmt = $pdo->query($query);
        
        // Récupérer le nombre d'utilisateurs connectés
        $loggedInUsersCount = $stmt->fetchColumn();
        
        return $loggedInUsersCount;
    }
    
}
class VoteC {
    // Ajouter un nouveau vote
    public function addVote($newVote) {
        $db = config::getConnexion();
        try {
            $query = $db->prepare(
                'INSERT INTO vote (id_elector, id_candidat, id_election, voted_at) 
                VALUES (:id_elector, :id_candidat, :id_election, :voted_at)'
            );
            $query->execute([
                'id_elector' => $newVote->getId_elector(),
                'id_candidat' => $newVote->getId_candidat(),
                'id_election' => $newVote->getId_election(),
                'voted_at' => $newVote->getVoted_at()
            ]);
        } catch (PDOException $e) {
            echo "Erreur lors de l'ajout du vote : " . $e->getMessage();
        }
    }

    // Mettre à jour un vote (par exemple, dans le cas où vous voulez permettre des modifications)
    public function updateVote($voteId, $newVote) {
        $db = config::getConnexion();
        try {
            $query = $db->prepare(
                'UPDATE vote SET id_elector = :id_elector, id_candidat = :id_candidat, id_election = :id_election
                WHERE id_vote = :id_vote'
            );
            $query->execute([
                'id_elector' => $newVote->getId_elector(),
                'id_candidat' => $newVote->getId_candidat(),
                'id_election' => $newVote->getId_election(),
                'id_vote' => $voteId
            ]);
        } catch (PDOException $e) {
            echo "Erreur lors de la mise à jour du vote : " . $e->getMessage();
        }
    }

    // Supprimer un vote
    public function deleteVote($voteId) {
        $db = config::getConnexion();
        try {
            $query = $db->prepare(
                'DELETE FROM vote WHERE id_vote = :id_vote'
            );
            $query->execute([
                'id_vote' => $voteId
            ]);
        } catch (PDOException $e) {
            echo "Erreur lors de la suppression du vote : " . $e->getMessage();
        }
    }

    // Compter le nombre de votes pour une élection donnée
    public function countVotesForElection($electionId) {
        $db = config::getConnexion();
        try {
            $query = $db->prepare('SELECT COUNT(*) FROM vote WHERE id_election = :id_election');
            $query->execute(['id_election' => $electionId]);
            $result = $query->fetchColumn();
            return $result;
        } catch (PDOException $e) {
            echo "Erreur lors du comptage des votes : " . $e->getMessage();
        }
        return 0;
    }
}
class ElectionC {
    // Ajouter une nouvelle élection
    public function addElection($newElection) {
        $db = config::getConnexion();
        try {
            $query = $db->prepare(
                'INSERT INTO elections (title, start_date, end_date, is_active) 
                VALUES (:title, :start_date, :end_date, :is_active)'
            );
            $query->execute([
                'title' => $newElection->getTitle(),
                'start_date' => $newElection->getStart_date(),
                'end_date' => $newElection->getEnd_date(),
                'is_active' => $newElection->getIs_active()
            ]);
        } catch (PDOException $e) {
            echo "Erreur lors de l'ajout de l'élection : " . $e->getMessage();
        }
    }

    // Mettre à jour une élection
    public function updateElection($electionId, $newElection) {
        $db = config::getConnexion();
        try {
            $query = $db->prepare(
                'UPDATE elections SET title = :title, start_date = :start_date, end_date = :end_date, is_active = :is_active 
                WHERE id = :id'
            );
            $query->execute([
                'title' => $newElection->getTitle(),
                'start_date' => $newElection->getStart_date(),
                'end_date' => $newElection->getEnd_date(),
                'is_active' => $newElection->getIs_active(),
                'id' => $electionId
            ]);
        } catch (PDOException $e) {
            echo "Erreur lors de la mise à jour de l'élection : " . $e->getMessage();
        }
    }

    // Supprimer une élection
    public function deleteElection($electionId) {
        $db = config::getConnexion();
        try {
            $query = $db->prepare(
                'DELETE FROM elections WHERE id = :id'
            );
            $query->execute([
                'id' => $electionId
            ]);
        } catch (PDOException $e) {
            echo "Erreur lors de la suppression de l'élection : " . $e->getMessage();
        }
    }

    // Compter le nombre total d'élections
    public function countElections() {
        $db = config::getConnexion();
        try {
            $query = $db->prepare('SELECT COUNT(*) FROM elections');
            $query->execute();
            $result = $query->fetchColumn();
            return $result;
        } catch (PDOException $e) {
            echo "Erreur lors du comptage des élections : " . $e->getMessage();
        }
        return 0;
    }
}
?>