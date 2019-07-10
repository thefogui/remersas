<?php

/**
 * Class that saves one url sent to the client
 * 
 * @package
 */
class UrlClient {
    private $id;
    private $hash;
    private $expireDate;
    private $active;
    private $email;

    public function __construct($id, $expireDate, $email) {
        $this->id = $id;
        $this->expireDate = $expireDate;
        $this->active = 1;
        $this->email = $email;
        $this->generateHash();
    }

    /**
     * Function to generate the hash that are going to be used to check if 
     * the url is valid 
     * 
     */
    public function generateHash() {
        $this->hash = base64_encode(bin2hex($this->expireDate . "id=" .  $this->id));
    }

    /**
     * Function to get the expire date from hash url
     * 
     */
    public function hashToActualData() {
        $uncriptedHash = hex2bin(base64_decode($this->hash));

        $uncriptedHash = str_replace("id=" .  $this->id, "", $uncriptedHash);
        
        return $uncriptedHash;
    }

    /**
     * return true if the hash is similar a hash passed by parameter false otherwise
     */
    private function checkHash($hash) {
        return $this->hash == $hash;
    }

    /**
     * Function to check the expire date of the actual url
     * 
     * @return true if the url still valid and false otherwise
     */
    public function checkExpireDate () {
        $date1 = $this->expireDate; 
        $date2 = date('Y-m-d H:i:s'); 
  
        // Use strtotime() function to convert 
        // date into dateTimestamp 
        $dateTimestamp1 = strtotime($date1); 
        $dateTimestamp2 = strtotime($date2); 
    
        // Compare the timestamp date  
        return $dateTimestamp1 > $dateTimestamp2;
    }

    /**
     * Function to return the actual url params
     * email=<email>&hash=<hash>
     * 
     * @return string value that contains the email and the hash
     */
    public function getUrl() {
        $urlParams = 'email=' . $this->email . '&' . 'hash=' . $this->hash;
        return $urlParams;
    }

    /**
     * Get the value of hash
     * 
     */ 
    public function getHash() {
        return $this->hash;
    }

    /**
     * Set the value of url
     *
     * @return  self
     */ 
    public function setHash($hash) {
        $this->hash = $hash;

        return $this;
    }

    /**
     * Get the value of id
     */ 
    public function getId() {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id) {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of expireDate
     */ 
    public function getExpireDate() {
        return $this->expireDate;
    }

    /**
     * Set the value of expireDate
     *
     * @return  self
     */ 
    public function setExpireDate($expireDate) {
        $this->expireDate = $expireDate;

        return $this;
    }
}