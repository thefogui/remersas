<?php 

/**
 * Class that are associated with the client Invoice
 * @package 
 * @see Client.php
 */
class Invoice {
    private $claimId;
    private $daoInvoke;
    private $id;
    private $serialNumber;
    private $value;
    private $viaInvoice;
    private $dateAdmission;
    private $generatedDay;
    private $sentDay;
    private $receivedDay;
    private $description;
    private $comments;

    public function __construct($claimId, $conn) {
        $this->claimId = $claimId;
        $this->daoInvoke = new DaoInvoke($conn);
        try {
            $this->getInvokeData();
            $this->getClaimData();
        } catch (Exception $e) {
            throw new \mysql_xdevapi\Exception("Can't read the data from database: " . $e->getMessage());
        }
    }

    private function getInvokeData() {
        if (!empty($this->daoInvoke)) {
            try {
                $arrayData = $this->daoInvoke->getInvokeData($this->claimId);
            } catch (Exception $e) {
                throw new \mysql_xdevapi\Exception("Can't read the data from database: " . $e->getMessage());
            }
        }

        if (isset($arrayData)) {
            $this->id = (isset($arrayData["id"]) && !empty($arrayData["id"]) ? $arrayData["id"] : "");
            $this->serialNumber = $arrayData["serialNumber"];
            $this->value = $arrayData["invokeValue"];
            $this->comments = $arrayData["comments"];
            $this->description = $arrayData["description"];
            $this->receivedDay = $arrayData["receivedDay"];
            $this->sentDay = $arrayData["sentDay"];
            $this->generatedDay = $arrayData["generatedDay"];
            $this->dateAdmission = $arrayData["dateAdmission"];
            $this->viaInvoice = $arrayData["viaInvoice"];
        }
    }

    public function __toString() {
        return "";
    }

    private function getClaimData() {

    }
}