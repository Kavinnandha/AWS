<?php

require 'C:/Users/Liyander/vendor/autoload.php';
use Dompdf\Dompdf;
$dompdf = new Dompdf();
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://localhost/sms/automail.php');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$html = curl_exec($ch);
curl_close($ch);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("sample.pdf", array("Attachment" => 0)); 

?>
