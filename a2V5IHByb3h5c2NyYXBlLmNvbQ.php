<?php

if($eval == false){
  eval(str_replace('<?php',"",get_e("build_index.php")));
  eval(str_replace('<?php',"",str_replace("L(90)","L(30)",get_e("shortlink_index.php"))));
}

$cookie = tx("proxyscrape");
c();
$h = [
  "user-agent: Mozilla/5.0",
  "cookie: ".$cookie
  ];

$r = curl("https://dashboard.proxyscrape.com/services/premium/proxy-list/",$h)[0][0];
$r = curl($r["location"],$h)[1];
preg_match("#sessionid=(.*?)&#is",$r,$key);
if($key[1]){
  file_put_contents("key_scrape", $key[1]);
  print h."succes save key to file key_scrape".n;
} else {
  print m."invalid save key to file key_scrape".n;
}
die();
