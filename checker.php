<?php
set_time_limit(0);

define(ARQUIVO, "proxy.txt");

$proxy_data = fopen(ARQUIVO, "r");
$proxy_select = fread($proxy_data, filesize(ARQUIVO));
fclose($proxy_data);

$proxy_array = explode("\n", $proxy_select);

for($x = 0; $x < count($proxy_array); $x++){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://google.com");
    curl_setopt($ch, CURLOPT_PROXY, trim($proxy_array[$x]));
    curl_setopt($ch, CURLOPT_TIMEOUT, 8);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.181 Safari/537.36');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);

    $data = curl_exec($ch);
    flush();
    ob_flush();
    
    if(strpos($data, "301 Moved") !== false){
        echo "PROXY BOA ".$proxy_array[$x]."\n";
    }

}
exit;



?>