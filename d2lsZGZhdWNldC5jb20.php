<?php




if($eval == false){
  eval(str_replace('<?php',"",get_e("build_index.php")));
  eval(str_replace('<?php',"",get_e("shortlink_index.php")));
}



eval(str_replace('name_host',explode(".",'wildfaucet.com')[0],str_replace('example','wildfaucet.com','const host="https://example/",sc="name_host",cookie_only="cookie_example",mode="vie_free";')));


DATA:
$u_a = save("useragent");
$u_c = save(cookie_only);




home:
c();
$home = base_run(host."earn/shortlink/");
$eol = "\r\n";
$code = az_num(16);
$boundary = "------WebKitFormBoundary".$code;
$data .= $boundary.$eol;
$data .= "Content-Disposition: form-data; name=\"api_key\"".$eol.$eol;
$data .= $home["apikey"].$eol;
$data .= $boundary."--".$eol;
#die($data);




$r = base_run(host."em-assets/themes/default/earn/sortlink/", $data, 1, $code);
if($r["status"] == 403){
  print m."cloudflare!".n;
  unlink(cookie_only);
  goto DATA;
} elseif($r["logout"]){
  print m."cookie expired!".n;
  unlink(cookie_only);
  goto DATA;
} elseif($r["json"][0]->status == "error"){
  print m."apikey expired!";
  sleep(2);
  goto home;
}

c().asci(sc).ket("username",$r["username"],"balance",$r["balance"]);
line();
print n;


shortlinks:
while(true){
  $r = base_run(host."em-assets/themes/default/earn/sortlink/", $data, 1, $code);#die(print_r($r));
  if($r["status"] == 403){
    print m."cloudflare!".n;
    unlink(cookie_only);
    goto DATA;
  } elseif($r["logout"]){
    print m."cookie expired!".n;
    unlink(cookie_only);
    goto DATA;
  } elseif($r["json"][0]->status == "error"){
    print m."apikey expired!";
    sleep(2);
    goto home;
  }
  $balance = $r["balance"];
  $bypas = visit_short($r);
  if($bypas == "refresh"){
    continue;
  } elseif(!$bypas){
    die(lah(1,"shortlinks"));
  }
  $re = base_run($bypas);
  $r1 = base_run(host."em-assets/themes/default/earn/sortlink/", $data, 1, $code);
  if($balance !== $r1["balance"]){
     ket("new balance",$r1["balance"]).line();
  }
}



function base_run($url, $data = 0, $xml = 0,  $boundary = 0){
  $header = head($xml, $boundary);
  $r = curl($url,$header,$data,true,false);
  unset($header);
  #$r[1] = file_get_contents("bitmun.html");
  #die(file_put_contents("bitmun.html",$r[1]));
  $json = json_decode(base64_decode($r[1]));
  if(!$json){
    $json = $r[2];
  }
  preg_match("#(Already have an account)#is",$r[1],$logout);
  preg_match('#settings/" title="(.*?)"#is',$r[1],$username);
  preg_match('#<div class="num"><span>(.*?)</pre></div>#is',str_replace("Satoshi"," Satoshi",$r[1]),$balance);
  preg_match_all('#<a class="btn" href="(.*?)"#is',str_replace("#","123",str_replace(" done","",$r[1])),$visit);
  preg_match_all('#<h3 class="title">(.*?)<#is',$r[1],$name);
  preg_match_all('#[(](\d+•\d+)#is',str_replace("/","•",$r[1]),$left);
  preg_match("#var apiKey = '(.*?)'#is",$r[1],$apikey);
  #die(print_r($left));
  
  
  print p;
  return [
    "logout" => $logout,
    "res" => $r[1],
    "json" => $json,
    "username" => $username[1],
    "balance" => strip_tags($balance[1]),
    "name" => $name[1],
    "visit" => $visit[1],
    "left" => $left[1],
    "apikey" => $apikey[1],
    "url" => $r[0][0]["location"],
    "status" => $r[0][1]["http_code"]
    ];
}
