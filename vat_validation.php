<?php

$vatid = 'GB980780684'; // replace for the VAT-ID you would like to check

$vatid = str_replace(array(' ', '.', '-', ',', ', '), '', trim($vatid));
$cc = substr($vatid, 0, 2);
$vn = substr($vatid, 2);
$client = new SoapClient("http://ec.europa.eu/taxation_customs/vies/checkVatService.wsdl");

if($client){
    $params = array('countryCode' => $cc, 'vatNumber' => $vn);
    try{
        $r = $client->checkVat($params);
        if($r->valid == true){
            // VAT-ID is valid
            foreach($r as $k=>$prop){
                echo "<pre>".$k . ': ' . $prop;
            }
        } else {
            // VAT-ID is NOT valid
            echo "Not Valid";
        }

        // This foreach shows every single line of the returned information

    } catch(SoapFault $e) {
        echo 'Error, see message: '.$e->faultstring;
    }
} else {
    // Connection to host not possible, europe.eu down?
}
