<?php


if($eval == false){
  eval(str_replace('<?php',"",get_e("build_index.php")));
  eval(str_replace('<?php',"",get_e("shortlink_index.php")));
}

eval(str_replace('name_host',explode(".","freeltc.fun")[0],str_replace('example','freeltc.fun','const host="https://example/",sc="name_host",cookie_only="cookie_example",mode="vie_free";')));


DATA:
$email = save("email");;
  
$r = base_run(host);
if(!$r["login"]){
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

c().asci(sc).ket("email",$email,"type",$host).line();
if($pil == 1){
  goto links;
} elseif($pil == 2){
  die("cooming soon");
}

links:
while(true){
  $r1 = base_run($link);
  if($r1["login"]){
    unlink(cookie_only);
    goto DATA;
  } elseif(!$r1["ready"]){
    print m."devnya Rungkat ganti coin aja".n;
    goto go;
  }
  $bypass = visit_short($r1);
  if($bypass == "refresh"){
     continue;
   } elseif(!$bypass){
     $r1 = base_run($link);
     if($r1["login"]){
       continue;
     }
     goto home;
   }
   $r1 = base_run($bypass);
   if($r1["login"]){
     continue;
   } 
   if(preg_match("#suc#is",$r1["notif"])){
     text_line(h.$r1["notif"]);
   } else {
     print m.$r1["notif"];
     r();
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
  preg_match("#Enter Your Faucet#is",$r[1],$login);
  preg_match("#Ready<#is",$r[1],$ready);
  preg_match_all('#<input type="hidden" name="(.*?)" id="token" value="(.*?)">#is',str_replace('name="anti','',$r[1]),$token);
  preg_match_all('#(title|html):(.*?)(,)#is',str_replace("'","",$r[1]),$nn);
  if(preg_match_all('#<a class="collapse-item" href="(.*?)">(.*?)</a>#is',$r[1],$coin)){
    for($i = 0;$i<=count($coin[1]);$i++){
      if(preg_match("#(link)#is",$coin[2][$i])){
        $links[] = $coin[1][$i];
        $tl[] = $coin[2][$i];
      } else {
        $faucet[] = $coin[1][$i];
        $tf[] = $coin[2][$i];
      }
    }
    $methode["links"]= [array_filter($tl),array_filter($links)];  
    $methode["faucet"] = [array_filter($tf),array_filter($faucet)];
  } else {
    $methode = [1=>2];
  }
  preg_match_all('#[a-z]*:\/\/[a-zA-Z0-9\/-\/.-]*\/go\/?[a-zA-Z0-9\/-\/.]*#is',$r[1],$visit);
  preg_match_all('#>(\d+\/+\d+)#is',trimed($r[1]),$left);
  preg_match_all('#class="card-title mt-0">(.*?)<#is',$r[1],$name);
  #die(print_r($name));
  
  
   print p;
   return array_merge([
     "login" => $login[0],
     "ready" => $ready[0],
     "res" => $r[1],
     "token" => $token,
     "name" => $name[1],
     "visit" => $visit[0],
     "left" => $left[1],
     "url1" => $r[0][0]["location"],
     "notif" => $nn[2][0].$nn[2][1]
     ], $methode);
}
  
