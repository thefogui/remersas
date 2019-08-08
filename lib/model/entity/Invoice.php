<?php

require_once "Claim.php";
require_once "Client.php";

/**
 * Class that are associated with the client Invoice
 * @package 
 * @see Client.php
 */
class Invoice {
    private $claimId;
    private $daoInvoice;
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
    private $claim;
    private $client;
    private $fee;
    private $iva;
    private $ivaType;
    private $cobradoCliente;
    private $cobradoPopuletic;
    private $cancelado_con_cargo;
    private $cuantidadFactura;
    private $conn;

    /**
     * @param $claimId
     * @param $conn
     * @throws Exception
     */
    public function __construct($claimId, $appConfig) {
        $this->claimId = $claimId;
        $this->conn = $appConfig->connect( "halbrand", "replica" );
        $this->daoInvoice = new DaoInvoice($this->conn);

        try {
            $this->getInvokeData();

            $appConfig->closeConnection($this->daoInvoice->getConn());
            $this->conn = $appConfig->connect( "populetic_form", "replica" );
            $this->daoInvoice->setConn($this->conn);

            $this->getClaim();
            $this->getClient();

            $appConfig->closeConnection($this->conn);

        } catch (Exception $e) {
            throw new Exception("Can't read the data from database: " . $e->getMessage());
        }
    }

    private function getInvokeData() {
        if (!empty($this->daoInvoke)) {
            try {
                $arrayData = $this->daoInvoice->getInvoiceData($this->claimId);
                $billingPreferenceData = $this->daoInvoice->getBillingPreferences();

                if (isset($arrayData)) {
                    $this->id = (isset($arrayData["id"]) && !empty($arrayData["id"]) ? $arrayData["id"] : "");
                    $this->serialNumber = $arrayData["serialNumber"];
                    $this->value = $arrayData["invokeValue"];
                    $this->comments = $arrayData["comments"];
                    $this->description = utf8_encode($arrayData["description"]);
                    $this->receivedDay = $arrayData["receivedDay"];
                    $this->sentDay = $arrayData["sentDay"];
                    $this->generatedDay = $arrayData["generatedDay"];
                    $this->dateAdmission = $arrayData["dateAdmission"];
                    $this->viaInvoice = utf8_encode($arrayData["viaInvoice"]);
                }

                $this->fee = $billingPreferenceData["fee"];
                $this->iva = $billingPreferenceData["iva"];
                $this->ivaType = $billingPreferenceData["ivaType"];
                $this->cobradoCliente = $billingPreferenceData["cobradoCliente"];
                $this->cobradoPopuletic = $billingPreferenceData["cobradoPopuletic"];
                $this->cancelado_con_cargo = $billingPreferenceData["cancelado_con_cargo"];
                $this->cuantidadFactura = $billingPreferenceData["cuantidadFactura"];

            } catch (Exception $e) {
                throw new Exception("Can't read the data from database: " . $e->getMessage());
            }
        }
    }

    private function getClaim() {
        try {
            $this->claim = new Claim($this->daoInvoice->getClaim($this->claimId));
        } catch (Exception $e) {
            throw new Exception("Error trying to read data from sql : " . $e->getMessage());
        }
    }

    private function getClient() {
        try {
            $this->client = Client::constructWithArray($this->daoInvoice->getClient($this->claim->getClientId()), $this->claim->getClientId());
        } catch (Exception $e) {
            throw new Exception("Error trying to read data from sql: " . $e->getMessage());
        }
    }

    private function generateText($textValues) {
        $textIva = '21 % IVA:';
        $months = $textValues["months"];
        $today = $textValues["today"];
        $serialNumber = $textValues["serialNumber"];
        $invokeNumber = $textValues["invokeNumber"];
        $invokeDate = $textValues["invokeDate"];
        $identificationDocument = $textValues["identificationDocument"];
        $amount = $textValues["amount"];
        $taxBase = $textValues["taxBase"];
        $totalBill = $textValues["totalBill"];
        $note = $textValues["note"];
        $paymentTerms = $textValues["paymentTerms"];
        $managementOfTheCompensationRequest = $textValues["managementOfTheCompensationRequest"];
        $deadline = $textValues["deadline"];
        $bank = $textValues["bank"];
        $accountNumber = $textValues["accountNumber"];
        $wireTransfer = $textValues["wireTransfer"];
    }

    private function createInvokeHeader($pdf, $textValues) {
        $pdf->Image('C:\xampp\htdocs\remesas\web\images\modelo_factura.png',15,-20,180,290,'PNG');

        $headerMarginLeft = 23;
        $headerMarginTop = 46;
        $headerLineHeight = 10;

        $pdf->SetXY($headerMarginLeft, $headerMarginTop);
        $pdf->Cell(0, $headerLineHeight, utf8_decode($textValues["serialNumber"]), 0, 1, 'J', False);

        $pdf->SetXY($headerMarginLeft + 19, $headerMarginTop);
        $pdf->Cell(0, $headerLineHeight, utf8_decode($textValues["invokeNumber"]), 0, 1, 'J', False);

        $pdf->SetXY($headerMarginLeft, 51);
        $thisYear = date('Y');
        $pdf->Cell(0, $headerLineHeight, utf8_decode($thisYear) ,0, 1, 'J', False);

        //TODO: serial number or numero de factura
        $pdf->SetXY($headerMarginLeft + 19, 51);
        $pdf->Cell(0, $headerLineHeight, utf8_decode($this->serialNumber), 0, 1, 'J', False);

        $pdf->SetXY(32, 60);
        $pdf->Cell(0,10,utf8_decode($textValues["invokeDate"]), 0, 1, 'J', False);

        $pdf->SetXY($headerMarginLeft, 65);
        $pdf->Cell(0,10,utf8_decode($textValues["today"]), 0, 1, 'J', False);// modificar data amb text

        $pdf->SetFont('Helvetica','B',10);
        $pdf->SetXY(87, 48);
        $pdf->Cell(15,10,strtoupper($this->client->getName()),0,1,'J',False);

        $pdf->SetFont('Helvetica');
        $pdf->SetXY(87, 56);
        $pdf->SetLeftMargin(87);
        $pdf->SetRightMargin(25);
        //TODO: GET ADDRESS
        //$pdf->WriteHTML(($direccion_titular_financia));

        $pdf->SetXY(39, 75);
        $pdf->SetTextColor(0,0,0);
        $pdf->Cell(20,10,utf8_decode($textValues["identificationDocument"]),0,1,'J',False);

        $pdf->SetXY(80, 75);
        $pdf->SetTextColor(0,0,0);
        $pdf->Cell(0,10,strtoupper($this->client->getNif()),0,1,'J',False);

        return $pdf;
    }

    private function createInvokeBody($pdf, $textValues) {
        //TODO: Maria
        //Importe
        $pdf->SetXY(150, 79);
        $pdf->Cell(0,10,utf8_decode($textValues["amount"]),0,1,'J',False);

        $pdf->SetXY(25, 90);
        $pdf->Cell(0,10,utf8_decode($textValues["managementOfTheCompensationRequest"]),0,1,'J',False);

        //claim name
        $pdf->SetXY(30, 95);
        $pdf->Cell(0,10,strtoupper(utf8_decode('- ' . $this->client->getName())),0,1,'J',False);

        //client amount
        $pdf->SetXY(165, 95);
        $pdf->Cell(20,10,utf8_decode(number_format($this->cobradoCliente, 2, ',', '.').' '.utf8_encode(chr(128))),0,1,'R',False);

        $pdf->SetXY(130, 153);
        $pdf->Cell(0,10,utf8_decode('Total'),0,1,'J',False);

        $pdf->SetXY(165, 153);
        $pdf->Cell(20,10,utf8_decode(number_format($this->cobradoCliente, 2, ',', '.').' '.utf8_encode(chr(128))),0,1,'R',False);


        $pdf->SetXY(115, 161);
        if ($this->claim->getLangId() == "en" || $this->claim->getLangId() == "gr") {
            $pdf->SetXY(125 , 161);
        }

        $pdf->Cell(0,10,utf8_decode($textValues["taxBase"]), 0, 1, 'J', False);

        //TODO: mirar que es base
        $pdf->SetXY(165, 160);
        $pdf->Cell(20,10,utf8_decode($this->fee.' '.utf8_encode(chr(128))),0,1,'R',False);

        $pdf->SetXY(125, 167);
        $pdf->Cell(0,10,utf8_decode($textValues["ivaText"]),0,1,'J',False);

        $pdf->SetXY(165, 167);
        $pdf->Cell(20,10,utf8_decode($this->iva.' '.utf8_encode(chr(128))),0,1,'R',False);

        $pdf->SetXY(120, 174);
        $pdf->Cell(0,10,utf8_decode($textValues["totalBill"]),0,1,'J',False);

        $pdf->SetXY(165, 174);
        $pdf->Cell(20,10, utf8_decode($this->cobradoCliente.' '.utf8_encode(chr(128))),0,1,'R',False);

        $pdf->SetXY(25, 183);
        $pdf->Cell(0,10,utf8_decode($textValues["note"]),0,1,'J',False);

        //TODO: poner comments

        $pdf->SetXY(25, 202);
        $pdf->Cell(0,10,utf8_decode($textValues["paymentTerms"]),0,1,'J',False);

        $pdf->SetXY(25, 211);
        //$pdf->Cell(0,10,utf8_decode(),0,1,'J',False); //TODO: QUE PONER AQUI

        $pdf->SetXY(92, 202);
        $pdf->Cell(0,10,utf8_decode($textValues["import"]),0,1,'J',False);



        $pdf->SetXY(105, 211);
        $pdf->SetTextColor(0,0,0);
        $pdf->Cell(0,10,utf8_decode($this->cobradoCliente.' '.utf8_encode(chr(128))),0,1,'J',False);

        $pdf->SetXY(150, 202);
        $pdf->SetTextColor(0,0,0);
        $pdf->Cell(0,10,utf8_decode($textValues["deadline"]),0,1,'J',False);

        $pdf->SetXY(153, 211);
        $pdf->Cell(0,10,utf8_decode(date('d/m/Y')),0,1,'J',False);

        $pdf->SetXY(25, 221);
        $pdf->Cell(0,10,utf8_decode($textValues["bankText"]),0,1,'J',False);

        $pdf->SetXY(25, 230);
        $pdf->SetTextColor(0,0,0);
        $pdf->Cell(0,10,utf8_decode($textValues["bank"]),0,1,'J',False);

        $pdf->SetXY(92, 221);
        $pdf->SetTextColor(0,0,0);
        $pdf->Cell(0,10,utf8_decode($textValues["accountNumberText"]),0,1,'J',False);

        $pdf->SetXY(92, 230);
        $pdf->SetTextColor(0,0,0);
        $pdf->Cell(0,10,utf8_decode($textValues["accountNumber"]),0,1,'J',False);

        return $pdf;
    }

    private function createInvokeFooter($pdf) {
        $footerMarginLeft = 25;
        $footerMarginTop = 250;
        $footerLineHeight = 10;
        
        $enterpriseName = "Customer Care Technologies, SL";
        $enterpriseAddress1 = "Rambla Ibéria, 97";
        $enterpriseAddress2 = "08205 Sabadell";
        $enterpriseCif = "CIF: B66546425";

        $pdf->SetXY($footerMarginLeft, $footerMarginTop);
        $pdf->Cell(0, $footerLineHeight, utf8_decode($enterpriseName), 0, 1, 'J', False);
        $pdf->SetXY($footerMarginLeft, $footerMarginTop + 5);
        $pdf->Cell(0, $footerLineHeight, utf8_decode($enterpriseAddress1), 0, 1, 'J', False);
        $pdf->SetXY($footerMarginLeft, $footerMarginTop + 10);
        $pdf->Cell(0, $footerLineHeight,utf8_decode($enterpriseAddress2), 0, 1, 'J', False);
        $pdf->SetXY($footerMarginLeft, $footerMarginTop + 15);
        $pdf->Cell(0, $footerLineHeight, utf8_decode($enterpriseCif), 0, 1, 'J', False);

        return $pdf;
    }

    public function createInvoke($pdf, $textValues) {
        // ( dirname(__FILE__) . '/../../../plugins/fpdf/fpdf.php');
        //$pdf = new PDF();
        $pdf->AddPage();

        //define the font
        $pdf->SetFont('Helvetica');
        $pdf->SetFontSize(10);
        $pdf->SetTextColor(0,0,0);

        $pdf = $this->createInvokeHeader($pdf, $textValues);
        $pdf = $this->createInvokeBody($pdf, $textValues);
        $pdf = $this->createInvokeFooter($pdf);

        return $pdf;
    }
}