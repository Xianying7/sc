<?php







if($eval == false){
  eval(str_replace('<?php',"",get_e("build_index.php")));
  eval(str_replace('<?php',"",get_e("shortlink_index.php")));
}

go:
c();
$web = [
  "keforcash.com",
  "claimcoin.in",
  "freebinance.top",
  "faucetcrypto.net",
  "freesolana.top",
  #"trxking.xyz"
  "litefaucet.in",
  #"litecoinline.com",
  "uclicka.com",
  "cryptoviefaucet.com",#bug
  "coinsfaucet.xyz",
  #*"earnbtc.pw",
  #"claimbitco.in",
  #"coinsward.com",
  #"eurofaucet.de",
  "ourcoincash.xyz",
  #"www.freebnbcoin.com",
  "mezo.live",
  ];
  
for($i=0;$i<count($web);$i++){
  if($web[$i]){
    ket($i+1,$web[$i]);
  }
}

$p = preg_replace("/[^0-9]/","",trim(tx("number")));
$host = $web[$p-1];
if(!$host){
  goto go;
}

eval(str_replace('name_host',explode(".",$host)[0],str_replace('example',$host,'const host="https://example/",sc="name_host",cookie_only="cookie_example",mode="vie_free";')));


DATA:
$u_a = save("useragent");
$u_c = save(cookie_only);
#$r = die(print_r(base_run(host."dashboard")));
//goto faucet;

dashboard:
$redirect = "dashboard";
$r = base_run(host."dashboard");
$link = $r["link"];
//goto faucet;
if($r["status"] == 403){
  print m.sc." cloudflare!".n;
  unlink(cookie_only);
  goto DATA;
} elseif($r["register"]){
  print m.sc." cookie expired!".n;
  unlink(cookie_only);
  goto DATA;
} elseif($r["firewall"]){
  print m."Firewall!";
  r();
  goto firewall;
}

c().asci(sc);
if($r["username"]){
  ket("username",$r["username"]);
}
ket("balance",$r["balance"]).line();
#goto faucet;




shortlinks:
$redirect = "shortlinks";
for($i = 0;$i<=count($link);$i++){
  if(preg_match("#(link)#is",$link[$i])){
    $shortlinks = $link[$i];
    break;
  }
}

if(!$shortlinks){
  lah(2,$redirect);
  L(5);
  goto auto;
}


while(true){
  $r = base_run($shortlinks);
  if($r["status"] == 403){
    print m.sc." cloudflare!".n;
    unlink(cookie_only);
    goto DATA;
  } elseif($r["register"]){
    print m.sc." cookie expired!".n;
    unlink(cookie_only);
    goto DATA;
  } elseif($r["firewall"]){
    print m."Firewall!";
    r();
    goto firewall;
  }
  $bypas = visit_short($r);
  if($bypas == "refresh"){
    goto shortlinks;
  } elseif(!$bypas){
    lah(1,$redirect);
    die("nunggu update fitur lagi");
    L(5);
    goto auto;
  }
  $r1 = base_run($bypas);#die(file_put_contents("response_body.html",$r1["res"]));
  if($r1["fireywall"]){
    print m."Firewall!";
    r();
    goto firewall;
  }
  if(preg_match("#good#is",$r1["notif"]) == true){
    an(h.$r1["notif"].n);
    line();
  }
}

auto:
$redirect = "auto";
for($i = 0;$i<=count($link);$i++){
  if(preg_match("#(auto)#is",$link[$i])){
    $auto = $link[$i];
    break;
  }
}

if(!$auto){
  lah(2,$redirect);
  L(5);
  goto ptc;
}

while(true){
  $r = base_run($auto);
  if($r["status"] == 403){
    print m.sc." cloudflare!".n;
    unlink(cookie_only);
    goto DATA;
  } elseif($r["register"]){
    print m.sc." cookie expired!".n;
    unlink(cookie_only);
    goto DATA;
  } elseif($r["firewall"]){
    print m."Firewall!";
    r();
    goto firewall;
  }
  if($r["limit"]){
    lah();
    L(5);
    goto ptc;
  }
  if($r["timer"]){
    tmr(2,$r["timer"]);
    $t = $r["token_csrf"];
    $data = data_post($t, "null");
    $r1 = base_run($r["redirect"][0],$data);
    if($r1["firewall"]){
      print m."Firewall!";
      r();
      goto firewall;
    }
    if(preg_match("#good#is",$r1["notif"]) == true){
      an(h.$r1["notif"].n);
      line();
    }
  }
}


ptc:
$redirect = "ptc";
for($i = 0;$i<=count($link);$i++){
  if(preg_match("#(ptc)#is",$link[$i])){
    $ptc = $link[$i];
    break;
  }
}
if(!$ptc){
  lah(2,$redirect);
  L(5);
  goto faucet;
}

while(true){
  $r = base_run($ptc);
  if($r["status"] == 403){
    print m.sc." cloudflare!".n;
    unlink(cookie_only);
    goto DATA;
  } elseif($r["register"]){
    print m.sc." cookie expired!".n;
    unlink(cookie_only);
    goto DATA;
  } elseif($r["firewall"]){
    print m."Firewall!";
    r();
    goto firewall;
  } elseif(!$r["redirect"][0] or $r["left_ptc"]==0){
    lah(1,$redirect);
    L(5);
    goto faucet;
  }
  $r1 = base_run($r["redirect"][0]);
  $t = $r1["token_csrf"];
  tmr(2,$r1["timer"]);
  rep:
  if($r1["recaptchav3"]){
    $method = "recaptchav3";
    $cap = recaptchav3($r1[$method],$ptc);
    $rsp["captcha"] = $method;
    $rsp["recaptchav3"] = $cap;
    goto startp;
  } elseif($r1["hcaptcha"]){
    $method = "hcaptcha";
    $cap = multibot($method,$r1[$method],$ptc);
    $rsp["captcha"] = $method;
    $rsp["h-captcha-response"] = $cap;
    goto startp;
  } elseif($r1["recaptchav2"]){
    $method = "recaptchav2";
    $cap = multibot($method,$r1[$method],$ptc);
    $rsp["captcha"] = $method;
    $rsp["g-recaptcha-response"] = $cap;
    goto startp;
  }
  if(!$cap){
    goto rep;
  }
  startp:
  $data = data_post($t, "one", array_merge($rsp));
  unset($rsp);#die($data);
  $r2 = base_run($r1["redirect"][0],$data);
  if($r2["firewall"]){
    print m."Firewall!";
    r();
    goto firewall;
  }
  if(preg_match("#good#is",$r2["notif"]) == true){
    an(h.$r2["notif"].n);
    line();
  } else {
    print m."invalid captcha!";
    r();
  }
}
exit;

faucet:
$redirect = "faucet";
for($i = 0;$i<=count($link);$i++){
  if(preg_match("#(faucet)#is",$link[$i])){
    $faucet = $link[$i];
    break;
  }
}

if(!$faucet){
lah(2,$redirect);
exit;
}

while(true){
  $r = base_run($faucet);
  if($r["status"] == 403){
    print m.sc." cloudflare!".n;
    unlink(cookie_only);
    goto DATA;
  } elseif($r["register"]){
    print m.sc." cookie expired!".n;
    unlink(cookie_only);
    goto DATA;
  } elseif($r["firewall"]){
    print m."Firewall!";
    r();
    goto firewall;
  } elseif($r["limit"] or explode("/",$r["left"][0])[0] == 0){
    lah(1,$redirect);
    exit;
  }
  $t = $r["token_csrf"];
  if($r["timer"]){
    if($r["timer"] == 6){
    } else {
      tmr(1,$r["timer"]);
      continue;
    }
  }
  if(!$r["redirect"][0]){
    continue;
  }
  if($r["antb"]){
    $antibot = antibot($r["res"]);
    if(!$antibot){
      continue;
    }
    $rsp["antibotlinks"] = $antibot;
  }
  re:
  if($r1["recaptchav3"]){
    $method = "recaptchav3";
    $cap = recaptchav3($r1[$method],$faucet);
    $rsp["captcha"] = $method;
    $rsp["recaptchav3"] = $cap;
    goto start;
  } elseif($r["hcaptcha"]){
    $method = "hcaptcha";
    $cap = multibot($method,$r[$method],$faucet);
    $rsp["captcha"] = $method;
    $rsp["h-captcha-response"] = $cap;
    goto start;
  }  elseif($r["recaptchav2"]){
    $method = "recaptchav2";
    $cap = multibot($method,$r[$method],$faucet);
    $rsp["captcha"] = $method;
    $rsp["g-recaptcha-response"] = $cap;
    goto start;
  }
  if(!$cap){
    goto re;
  }
  start:
  $data = data_post($t, "one", array_merge($rsp));
  unset($rsp);
  $r1 = base_run($r["redirect"][0],$data);
  if($r1["firewall"]){
    print m."Firewall!";
    r();
    goto firewall;
  }
  if(preg_match("#good#is",$r1["notif"]) == true){
    an(h.$r1["notif"].n);
    line();
    tmr(1,$r1["timer"]);
  } else {
    print m."invalid captcha!";
    r();
  }
}



firewall:
while(true){die("firewall butuh update sc");
    $r = base_run(host."firewall");    
    if($link[$host]["type"] == $r["token_csrf"][2][0]){
        fire:
        eval(str_replace("request_captcha(",$methode[$request_captcha]."(",'$cap=request_captcha($link[$host]["type"],$r[$link[$host]["type"]],host."firewall");'));    
        if(!$cap){        
            goto fire;
        }
        $data = http_build_query([
            "g-recaptcha-response" => $cap,
            $r["token_csrf"][1][0] => $r["token_csrf"][2][0],
            $r["token_csrf"][1][1] => $r["token_csrf"][2][1]
        ]);
        $r1 = base_run($r["redirect"][0],$data);
        if(!$r1["firewall"]){
            print p."bypass firewall successfull".n;
            line();
            if($redirect == "dashboard"){
                goto dashboard;
            } elseif($redirect == "ptc"){
                goto ptc;
            } elseif($redirect == "faucet"){
                goto faucet;
            } elseif($redirect == "auto"){
                goto auto;
            }
        } else {
            print m."invalid captcha!";
            r();
        }
    }
}


function base_run($url,$data=0){
  $header = head();
  $r = curl($url,$header,$data,true,false);
  unset($header);
  #die(file_put_contents("response_body.html",$r[1]));
  #$r[1] = get_e("response_body.html");
  preg_match("#Just a moment#is",$r[1],$cloudflare);
  preg_match("#(login)#is",$r[1],$register);
  
  
  preg_match("#(Protecting faucet|Daily limit reached|for Auto Faucet)#is",$r[1],$limit);
  preg_match("#firewall#is",$r[1],$firewall);
  preg_match('#"g-recaptcha" data-sitekey="(.*?)"#is',$r[1],$recaptchav2);
  preg_match('#h-captcha" data-sitekey="(.*?)"#is',$r[1],$hcaptcha);
  preg_match('#grecaptcha.execute"(.*?)"#is',str_replace("(","",$r[1]),$recaptchav3);
  preg_match('#(fw-semibold">|key="t-henry">|class="font-size-15 text-truncate">)(.*?)(<)#is',str_replace("#","",$r[1]),$username);
  preg_match('#(class="mb-0 number-font">|class="fas fa-coins"></i> |Balance</p>)(.*?)(</h2>|</p>|</h4>|</h5>)#is',$r[1],$balance);
  //die(print_r($balance));
  //die(print_r(ltrim(strip_tags($balance[2]))));
  preg_match_all('#hidden" name="(.*?)" value="(.*?)"#',str_replace('name="anti','',$r[1]),$t_cs);
  #die(print_r($t_cs));
  
  preg_match('#(timer|wait*)( = *)(\d+)#is',$r[1],$tmr);
  preg_match_all('#(class="card-titlemx-auto">|class="card-claim"><h5>|titletext-center">|card-titlemt-0">|margin-bottom:0px;">|class="link-name">|class="card-title">)(.*?)(<)#is',trimed($r[1]),$x);
  preg_match_all('#(https?:\/\/[a-zA-Z0-9\/-\/.-]*\/go\/?[a-zA-Z0-9\/-\/.]*)(.*?)#is',$r[1],$y);
  preg_match_all('#(>| )(\d+\/+\d+)#is', str_replace(str_split('({['),'',$r[1]),$z);
  preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$r[1],$u_r);
  preg_match_all("#(https?:\/\/".sc."[a-z\/.]*)(\/auto|\/faucet|\/ptc|\/links)#is",$r[1],$link);
  //die(print_r(array_merge(array_unique($link[0]))));
 # swal('Good job!', '0.002 USDT has been added to your balance', 'success')
  preg_match('#(Swal.fire|swal)(.*?)(<)#is',$r[1],$n);
  #preg_match('#(Swal.fire)(.*?)(<)#is',$r[1],$n);
  preg_match_all('#(title|text):(.*?)(,)#is',$r[1],$nn);
  if(!$n[2]){
    $n[2] = $nn[2][0].$nn[2][1];
  }
  preg_match_all("#(https?:\/\/[a-z\/.]*)(verify|ptc\/view|achievements\/claim*)(\/?[a-z0-9\/]*)(.*?)#is",$r[1],$redirect);
  preg_match('#("badge badge-primary">|badge badge-info">)(\d+)#is',$r[1],$p);
  preg_match_all('#rel=\\\"(.*?)\\\">#is',$r[1],$ab);
  //print_r($sl);
  //die(print_r($xx));
  return [
    "status" => $r[0][1]["http_code"],
    "res" => $r[1],
    "register" => $register[1],
    "cookie" => $cek_cookie,
    "cloudflare" => $cf,
    "firewall" => $firewall[0],
    "limit" => $limit[0],
    "recaptchav2" => $recaptchav2[1],
    "recaptchav3" => $recaptchav3[1],
    "hcaptcha" => $hcaptcha[1],
    "username" => preg_replace("/[^a-zA-Z0-9]/","",$username[2]),
    "balance" => ltrim(strip_tags($balance[2])),
    "timer" => $tmr[3],
    "token_csrf" => $t_cs,
    "visit" => $y[0],
    "left" => $z[2],
    "left_ptc" => $p[2],
    "name" => $x[2],
    "notif" => preg_replace("/[^a-zA-Z0-9-!. ]/","",$n[2]),
    "url" => $u_r[0],
    "link" => array_merge(array_unique($link[0])),
    "url1" => $r[0][0]["location"],
    "redirect"=>$redirect[0],
    "json" => json_decode($r[1]),
    "antb" => $ab[1][0]
    ];
}

