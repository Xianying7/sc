<?php



if($eval == false){
  eval(str_replace('<?php',"",get_e("build_index.php")));
  eval(str_replace('<?php',"",get_e("shortlink_index.php")));
}


go:
c();
$web = [
  1 => "ltchunt.com",
  2 => "btccanyon.com",
  3 => "nevcoins.club",
  4 => "claimbits.net",
  5 => "rushbitcoin.com",
  6 => "bits-claimer.com",
  7 => "claimfreecoins.cc",
  8 => "faucetofbob.xyz",
  9 => "litecoinbits.com",
  10 => "earnbitmoon.xyz"
];
for($i=1;$i<count($web)+1;$i++){
  if($web[$i]){
    ket($i,$web[$i]);
  }
}
$p = preg_replace("/[^0-9]/","",trim(tx("number")));
$host = $web[$p];
if(!$host){
  goto go;
}

eval(str_replace('name_host',explode(".",$host)[0],str_replace('example',$host,'const host="https://example/",sc="name_host",cookie_only="cookie_example",mode="icon";c();')));

DATA:
$u_a = save("useragent");
$u_c = save(cookie_only);

home:
c();
$home = base_run(host."ptc.html");#die(print_r($home));
if($home["status"] == 403){
  print m."cloudflare!".n;
  unlink(cookie_only);
  goto DATA;
} elseif($home["logout"]){
  print m."cookie expired!".n;
  unlink(cookie_only);
  goto DATA;
}
if($home["ptc"] || $home["shortlinks"] || $home["faucet"]){
  print "ok";
  r();
} else {
  goto home;
}


$update = $home["balance"][0];
c().asci(sc).ket("username",$home["username"]);
ket("balance",$home["balance"][0],"value",$home["balance"][1]);
line();
print n;
L(5);
#goto shortlinks;

if($home["ptc"][1] >= 1){
  goto ptc;
} elseif($home["shortlinks"][1] >= 1){
  goto shortlinks;
} elseif($home["faucet"]){
  goto faucet;
}


ptc:
$ptc = $home["ptc"][0];
if(!$ptc){
  $ptc = $r["ptc"][0];
}
while(true){
  $r = base_run(host.$ptc);
  if($r["status"] == 403){
    print m."cloudflare!".n;
    unlink(cookie_only);
    goto DATA;
  } elseif($r["logout"]){
    print m."cookie expired!".n;
    unlink(cookie_only);
    goto DATA;
  }
  if($update == $r["balance"][0]){
    #update jadi kontol babi ngemtot
    } else {
      ket("balance",$r["balance"][0],"value",$r["balance"][1]);
      line();
    }
    if(!$r["id"]){
      lah(1,"ptc");
      L(5);
      goto shortlinks;
    }
    $r1 = base_run(host.$r["surf_id"]);
    L($r1["timer"]);
    $cap = icon_bits();
    if($cap){
      $data = http_build_query([
        "a" => "proccessPTC",
        "data" => $r["id"],
        "token" => $r1["token"],
        "captcha-idhf" => 0,
        "captcha-hf" => $cap
        ]);
        $js = base_run(host."system/ajax.php",$data)["json"];
        if($js->status == 200){
        ket("message",explode("received ",$js->message)[1]);
        line();
        }
    }
}


shortlinks:
$links = $home["shortlinks"][0];
if(!$links){
  $links = $r["shortlinks"][0];
}
while(true){
  $r = base_run(host.$links);#die(file_put_contents("bitmun.html",$r["res"]));
  #die(print_r($r));
  if($r["status"] == 403){
    print m."cloudflare!".n;
    unlink(cookie_only);
    goto DATA;
  } elseif($r["logout"]){
    print m."cookie expired!".n;
    unlink(cookie_only);
    goto DATA;
  }
  $update = $r["balance"][0];
  $bypas = visit_short($r);
  if($bypas == "refresh"){
    continue;
  } elseif(!$bypas){
    $delay = $r["delay"];
    if(!$delay){
      continue;
    }
    lah(1,"shortlinks");
    L(5);
    if($r["ptc"][1] >= 1){
      goto ptc;
    } elseif($r["faucet"]){
      $waktu_awal = time()+min($delay);
      goto faucet;
    }
    tmr(2, min($delay));
    unset($delay);
    goto ptc;
  }
  $r1 = base_run($bypas);
  $update = $r1["balance"][0];
  if($r1["notif"]){
    $reward = explode("!",$r1["notif"]);
     print h.$reward[0];
     r();
     ket("reward",explode("received ",$reward[1])[1]);
     ket("balance",$r1["balance"][0],"value",$r1["balance"][1]).line();
  }
}


faucet:
$faucet = $home["faucet"][0];
if(!$faucet){
  $faucet = $r["faucet"][0];
}
while(true){
  $r = base_run(host.$faucet);
  #die(print_r($r));die(file_put_contents("bitmun.html",$r["res"]));
  if($r["status"] == 403){
    print m."cloudflare!".n;
    unlink(cookie_only);
    goto DATA;
  } elseif($r["logout"]){
    print m."cookie expired!".n;
    unlink(cookie_only);
    goto DATA;
  }
  if($r["claim"] >= rand(90,100)){
    print m."claim limit has reached limit".n;
    line();
    tmr(2, $waktu_awal - time());
    goto shortlinks;
  }
  if(1 >= $waktu_awal - time()){
    L(5);
    goto shortlinks;
  }
  if($r["locked"]){
    print m.$r["locked"].n;
    line();
    tmr(2, min($delay));
    unset($delay);
    goto ptc;
  }
  if($host == "nevcoins.club"){
    if(explode(" ",$r["info"][0])[0] == 50){
      print m."claim has reached the limit".n;
      line();
      L(5);
      if($r["ptc"][1] >= 1){
        goto ptc;
      } elseif($r["shortlinks"][1] >= 1){
        goto shortlinks;
      }
    }
  }
  if($r["timer"]){
    if($update == $r["balance"][0]){
      /*update jadi kontol babi ngemtot*/
    } else {
      ket("balance",$r["balance"][0],"value",$r["balance"][1]);
      if(preg_match("#claim)#is",$r["info"][0])){
        ket("claim today",$r["info"][0],"total claim",$r["info"][1]); 
      }
      line();
    }
    countdown($r["countdown"]);
    L(30);
    continue;
  }
  refresh:
  if($r["recaptchav2"]){
    $cap = multibot("recaptchav2",$r["recaptchav2"],host);
    if(!$cap){
      continue;
    }
    $rsp = [
      "captcha" => true,
      "challenge" => false,
      "response" => $cap
      ];
  } elseif($r["hcaptcha"]){
    $cap = multibot("hcaptcha",$r["hcaptcha"],host);
    if(!$cap){
      continue;
    }
    $rsp = [
      "captcha" => true,
      "challenge" => false,
      "response" => $cap
      ];
  } elseif($r["solvemedia"]){
    $cap = solvemedia($r["solvemedia"],host);
    if(!$cap[0]){
      continue;
    }
    $rsp = [
      "captcha" => false,
      "challenge" => $cap[1],
      "response" => $cap[0]
      ];
  } else {
    print "captcha bypass method is missing";
    r();
    continue;
  }
  $data = http_build_query(array_merge(
    [
      "a" => "getFaucet",
      "token" => $r["token"]
      ],
      $rsp
      ));
      $r = base_run(host."system/ajax.php", $data, 1);
      $js = $r["json"];
      unset($cap);
      unset($rsp);
      unset($data);
      if(preg_match("#congrat#is",$r["res"])){
        ket("number",number_format($js->number,0,',',','));
        ket("reward",$js->reward);
        line();
      } else {
        if(preg_match("#robot#is",$r["res"])){
          goto refresh;
        }
        print m.$js->message.n;
        line();
    }
}
#Session expired

function base_run($url, $data = 0, $xml = 0){
  global $host;
  $header = head($xml);
  $r = curl($url,$header,$data,true,false);
  unset($header);
  #$r[1] = file_get_contents("bitmun.html");
  #die(file_put_contents("bitmun.html",$r[1]));
  $json = json_decode(base64_decode($r[1]));
  if(!$json){
    $json = $r[2];
  }
  preg_match("#(Keep me logged in for 1 week)#is",$r[1],$logout);
  preg_match("#(Unexpected error occurred)#is",$r[1],$failed);
  preg_match_all('#(font|<div) class="(text-success|text-primary|text-warning)">(.*?)<#is',str_replace(['" id="account_balance',"<b>"],"",$r[1]),$info);#die(print_r($info));
  preg_match("#childWindow=open(.*?)',#is",trimed($r[1]),$surf);
  preg_match('#(text-dark|website_block)" id="([0-9]*)"#is',$r[1],$id);
  if($id[2]){
    $surf_id = str_replace("'+a+'",$id[2],str_replace("(base+'/","",$surf[1]));
  }
  preg_match("#([a-z0-9]{64})#is",$r[1],$token);
  preg_match_all("#([0-9]{13})#is",$r[1],$countdown);
  preg_match('#(var secs = |id="claimTime">|id="tai2mer">)([0-9]{3}|[0-9]{2}|[0-9]{1})(;| h| m| s)#is',$r[1],$tmr);
  preg_match_all('#align-middle">(.*?)</td><tdclass="align-middletext-center"><bclass="badgebadge-dark">(.*?)</b></td><tdclass="align-middletext-center"><bclass="badgebadge-dark">(.*?)</b></td><tdclass="(text-right|align-middletext-center)">(.*?)(role|"class=)#is',trimed($r[1]),$sl);
  
  preg_match('#(successmt-0"|alert-success mt-0" )role="alert">(.*?)<#is',$r[1],$n);
  preg_match_all('#data-seconds-left="(.*?)"#is',$r[1],$delay);
  preg_match('#(g-recaptcha" data-sitekey=")(.*?)(")#is',$r[1],$recaptchav2);
  preg_match("#Faucet Locked!#is",$r[1],$locked);
  preg_match_all('#(" href="([a-z-.\/=?]*)"><i class="(link|external-link|btc|eye)"></i> (.*?) <span class="badge badge-info">(.*?)</span>)#is',str_replace(["view ads","ptc ads","ads"],"ptc",str_replace(["fa fa-"," fa-fw","visit ","http://","https://"],"",strtolower($r[1]))),$cek);
  preg_match('#(ClaimsToday|claims):(\d+)#is',trimed(strip_tags($r[1])),$claim);
  #die(strip_tags($r[1]));
  #die(print_r($claim));
  #https://bits-claimer.com/?page=ptc
  $array1 = array_combine($cek[4], str_replace(["/", "coinptcter.com", $host],"",$cek[2]));
  $array2 = array_combine($cek[4], $cek[5]);
  #die(print_r(array_merge_recursive($array1, $array2)));
  
  if($host == "rushbitcoin.com"){
    $solvemedia = "WHx3UGDFc-pSG5USBRCcorQmj9JijaLj";
  }
  print p;
  return array_merge([
    "logout" => $logout,
    "res" => $r[1],
    "json" => $json,
    "info" => [$info[3][3],$info[3][4]],
    "username" => $info[3][0],
    "balance" => [$info[3][1],$info[3][2]],
    "token" => $token[1],
    "id" => $id[2],
    "surf_id" => $surf_id,
    "recaptchav2" => $recaptchav2[2],
    "solvemedia" => $solvemedia,
    "countdown" => $countdown[1],
    "timer" => $tmr[2],
    "visit" => array_values($sl[5]),
    "left" => $sl[3],
    "name" => explode(n,strip_tags(join(n,$sl[1]))),
    "notif" => $n[2],
    "delay" => $delay[1],
    "claim" => $claim[2],
    "locked" => $locked[0],
    "failed" => $failed[0],
    "status" => $r[0][1]["http_code"]
    ], array_merge_recursive($array1, $array2)
    );
}

