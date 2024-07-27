<?php
require_once '../config.php';

class elector{
    private $id;
    private $identify_number;
    private $username;
    private $full_name;
    private $email;
    private $dob;
    private $adresse;
    private $password;
    /*private $confirmation_token;
    private $confirmation_at;
    private $reset_token;
    private $reset_at;
    private $remember_at;*/

    public function __construct($identify_number, $username, $full_name, $email, $dob, $adresse, $password, $id=null) {
        $this->id = $id;
        $this->identify_number = $identify_number;
        $this->username = $username;
        $this->full_name = $full_name;
        $this->email = $email;
        $this->dob = $dob;
        $this->adresse = $adresse;
        $this->password = $password;
        /*$this->confirmation_token = $confirmation_token;
        $this->confirmation_at = $confirmation_at;
        $this->$reset_token = $$reset_token;
        $this->reset_at = $reset_at;
        $this->remember_at = $remember_at;*/
    }
    public function getId()
    {
    return $this->id;
    }
    public function setId($id)
    {
    $this->id = $id;
    return $this;
    }
    public function getIdentify_number()
    {
    return $this->identify_number;
    }
    public function setIdentify_number($identify_number)
    {
    $this->identify_number = $identify_number;
    return $this;
    }
public function getUsername()
{
return $this->username;
}
public function setUsername($username)
{
$this->username = $username;
return $this;
}
public function getFull_name()
{
return $this->full_name;
}
public function setFull_name($full_name)
{
$this->full_name = $full_name;
return $this;
}
public function getEmail()
{
return $this->email;
}
public function setEmail($email)
{
$this->email = $email;
return $this;
}
public function getDob()
{
return $this->dob;
}
public function setDob($dob)
{
$this->dob = $dob;
return $this;
}
public function getAdresse()
{
return $this->adresse;
}
public function setAdresse($adresse)
{
$this->adresse = $adresse;
return $this;
}
public function getPassword()
{
return $this->password;
}
public function setPassword($password)
{
$this->password = $password;
return $this;
}
/*public function getConfirmation_token()
{
return $this->confirmation_token;
}
public function setConfirmation_token($confirmation_token)
{
$this->confirmation_token = $confirmation_token;
return $this;
}
public function getConfirmation_at()
{
return $this->confirmation_at;
}
public function setConfirmation_at($confirmation_at)
{
$this->confirmation_at = $confirmation_at;
return $this;
}
public function getReset_token()
{
return $this->reset_token;
}
public function setReset_token($reset_token)
{
$this->Reset_token = $reset_token;
return $this;
}
public function getReset_at()
{
return $this->reset_token;
}
public function setReset_at($reset_at)
{
$this->reset_at = $reset_at;
return $this;
}
public function getRemember_at()
{
return $this->remember_at;
}
public function setRemember_at($remember_at)
{
$this->remember_at = $remember_at;
return $this;
}*/
}
class candidat{
    private $id;
    private $id_election;
    private $username;
    private $full_name;
    private $email;
    private $dob;
    private $adresse;
    private $biography;
    private $program;
    private $political_party;
    private $image;
    private $password;

    public function __construct($id_election, $username, $full_name, $email, $dob, $adresse, $biography, $program, $political_party, $image, $password, $id=null) {
        $this->id = $id;
        $this->id_election = $id_election;
        $this->username = $username;
        $this->full_name = $full_name;
        $this->email = $email;
        $this->dob = $dob;
        $this->adresse = $adresse;
        $this->biography = $biography;
        $this->program = $program;
        $this->political_party = $political_party;
        $this->image = $image;
        $this->password = $password;
    }
    public function getId()
    {
    return $this->id;
    }
    public function setId($id)
    {
    $this->id = $id;
    return $this;
    }
    public function getId_election()
    {
    return $this->id_election;
    }
    public function setId_election($id_election)
    {
    $this->id_election = $id_election;
    return $this;
    }
public function getUsername()
{
return $this->username;
}
public function setUsername($username)
{
$this->username = $username;
return $this;
}
public function getFull_name()
{
return $this->full_name;
}
public function setFull_name($full_name)
{
$this->full_name = $full_name;
return $this;
}
public function getEmail()
{
return $this->email;
}
public function setEmail($email)
{
$this->email = $email;
return $this;
}
public function getDob()
{
return $this->dob;
}
public function setDob($dob)
{
$this->dob = $dob;
return $this;
}
public function getAdresse()
{
return $this->adresse;
}
public function setAdresse($adresse)
{
$this->adresse = $adresse;
return $this;
}
public function getBiography()
{
return $this->biography;
}
public function setBiography($biography)
{
$this->biography = $biography;
return $this;
}
public function getProgram()
{
return $this->program;
}
public function setProgram($program)
{
$this->program = $program;
return $this;
}
public function getPolitical_party()
{
return $this->political_party;
}
public function setPolitical_party($political_party)
{
$this->political_party= $political_party;
return $this;
}
public function getImage()
{
return $this->image;
}
public function setImage($image)
{
$this->image = $image;
return $this;
}
public function getPassword()
{
return $this->password;
}
public function setPassword($password)
{
$this->password = $password;
return $this;
}
}
class notification{
    private $number;

    private $userId;
    private $type;

    private $message;
    private $dateReceived;
    private $status;

    public function __construct($type,$userId, $message, $dateReceived, $status, $number=null) {
        $this->number = $number;
        $this->type = $type;
        $this->message = $message;
        $this->dateReceived = $dateReceived;
        $this->status = $status;
        $this->userId=$userId;
    }
    public function getNumber()
    {
    return $this->number;
    }

    public function getUserId()
    {
    return $this->userId;
    }
    public function setNumber($number)
    {
    $this->number = $number;
    return $this;
    }

    public function setUserId($userId)
    {
    $this->$userId = $userId;
    return $this;
    }
    public function getType()
{
return $this->type;
}
public function setType($type)
{
$this->type = $type;
return $this;
}
public function getMessage()
{
return $this->message;
}
public function setMessage($message)
{
$this->message = $message;
return $this;
}
public function getDateReceived()
{
return $this->dateReceived;
}
public function setDateReceived($dateReceived)
{
$this->dateReceived = $dateReceived;
return $this;
}
public function getStatus()
{
return $this->status;
}
public function setStatus($status)
{
$this->status = $status;
return $this;
}
}
class Onligne{
    private $id;
    private $time;

    public function __construct($time, $id=null) {
        $this->id = $id;
        $this->time = $time;
    }
    public function getId()
    {
    return $this->id;
    }
    public function setId($id)
    {
    $this->id = $id;
    return $this;
    }
    public function getTime()
{
return $this->time;
}
public function setTime($time)
{
$this->time = $time;
return $this;
}
}
class vote {
    private $id_vote;
    private $id_elector;
    private $id_candidat;
    private $id_election;
    private $voted_at;

    public function __construct($id_elector, $id_candidat, $id_election, $id_vote = null, $voted_at = null) {
        $this->id_vote = $id_vote;
        $this->id_elector = $id_elector;
        $this->id_candidat = $id_candidat;
        $this->id_election = $id_election;
        $this->voted_at = $voted_at ?? date('Y-m-d H:i:s');
    }

    public function getId_vote() {
        return $this->id_vote;
    }

    public function setId_vote($id_vote) {
        $this->id_vote = $id_vote;
        return $this;
    }

    public function getId_elector() {
        return $this->id_elector;
    }

    public function setId_elector($id_elector) {
        $this->id_elector = $id_elector;
        return $this;
    }

    public function getId_candidat() {
        return $this->id_candidat;
    }

    public function setId_candidat($id_candidat) {
        $this->id_candidat = $id_candidat;
        return $this;
    }

    public function getId_election() {
        return $this->id_election;
    }

    public function setId_election($id_election) {
        $this->id_election = $id_election;
        return $this;
    }

    public function getVoted_at() {
        return $this->voted_at;
    }

    public function setVoted_at($voted_at) {
        $this->voted_at = $voted_at;
        return $this;
    }
}
class election {
    private $id;
    private $title; // Changement de name à title
    private $start_date;
    private $end_date;
    private $is_active;

    public function __construct($title, $start_date, $end_date, $is_active = true, $id = null) {
        $this->id = $id;
        $this->title = $title; // Changement de name à title
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->is_active = $is_active;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getTitle() { // Changement de getName à getTitle
        return $this->title;
    }

    public function setTitle($title) { // Changement de setName à setTitle
        $this->title = $title;
        return $this;
    }

    public function getStart_date() {
        return $this->start_date;
    }

    public function setStart_date($start_date) {
        $this->start_date = $start_date;
        return $this;
    }

    public function getEnd_date() {
        return $this->end_date;
    }

    public function setEnd_date($end_date) {
        $this->end_date = $end_date;
        return $this;
    }

    public function getIs_active() {
        return $this->is_active;
    }

    public function setIs_active($is_active) {
        $this->is_active = $is_active;
        return $this;
    }
}

?>