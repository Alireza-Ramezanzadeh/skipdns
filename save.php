<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ذخیره اطلاعات</title>
</head>
<body>
<?php
function getName($n = 5)  {
	    $characters = 'abcdefghijklmnopqrstuvwxyz';
	        $randomString = '';
	      
	        for ($i = 0; $i < $n; $i++) {
			        $index = rand(0, strlen($characters) - 1);
				        $randomString .= $characters[$index];
				    }
		  
		    return $randomString;
}

$servername = "localhost";
$username = "user1";
$password = "password1";
$dbname = "mydb1";

$ip = $_POST['ip'];
$domain = $_POST['domain'];
$tmpdomain = getName();

#$tmpdomain = "pnlxf";
#$mysqli = new mysqli($servername, $username, $password, $dbname);
#$result = $mysqli->query("SELECT domain FROM MyData WHERE tmpdomain = 'pnlxf' ;");

#while($result->num_rows == 1) {
#	$tmpdomain = getName();
#	$result = 0;
#	$result = $mysqli->query("SELECT domain FROM MyData WHERE tmpdomain = 'pnlxf' ;");
#}	
	
#$mysqli->close();


echo $tmpdomain;
echo "<br>";
echo $ip;
echo "<br>";
echo $domain;
echo "<br>";


#add A record in cloudflare:

/* Cloudflare.com | APİv4 | Api Ayarları */
    $apikey = 'd0205ce5da32837b3a19837442fa11ae160f1'; // Cloudflare Global API
    $email = 'ramezanzadeh.programer@gmail.com'; // Cloudflare Email Adress
#    $domain = 'a-ramezanzadeh.ir';  // zone_name // Cloudflare Domain Name
    $zoneid = 'e531c04baa1ced2d0a7879622a28408b'; // zone_id // Cloudflare Domain Zone IDa
    $myip = "185.50.37.22";


    $ch = curl_init("https://api.cloudflare.com/client/v4/zones/".$zoneid."/dns_records");
    curl_setopt($ch, CURLOPT_URL, 'https://api.cloudflare.com/client/v4/zones/e531c04baa1ced2d0a7879622a28408b/dns_records');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"type\":\"A\",\"name\":\"".$tmpdomain."\",\"content\":\"".$myip."\",\"ttl\":120,\"proxied\":true  }");
    #curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"type\":\"A\",\"name\":\"".$tmpdomain."\",\"content\":\"185.50.37.22"\",\"ttl\":120 ,\"proxied\":true}");
    # curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"type\":\"A\",\"name\":\"".$tmpdomain."\",\"content\":\"185.50.37.22"\",\"ttl\":120 ,\"proxied\":true  }");
    #curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"type\":\"A\",\"name\":\"".$tmpdomain."\",\"content\":\"185.50.37.22"\",\"ttl\":120 ,\"proxied\":true  }");
    #curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"type\":\"A\",\"name\":\"".$tmpdomain."\",\"content\":\"185.50.37.22"\",\"ttl\":120}");


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
#
#

#rename conf file:
copy("/var/www/html/reverse.conf" , "confs-nginx/{$domain}.conf");

$file = "confs-nginx/{$domain}.conf";
file_put_contents($file,str_replace('domain.com',$domain,file_get_contents($file)));
file_put_contents($file,str_replace('temp',$tmpdomain,file_get_contents($file)));
file_put_contents($file,str_replace('95.216.55.229',$ip,file_get_contents($file)));
file_put_contents($file,str_replace('server_name_var',$tmpdomain,file_get_contents($file)));



$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset("utf8");
$sql = "INSERT INTO `MyData`(`ip`, `domain` , `tmpdomain`) VALUES ('$ip' , '$domain' , '$tmpdomain')" ;
if ($conn->query($sql) === TRUE) {
   echo "Saved!";
} else {
    echo "was problem!";
}
$conn->close();


?>
</body>
</html>
