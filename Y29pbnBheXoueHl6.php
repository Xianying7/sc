<?php

if($eval == false){
    eval(str_replace('<?php',"",get_e("build_index.php")));
    eval(str_replace('<?php',"",get_e("shortlink_index.php")));
}


eval(str_replace('name_host',explode(".","coinpayz.xyz")[0],str_replace('example','coinpayz.xyz','const host="https://example/",sc="name_host",cookie_only="cookie_example",mode="vie_free";')));



DATA:
$u_a = save("useragent");
$u_c = save(cookie_only);
//goto faucet;

$r = base_run(host."dashboard");
if($r["status"] == 403){
    print m.sc." cloudflare!".n;
    unlink(cookie_only);
    goto DATA;
} elseif($r["register"]){
    print m.sc." cookie expired!".n;
    unlink(cookie_only);
    goto DATA;
}
c().asci(sc);
if($r["username"]){
  ket("username",$r["username"]);
}
ket("balance",$r["balance"]).line();
$list_sl = list_sl(base_run(host."links"));
if($r["ready"][0] == "Ready"){
  L(5);
  goto dashboard;
} elseif(strip_tags($r["ready"][0]) == "Ready"){
  L(5);
  goto faucet;
} else {
  L(5);
  if($r["left_sl"] >= $list_sl){
    goto shortlinks;
  }
  goto ptc;
}


dashboard:
  $list_sl = list_sl(base_run(host."links"));
  $r = base_run(host."dashboard");
  if($r["status"] == 403){
    print m.sc." cloudflare!".n;
    unlink(cookie_only);
    goto DATA;
} elseif($r["register"]){
    print m.sc." cookie expired!".n;
    unlink(cookie_only);
    goto DATA;
}
  if($r["ready"][0] == "Ready"){
    L(5);
    $r = base_run(host."daily");
    if($r["status"] == 403){
    print m.sc." cloudflare!".n;
    unlink(cookie_only);
    goto DATA;
} elseif($r["register"]){
    print m.sc." cookie expired!".n;
    unlink(cookie_only);
    goto DATA;
}
    L(5);
    $data = http_build_query([
      explode('"',$r["token_csrf"][1][0])[0] => $r["token_csrf"][2][0],
      explode('"',$r["token_csrf"][1][1])[0] => $r["token_csrf"][2][1],
      "utt" => "",
      "captcha" => "recaptchav3",
      "recaptchav3" => ""
      ]);
      base_run($r["redirect"][0],$data);
      an(h."daily bonus claimed successfully".n);
      line();
      L(5);
  }
  for($s=0;$s<2;$s++){
    $r = base_run(host.["linkboard","faucetboard"][$s]);
    if($r["status"] == 403){
    print m.sc." cloudflare!".n;
    unlink(cookie_only);
    goto DATA;
} elseif($r["register"]){
    print m.sc." cookie expired!".n;
    unlink(cookie_only);
    goto DATA;
}
    if($r["info_claim"]){
      $total = " | your claim: ".$r["info_claim"];
    }
    ket(" ",$r["info_contest"].$total).line();
    for($i=0;$i<20;$i++){
      if($r["contest"][1][$i]){
        ket($r["contest"][1][$i],$r["contest"][2][$i]." (".k.$r["contest"][3][$i].k.") ".p.$r["contest"][4][$i]);
      }
    }
    line();
    L(5);
}
while(true){
  $r = base_run(host."achievements");
  if($r["status"] == 403){
    print m.sc." cloudflare!".n;
    unlink(cookie_only);
    goto DATA;
} elseif($r["register"]){
    print m.sc." cookie expired!".n;
    unlink(cookie_only);
    goto DATA;
}
  for($i =0;$i<count($r["redirect"])+1;$i++){
    if(!$r["redirect"][$i]){
      lah(1,"achievements");
      L(5);
      goto faucet;
    }
    if(explode("/",$r["left"][$i])[0] >= explode("/",$r["left"][$i])[1]){
      $data = http_build_query([
        $r["token_csrf"][1][0] => $r["token_csrf"][2][0]
            ]);
            $r1 = base_run($r["redirect"][$i],$data);
            if(preg_match("#good#is",$r1["notif"]) == true){
              an(h.$r1["notif"].n);
              line().ket("balance",$r1["balance"]).line();
              continue;
            }
    }
  }
}


faucet:
  while(true){
    $r = base_run(host."faucet");
    $awal = strtotime(date('H:i:s'));
    if($r["status"] == 403){
    print m.sc." cloudflare!".n;
    unlink(cookie_only);
    goto DATA;
} elseif($r["register"]){
    print m.sc." cookie expired!".n;
    unlink(cookie_only);
    goto DATA;
}
    if($r["timer"]){
      tmr(1,$r["timer"]);
      continue;
    } elseif($r["limit"]){
      print k.$r["limit"].n;
      line();
      tmr(2,5*60);
      continue;
    }
    if(!$r["redirect"][0] or !$r["token_csrf"][1][0]){
      continue;
    }
    $antibot = antibot($r["res"]);
    if(!$antibot){
      continue;
    }
    $akhir = strtotime(date('H:i:s'));
    $sec = $akhir - $awal;
    if($sec >= 7 == null){
      L(7 - $sec);
    }
    $data = http_build_query([
      explode('"',$r["token_csrf"][1][0])[0] => $r["token_csrf"][2][0],
      explode('"',$r["token_csrf"][1][1])[0] =># "xxxx",
      $r["token_csrf"][2][1],
      "antibotlinks" => $antibot,
      "utt" => "",
      "captcha" => "recaptchav3",
      "recaptchav3" => ""
      ]);
      $r1 = base_run($r["redirect"][0],$data);
      if(preg_match("#good#is",$r1["notif"]) == true){
        an(h.$r1["notif"].n);
        line().ket("balance",$r1["balance"]).line();
        if($r1["left_sl"] >= $list_sl){
          L(5);
          $w_f = strtotime(date("H:i:s"));
          goto shortlinks;
        } elseif($r1["left_ptc"] >= 1){
          L(5);
          goto ptc;
        }
        tmr(1,$r1["timer"]);
      } else {
        print m.$r1["notif"];
        r();
      }
    
  }

ptc:
  $n_r =-1;
  while(true){
    $n_r++;
    if($n_r == 6){
      goto faucet;
    }
    $r = base_run(host."ptc");
    if($r["status"] == 403){
    print m.sc." cloudflare!".n;
    unlink(cookie_only);
    goto DATA;
} elseif($r["register"]){
    print m.sc." cookie expired!".n;
    unlink(cookie_only);
    goto DATA;
} elseif(!$r["redirect"][0] or $r["left_ptc"] == 0){
      lah(1,"ptc");
      L(5);
      goto dashboard;
    }
    $r1 = base_run($r["redirect"][0]);
    if(!$r1["redirect"][0]){
      continue;
    }
    tmr(2,$r1["timer"]);
    $data = http_build_query([
      "utt" => "",
      "captcha" => "recaptchav3",
      "recaptchav3" => "",
      explode('"',$r1["token_csrf"][1][0])[0] => $r1["token_csrf"][2][0],
      explode('"',$r1["token_csrf"][1][1])[0] => $r1["token_csrf"][2][1]
      ]);
      $r2 = base_run($r1["redirect"][0],$data);
      if(preg_match("#good#is",$r2["notif"]) == true){
        an(h.$r2["notif"].n);
        line().ket("balance",$r2["balance"]).line();
      } else {
        print m.$r2["notif"];
        r();
      }
  }


shortlinks:
  while(true){
    $r = base_run(host."links");
    if($r["status"] == 403){
    print m.sc." cloudflare!".n;
    unlink(cookie_only);
    goto DATA;
} elseif($r["register"]){
    print m.sc." cookie expired!".n;
    unlink(cookie_only);
    goto DATA;
}
    $bypas = visit_short($r);
    if($bypas == "refresh"){
      continue;
    } elseif(!$bypas){
      lah(1,"shortlinks");
      L(5);
      goto dashboard;
    }
    $r1 = base_run($bypas);
    if(preg_match("#good#is",$r1["notif"]) == true){
      an(h.$r1["notif"].n);
      line().ket("balance",$r1["balance"]).line();
      $w_sl = strtotime(date("H:i:s"));
      $tmr = $w_sl - $w_f;
      $wait = 5 * 60;
      if($tmr >= $wait == null){
         tmr(1,$wait - $tmr);
      }
      goto faucet;
    } else {
      print m.$r1["notif"];r();
    }
  }

function base_run($url,$data=0){
  $header = head();
  $r = curl($url,$header,$data,true,false);
  unset($header);
  #die(file_put_contents("html.html",$r[1]));
  preg_match("#Just a moment#is",$r[1],$cloudflare);
  preg_match("#(login)#is",$r[1],$register);
  preg_match("#(Wait until your timer ends)#is",$r[1],$limit);
  preg_match('#(t-username">)(.*?)(<)#is',$r[1],$username);
  preg_match('#Balance : (.*?) (Coins|<)#is',$r[1],$b);
  if($b[1]){
    $balance = $b[1]/100000;
  }
  preg_match_all('#rel=\\\"(.*?)\\\">#is',$r[1],$ab);
  preg_match_all('#hidden" name="(.*?)" value="(.*?)"#',$r[1],$t_cs);
  preg_match('#(timer|wait*)( = *)(\d+)#is',$r[1],$tmr);
  preg_match_all('#(18 mt-0">)(.*?)(<)#is',$r[1],$x);
  preg_match_all('#(https?:\/\/[a-zA-Z0-9\/-\/.]*\/go\/?[a-zA-Z0-9\/-\/.]*)(.*?)#is',$r[1],$y);
  preg_match_all('#(>| )(\d+\/+\d+)#is', str_replace(str_split('({['),'',trimed($r[1])),$z);
  preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$r[1],$u_r);
  preg_match('#(Swal.fire)(.*?)(<)#is',$r[1],$n);
  preg_match('#amation-circle"></i> (.*?)<#is',$r[1],$nn);
  if(!$n[2]){
    $n[2] = $nn[1];
  }
  preg_match_all("#(https?:\/\/[a-z\/.]*)(verify|ptc\/view|achievements\/claim*)(\/?[a-z0-9\/]*)(.*?)#is",$r[1],$redirect);
  preg_match('#(badge-info">)(\d+)#is',$r[1],$p);
  preg_match('#(badge-success">)(\d+)#is',$r[1],$s);
  preg_match_all('#(class="bxbx-check-doublelabel-icon"></i>)(.*?)(</a>|</span>)#is',trimed($r[1]),$ready);
  preg_match('#class="card-title mb-4">(.*?)<#is',$r[1],$info_contest);
  preg_match('#(claim this week: )(\d+)#is',$r[1],$info_claim);
  preg_match_all('#<tr><th scope="row">(.*?)</th><td class="username-rank">(.*?)</td><td>(.*?)</td><td>(.*?)</td></tr>#is',$r[1],$contest);
  //print_r($sl);
  //die(print_r($register));
  return [
    "res" => $r[1],
    "cloudflare" => $cloudflare[0],
    "register" => $register[0],
    "limit" => $limit[0],
    "username" => preg_replace("/[^a-zA-Z0-9]/","",$username[2]),
    "balance" => $b[1]." Coins = ".$balance." USDT",
    "token" => $token[1],
    "timer" => $tmr[3],
    "token_csrf" => $t_cs,
    "antb" => antb($ab),
    "visit" => $y[0],
    "left" => $z[2],
    "left_ptc" => $p[2],
    "left_sl" => $s[2],
    "name" => $x[2],
    "notif" => preg_replace("/[^a-zA-Z0-9-!. ]/","",$n[2]),
    "url" => $u_r[0],
    "url1" => $r[0][0]["location"],
    "redirect" => $redirect[0],
    "ready" => $ready[2],
    "info_contest" => $info_contest[1],
    "info_claim" => $info_claim[2],
    "contest" => $contest,
    "json" => $r[2],
    "status" => $r[0][1]["http_code"]
    ];
}

function list_sl($r){
  $control = file("control");
  if(!$control[0]){
    $control = ["tolol"];
  }
  $config = config();
  $list = $r["name"];
  $semua = 0;
  $semua_config = 0;
  $mati = 0;
  for($s=0;$s<count($list);$s++){
    $semua += explode("/",$r["left"][$s])[1];
  }
  for($i=0;$i<count($config);$i++){
    for($s=0;$s<count($list);$s++){
      if(strtolower($config[$i]) == strtolower($list[$s])){
        $semua_config += explode("/",$r["left"][$s])[1];
      }
    }
  }
  $mbo = $semua - $semua_config;
  for($i=0;$i<count($control);$i++){
    for($s=0;$s<count($list);$s++){
      if(strtolower(str_replace(n,"",$control[$i])) == strtolower($list[$s])){
        $mati += explode("/",$r["left"][$s])[1];
      }
    }
  }
  return 1 + $mbo + $mati;
}