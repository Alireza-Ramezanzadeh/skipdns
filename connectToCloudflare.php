<?php
    $apikey = 'd0205ce5da32837b3a19837442fa11ae160f1'; // Cloudflare Global API
    $email = 'ramezanzadeh.programer@gmail.com'; // Cloudflare Email Adress
    $domain = 'a-ramezanzadeh.ir';  // zone_name // Cloudflare Domain Name
    $zoneid = 'e531c04baa1ced2d0a7879622a28408b'; // zone_id // Cloudflare Domain Zone ID
    
    
$ch = curl_init("https://api.cloudflare.com/client/v4/zones/".$zoneid."/dns_records");
curl_setopt($ch, CURLOPT_URL, 'https://api.cloudflare.com/client/v4/zones/e531c04baa1ced2d0a7879622a28408b/dns_records');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"type\":\"A\",\"name\":\"aaaaa\",\"content\":\"127.0.0.1\",\"ttl\":120}");

$headers = array();
$headers[] = 'X-Auth-Email: ramezanzadeh.programer@gmail.com';
$headers[] = 'X-Auth-Key: d0205ce5da32837b3a19837442fa11ae160f1';
$headers[] = 'Content-Type: application/json';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
	    echo 'Error:' . curl_error($ch);
}
curl_close($ch);

?>

