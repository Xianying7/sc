<?php


if($eval == false){
  eval(str_replace('<?php',"",get_e("build_index.php")));
  eval(str_replace('<?php',"",str_replace("L(90)","L(30)",get_e("shortlink_index.php"))));
}

eval(str_replace('name_host',explode(".","claimfreetrx.online")[0],str_replace('example',"claimfreetrx.online",'const host="https://example/",sc="name_host",cookie_only="cookie_example",mode="vie_free";')));


DATA:
$u_a = save("useragent");
$email = save("email");
if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
  print m."Invalid email format";
  sleep(2);
  r();
  unlink($email);
  goto DATA;
}

c().asci(sc).ket("email",$email);
line();
print n;
while(true){
  $r = base_run(host);
  if($r["login"]){
    $cap = multibot("recaptchav2",$r["recaptcha"],host);
    $t = $r["token"];
    $data = http_build_query([
        $t[1][0] => $t[2][0],
        "address" => $email,
        "antibotlinks" => "",
        "captcha" => "recaptcha",
        "g-recaptcha-response" => $cap,
        "login" => "Verify Captcha"
        ]);
  }
  if(0.00000007 >= $r["balance"]){
    die(m."devnya Rungkat".n);
  }
#die($data);
  $r = base_run(host, $data);
  if(!$r["hash"]){
    continue;
  }
  $r = base_run(host.$r["hash"]);
  if($r["hash"]){
    continue;
  }
  ket("",$r["url"]);
  $bypass = bypass_shortlinks($r["url"]);
  if(!$bypass){
    continue;
  }
  if(preg_match("#".host."#is",$bypass)){
    
  $r = base_run($bypass);
  if(preg_match("#sent#is",$r["notif"])){
    print h.$r["notif"].n;
    line();
    tmr(1, 70);
  }
}

}
function base_run($url, $data = 0){
  $header = head();
  $r = curl($url,$header,$data,true,cookie_only);
  unset($header);
  #$r[1] = file_get_contents("response_body.html");
  #die(file_put_contents("bitmun.html",$r[1]));
  $json = json_decode(base64_decode($r[1]));
  if(!$json){
    $json = $r[2];
  }
  preg_match("#login#is",$r[1],$login);
  preg_match("#Balance: (.*?)<#is",$r[1],$balance);
  preg_match_all('#<input type="hidden" name="(.*?)" value="(.*?)">#is',$r[1],$token);
  #die(print_r($token));
  preg_match('#g-recaptcha" data-sitekey="(.*?)"#is',$r[1],$recaptcha);
  preg_match("#location[)].attr[(]'href','(.*?)'#is",$r[1],$hash);
  preg_match('#class="(fas fa-money-bill-wave|xxx)">(.*?)</a>#is',$r[1],$nn);
  preg_match("#wait (\d+)#is",$r[1],$tmr);
  #die(print_r($tmr));
  #You have to wait 1 minute
  
   print p;
   return [
     "login" => $login[0],
     "balance" => $balance[1],
     "res" => $r[1],
     "token" => $token,
     "recaptcha" => $recaptcha[1],
     "hash" => $hash[1],
     "url" => $r[0][0]["location"],
     "notif" => ltrim(strip_tags($nn[2]))
     ];
}
