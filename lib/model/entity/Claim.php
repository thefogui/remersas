<?php

class Claim {
    private $ref;
    private $stateId;
    private $langId;
    private $amountClient;
    private $clientId;

    public function __construct($values) {
        $this->setValuesFromArray($values);
    }

    public function setValuesFromArray($values) {
        $this->ref = $values["ref"];
        $this->stateId = $values["stateId"];
        $this->langId = $values["langId"];
        $this->amountClient = $values["amountClient"];
        $this->clientId = $values["clientId"];
    }

    /**
     * @return mixed
     */
    public function getRef() {
        return $this->ref;
    }

    /**
     * @param mixed $ref
     */
    public function setRef($ref) {
        $this->ref = $ref;
    }

    /**
     * @return mixed
     */
    public function getStateId() {
        return $this->stateId;
    }

    /**
     * @param mixed $stateId
     */
    public function setStateId($stateId) {
        $this->stateId = $stateId;
    }

    /**
     * @return mixed
     */
    public function getLangId() {
        return $this->langId;
    }

    /**
     * @param mixed $langId
     */
    public function setLangId($langId) {
        $this->langId = $langId;
    }

    /**
     * @return mixed
     */
    public function getAmountClient() {
        return $this->amountClient;
    }

    /**
     * @param mixed $amountClient
     */
    public function setAmountClient($amountClient) {
        $this->amountClient = $amountClient;
    }

    /**
     * @return mixed
     */
    public function getClientId() {
        return $this->clientId;
    }

    /**
     * @param mixed $clientId
     */
    public function setClientId($clientId) {
        $this->clientId = $clientId;
    }
}