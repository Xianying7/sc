<?php


if($eval == false){
  eval(str_replace('<?php',"",get_e("build_index.php")));
  eval(str_replace('<?php',"",get_e("shortlink_index.php")));
}

go_home:
c();
$web = [
  "cryptofuture.co.in",
  "freeltc.fun",
  "earnsolana.xyz",
  "claim88.fun",
  "earncryptowrs.in",
  "onlyfaucet.com",
  "claimcoins.net",
  "doge25.in",
  ];
  
for($i=0;$i<count($web);$i++){
  if($web[$i]){
    ket($i+1,$web[$i]);
  }
}

$p = preg_replace("/[^0-9]/","",trim(tx("number")));
$host = $web[$p-1];
if(!$host){
  goto go_home;
}

if($host == "onlyfaucet.com" || $host == "claimcoins.net"){
  $cancel = 1;
}

eval(str_replace('name_host',explode(".",$host)[0],str_replace('example',$host,'const host="https://example/",sc="name_host",cookie_only="cookie_example",mode="vie_free";')));
#die(print_r(curl($url,["referer:".$referer],0,true)));


DATA:
$email = save("email");
#<a href="https://claimcoins.net/links/currency/ltc"
$r = base_run(host);//die(print_r($r));
if($r["status"] == 403){
  die(m."banned IP please airplane mode for a moment");
} elseif(!$r["login"]){
  goto home;
}
$t = $r["token"];
$array = array("wallet" => $email);
$data = data_post($t, "null", $array);
$r = base_run(host."auth/login", $data);
if($r["login"]){
  unlink(cookie_only);
  goto DATA;
}
print $r["notif"];r();
      
      
home:
if($host == "claimcoins.net"){
  $link = "https://claimcoins.net/links/currency/ltc";
  goto bn;
}
ket(1, "shortlinks", 2, "faucet");
$pil = preg_replace("/[^0-9]/","",trim(tx("number")));
if($pil == 1){
  $type = "links";
} elseif($pil == 2){
  $type = "faucet";
} else {
  goto home;
}

go:
for($i=0;$i<count($r[$type][0]);$i++){
  if($r[$type][0][$i]){
    ket($i+1,$r[$type][0][$i]);
  }
}

$p = preg_replace("/[^0-9]/","",trim(tx("number")));
$host = $r[$type][0][$p-1];
if(!$host){
  goto go;
}
$link = $r[$type][1][$p-1];
bn:
c().asci(sc).ket("email",$email,"type",$host).line();
if($pil == 1){
  goto links;
} elseif($pil == 2){
  die("cooming soon");
}

links:
while(true){
  $r1 = base_run($link);#die(print_r($r1));
  if($r1["status"] == 403){
  die(m."banned IP please airplane mode for a moment");
  } elseif($r1["login"]){
    unlink(cookie_only);
    goto DATA;
  } elseif($r1["empty"]){
    print m."devnya Rungkat ganti coin aja".n;
    goto go;
  }
  $t = time()+90;
  $bypass = visit_short($r1, $cancel);
  if($bypass == "refresh" || $bypass == "skip"){
     continue;
   } elseif(!$bypass){
     $r1 = base_run($link);
     if($r1["login"]){
       continue;
     }
     lah(2,"shortlinks");
     if($host == "claimcoins.net"){
       exit;
     }
     goto home;
   }
   $t1 = time();
   if($t - $t1 >= 1){
     L($t - $t1);
   }
   $r1 = base_run($bypass);
   if($r1["login"]){
     continue;
   } 
   if(preg_match("#(suc|sent)#is",$r1["notif"])){
     text_line(h.$r1["notif"]);
   } else {
     print m.$r1["notif"];
     r();
   }
}


      




function base_run($url, $data = 0){
  $header = ["user-agent: ".user_agent()];
  $r = curl($url,$header,$data,true,cookie_only);
  unset($header);
  #$r[1] = file_get_contents("response_body.html");
  #die(file_put_contents("bitmun.html",$r[1]));
  $json = json_decode(base64_decode($r[1]));
  if(!$json){
    $json = $r[2];
  }
  preg_match("#(>Login<|Enter Your Faucet)#is",$r[1],$login);
  preg_match("#empty<#is",$r[1],$empty);
  preg_match_all('#<input type="hidden" name="(.*?)" id="token" value="(.*?)">#is',str_replace('name="anti','',$r[1]),$token);
  preg_match_all('#(title|html):(.*?)(,)#is',str_replace("'","",$r[1]),$nn);
  if(preg_match_all('#<a class="(collapse-item|dropdown-item)" href="(.*?)">(.*?)</a>#is',$r[1],$coin)){
    for($i = 0;$i<=count($coin[2]);$i++){
      if(preg_match("#(link)#is",$coin[3][$i])){
        $links[] = $coin[2][$i];
        $tl[] = $coin[3][$i];
      } else {
        $faucet[] = $coin[2][$i];
        $tf[] = $coin[3][$i];
      }
    }
    $methode["links"]= [array_filter($tl),array_filter($links)];  
    $methode["faucet"] = [array_filter($tf),array_filter($faucet)];
  } else {
    $methode = [1=>2];
  }
  preg_match_all('#[a-z]*:\/\/[a-zA-Z0-9\/-\/.-]*\/go\/?[a-zA-Z0-9\/-\/.]*#is',$r[1],$visit);
  preg_match_all('#>(\d+\/+\d+)#is',trimed($r[1]),$left);
  preg_match_all('#class="card-title mt-0">(.*?)<#is',str_replace('mt-0">Your',"",$r[1]),$name);
  #die(print_r($name));
  
  
   print p;
   return array_merge([
     "r" => $r[0][2],
     "login" => $login[0],
     "empty" => $empty[0],
     "res" => $r[1],
     "token" => $token,
     "name" => $name[1],
     "visit" => $visit[0],
     "left" => $left[1],
     "url1" => $r[0][0]["location"],
     "notif" => $nn[2][0].$nn[2][1]
     ], $methode);
}

