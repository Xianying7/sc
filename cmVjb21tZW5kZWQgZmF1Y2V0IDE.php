<?php




if($eval == false){
  eval(str_replace('<?php',"",get_e("build_index.php")));
  eval(str_replace('<?php',"",get_e("shortlink_index.php")));
}

go:
c();
$web = [
  "keforcash.com",
  "bitmonk.me",
  "claimcoin.in",
  "faucetspeedbtc.com",
  "coinpayz.xyz",
  "insfaucet.xyz",
  "chillfaucet.in",
  "queenofferwall.com",
  "liteearn.com",
  "hatecoin.me",
  "nobitafc.com",
  "bitupdate.info",
  "newzcrypt.xyz",
  "hfaucet.com",
  "banfaucet.com",
  "claimcash.cc",
  "freebinance.top",
  "faucetcrypto.net",
  "freesolana.top",
  "trxking.xyz",
  "litefaucet.in",
  "litecoinline.com",
  "cryptoviefaucet.com",
 # "coinsfaucet.xyz",
  "earnbtc.pw",
  "claimbitco.in",
  #"coinsward.com",
  "eurofaucet.de",
  "ourcoincash.xyz",
  #"www.freebnbcoin.com",
  "mezo.live"
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
#$r1 = base_run(host."links");#die(print_r($r1));



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


$n = 0;
while(true){
  $n++;
  $u_c = save(cookie_only);
  $r = base_run($shortlinks);#die(print_r($r));
  if($n == 1) {
    if(preg_match("#http#is",$r["visit"][0])) {
      $dark[] = $r["visit"];
      $dark_name[] = $r["name"];
      #goto dark;
    }
  }
  if($r["status"] == 403){
    /*if($dark) {
      ket("info", m."selamat datang di pasar gelap").linke();
      goto dark;
    }*/
    print m.sc." cloudflare!".n;
    unlink(cookie_only);
    unset($dark);
    goto DATA;
  } elseif($r["register"]){
    print m.sc." cookie expired!".n;
    unlink(cookie_only);
    unset($dark);
    goto DATA;
  } elseif($r["firewall"]){
    print m."Firewall!";
    r();
    unset($dark);
    goto firewall;
  }
  $bypas = visit_short($r);
  if($bypas == "refresh" || $bypas == "skip"){
    goto shortlinks;
  } elseif(!$bypas){
    lah(1,$redirect);
    //die("nunggu update fitur lagi");
    L(5);
    goto auto;
  }
  $r1 = base_run($bypas);
  if($r1["fireywall"]){
    print m."Firewall!";
    r();
    goto firewall;
  }
  if(preg_match("#(good|suc|been)#is",$r1["notif"]) == true){
    text_line(h.$r1["notif"]);
    if($r1["balance"]){
      ket("balance",$r1["balance"]);
      line();
    }   
  }
}

dark:
$config = config();
for ($x = 0; $x < $config; $x++) {
for ($i = 0; $i < $dark[0]; $i++) {
if(!$dark[0]){
 goto auto;
}
if(strtolower($config[$x]) == strtolower(trimed($dark_name[0][$i]))){
   $true = 1;
  }
  if($true){
    unset($dark[0][$i]);
    unset($dark_name[0][$i]);
    goto dark;
  }
if($dark[0][$i]) {
$r = base_run($dark[0][$i]);
if(!$r["url"]) {
unset($dark[0][$i]);
unset($dark_name[0][$i]);
continue;
}

ket("url",$r["url"]).line();
$bypas = bypass_shortlinks($r["url"]);
#array_reverse($cookie)
  if($bypas == "skip") {
    unset($dark[0][$i]);
    unset($dark_name[0][$i]);
    continue;
  } elseif($bypas == "refresh") {
    print m."invalid bypass".n;
    continue;
  } elseif(!$bypas) {
    goto auto;
  }
  base_run($bypas);
  $r = base_run(host."dashboard");
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
  if(preg_match("#(good|suc|been)#is",$r["notif"]) == true){
    text_line(h.$r["notif"]);
    ket("balance",$r["balance"]);
    line();
    goto dark;
    }
  }
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
  die(lah(2,$redirect));
}

while(true){
  $u_c = save(cookie_only);
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
    die(lah());
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
    if(preg_match("#(good|suc|been)#is",$r1["notif"]) == true){
      text_line(h.$r1["notif"]);
      if($r1["balance"]){
        ket("balance",$r1["balance"]);
        line();
      }
      unlink(cookie_only);
      $new_cookie = new_cookie($u_c, $r1["cookie"]);
      file_put_contents(cookie_only, $new_cookie);
      unset($u_c);
    }
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
            } /*elseif($redirect == "ptc"){
                goto ptc;
            } elseif($redirect == "faucet"){
                goto faucet;
            } */elseif($redirect == "auto"){
                goto auto;
            }
        } else {
            print m."invalid captcha!";
            r();
        }
    }
}


function base_run($url,$data=0){
  $header = h_x();
  $r = curl($url,$header,$data,true,false);
  unset($header);
  #die(file_put_contents("response_body.html",$r[1]));
  #$r[1] = get_e("response_body.html");
  preg_match("#Just a moment#is",$r[1],$cloudflare);
  preg_match("#(login)#is",str_replace("Login every","",$r[1]),$register);
  preg_match("#(antibotlink)#is",$r[1],$antb);
  preg_match("#(Protecting faucet|Daily limit reached|for Auto Faucet)#is",$r[1],$limit);
  preg_match("#firewall#is",$r[1],$firewall);
  preg_match("#(Failed to generate this link)#is",$r[1],$failed);
  preg_match('#"g-recaptcha" data-sitekey="(.*?)"#is',$r[1],$recaptchav2);
  preg_match('#h-captcha" data-sitekey="(.*?)"#is',$r[1],$hcaptcha);
  preg_match('#grecaptcha.execute"(.*?)"#is',str_replace("(","",$r[1]),$recaptchav3);
  preg_match('#(class="fa-solid fa-user-graduate me-2"></i>|class="text-primary"><p>|user-name-text">|fw-semibold">|key="t-henry">|class="font-size-15 text-truncate">)(.*?)(<)#is',str_replace("#","",$r[1]),$username);
  preg_match_all('#(<h5>|class="text-muted font-weight-medium">|class="">|class="text-muted mb-2">)(.*?)<(.*?)>([a-zA-Z0-9-, .]*)<#is',str_replace(["'",''],"",$r[1]),$bal);
  #die(print_r($bal));
  for ($i = 0; $i < 30; $i++) {
  if(trimed(strtolower($bal[2][$i])) == "balance"){
  $balance = $bal[4][$i];
  break;
  }}
  //die(print_r(ltrim(strip_tags($balance[2]))));
  preg_match_all('#hidden" name="(.*?)" value="(.*?)"#',str_replace('name="anti','',$r[1]),$t_cs);
  #die(print_r($t_cs));
  
  preg_match('#(timer|wait*)( = *)(\d+)#is',$r[1],$tmr);
  preg_match_all('#(class="card-titlemt-0">|<h5class="title">|class="card-titlefont-size-18mt-0">|class="card-titletext-centerfont-size-18">|class="text-dark">|class="card-titlemx-auto">|class="card-claim"><h5>|titletext-center">|card-titlemt-0">|margin-bottom:0px;">|class="link-name">|class="card-title">)(.*?)(<)#is',trimed($r[1]),$x);#die(print_r($x));
  preg_match_all('#(https?:\/\/[a-zA-Z0-9\/-\/.-]*\/(go|make|pre_verify)\/?[a-zA-Z0-9\/-\/.]*)(.*?)#is',$r[1],$y);
  if($y[0]){
   $y[0] = array_values(array_unique($y[0]));
  }
  preg_match_all('#(>| |\n)(\d+\/+\d+)#is', str_replace(str_split('({['),'',$r[1]),$z);
  preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$r[1],$u_r);
  preg_match_all("#(https?:\/\/".sc."[a-z\/.]*)(\/auto|\/faucet|\/ptc|\/links|\/shortlinks|\/achievements)#is",$r[1],$link);
  //die(print_r(array_merge(array_unique($link[0]))));
 # swal('Good job!', '0.002 USDT has been added to your balance', 'success')
  preg_match("#(alert-borderless'>|Swal.fire|swal[(])(.*?)(<)#is",$r[1],$n);
  #preg_match('#(Swal.fire)(.*?)(<)#is',$r[1],$n);
  preg_match_all('#(title|text|icon):(.*?)(,|\n})#is',$r[1],$nn);
  if(!$n[2]){
    $n[2] = $nn[2][0].$nn[2][1];
  }
  preg_match_all("#(https?:\/\/[a-z\/.]*)(verify|ptc\/view|achievements\/claim*)(\/?[a-z0-9\/]*)(.*?)#is",$r[1],$redirect);
  
  #die(print($data));
  return [
    "status" => $r[0][1]["http_code"],
    "res" => $r[1],
    "register" => $register[1],
    "antb" => $antb[1],
    "cookie" => set_cookie($r[0][2]),
    "cloudflare" => $cf,
    "firewall" => $firewall[0],
    "limit" => $limit[0],
    "recaptchav2" => $recaptchav2[1],
    "recaptchav3" => $recaptchav3[1],
    "hcaptcha" => $hcaptcha[1],
    "username" => preg_replace("/[^a-zA-Z0-9]/","",$username[2]),
    "balance" => ltrim(strip_tags($balance)),
    "timer" => $tmr[3],
    "token_csrf" => $t_cs,
    "visit" => $y[0],
    "left" => $z[2],
    "name" => $x[2],
    "notif" => preg_replace("/[^a-zA-Z0-9-!. ]/","",$n[2]),
    "url" => $u_r[0],
    "link" => array_merge(array_unique($link[0])),
    "url1" => $r[0][0]["location"],
    "failed"=>$failed[1],
    "redirect"=>$redirect[0],
    ];
}

function h_x(){
  global $u_a, $u_c;
  $header = array();
  if(!$u_a){
    $u_a = user_agent();
  }
  $header[] = "user-agent: ".$u_a;
  if($u_c){
    $header[] = "cookie: ".$u_c;
  }
  return $header;
}
