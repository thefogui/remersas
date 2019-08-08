<?php

require_once "../../lib/model/dao/DaoInvoice.php";
require_once "../../lib/model/entity/Invoice.php";
require_once "../../config/config.php";
require_once "../../plugins/fpdf/fpdf.php";

class InvoiceTest {
    function getPdf() {
        echo "-------------------------------------------";
        echo "<br>";

        $claimId = "507";
        $appConfig = new AppConfig();
        $invoice = new Invoice($claimId, $appConfig);

        $pdf = new fpdf();

        $textValues = array();

        $textValues["months"] = array("January","February","March","April","May","June","July","August","September","October","November","December");
        $textValues["today"] = date("Y-d-m");
        $textValues["serialNumber"] = 'Serial no.';
        $textValues["invokeNumber"] = 'No. Invoice';
        $textValues["invokeDate"] = 'Invoice date';
        $textValues["identificationDocument"] = 'Identification document:';
        $textValues["amount"] = 'Amount';
        $textValues["taxBase"] = 'Tax base:';
        $textValues["import"] = 'Import';
        $textValues["totalBill"] = 'Total invoice:';
        $textValues["note"] = 'Observations';
        $textValues["ivaText"] = '21 % IVA:';
        $textValues["paymentTerms"] = 'Payment conditions';
        $textValues["managementOfTheCompensationRequest"] ='Claim management';
        $textValues["deadline"] = 'Expiration';
        $textValues["bank"] = 'Bankinter';
        $textValues["bankText"] = 'Banking entity';
        $textValues["accountNumber"] = 'ES90 0128 0534 1101 0004 0551 // BKBKESMMXXX';
        $textValues["accountNumberText"] = 'No. Account // SWIFT';
        $textValues["wireTransfer"] = 'Transfer';

        $pdf = $invoice->createInvoke($pdf, $textValues);
        $pdf->Output( "test.pdf", "F");
    }
}
$invoiceTest = new InvoiceTest();
$invoiceTest ->getPdf();
