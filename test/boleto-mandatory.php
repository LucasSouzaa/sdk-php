<?php
require_once "../lib/maxipago/Autoload.php";
require_once "../lib/maxiPago.php";

try {

    $maxiPago = new maxiPago;

    // Before calling any other methods you must first set your credentials
    $maxiPago->setCredentials("100", "merchant_key");

    $maxiPago->setDebug(true);
    $maxiPago->setEnvironment("TEST");
    $data = array(
        "processorID" => "12", // REQUIRED - Use 12 for testing. For production values contact our team //
        "referenceNum" => "TestBoleto123", // REQUIRED - Merchant's internal order number //
        "chargeTotal" => "10.00", // REQUIRED - US format: 10.00 or 1234.56 //
        "bname" => "Fulano de Tal", // REQUIRED - Customer name //
        "number" => time(), // REQUIRED AND UNIQUE - Boleto ID number, max of 8 numbers //
        "expirationDate" => "2020-12-25", // REQUIRED - Boleto expiration date, YYYY-MM-DD format //
        "instructions" => "Sr. Caixa, não receber após vencimento.;Não receber pagamento com cheque.", // Optional - Instructions to be printed with the boleto. Use ";" to break lines //
    );
    $maxiPago->boletoSale($data);

    if ($maxiPago->isErrorResponse()) {
        echo "There was an error creating the boleto<br>Error message: ".$maxiPago->getMessage();
    }

    elseif ($maxiPago->isTransactionResponse()) {
        if ($maxiPago->getResponseCode() == "0") { echo "Boleto has been created<br><a href='".$maxiPago->getBoletoURL()."' target='_blank'>Click here</a> to view boleto."; }
        else { echo "There was an error creating the boleto<br>Error message: ".$maxiPago->getMessage(); }    
    }

}

catch (Exception $e) { echo $e->getMessage()." in ".$e->getFile()." on line ".$e->getLine(); }
?>