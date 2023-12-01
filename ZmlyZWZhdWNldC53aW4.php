<?php


if($eval == false){
  eval(str_replace('<?php',"",get_e("build_index.php")));
  eval(str_replace('<?php',"",get_e("shortlink_index.php")));
}

eval(str_replace('name_host',explode(".","firefaucet.win")[0],str_replace('example',"firefaucet.win",'const host="https://example/",sc="name_host",cookie_only="cookie_example",mode="firefaucet";')));


DATA:
$u_a = save("useragent");
$u_c = save(cookie_only);
/*
faucet:
while(true){
  $r = base_run(host."faucet/");#die(print_r($r));
  if($r["status"] == 403){
    print m."cloudflare!".n;
    unlink(cookie_only);
    goto DATA;
  } elseif($r["account"]){
    print m."cookie expired!".n;
    unlink(cookie_only);
    goto DATA;
  }
  if(preg_match('#suc#is',$r["notif"])){
    print h.$r["notif"].n;
    line();
    tmr(1, $r["timer"] * 60);
    continue;
  } else {
    print m.$r["notif"];
    r();
  }
  if($r["timer"]){die("siap");}
  $type = $r["type"];
  $t = array($r["token"][1][0] => $r["token"][2][0]);
  refresh:
  print_r($type);#exit;
  for($x=0;$x<count($type[1]);$x++){
    if($type[2][$x] == "hcaptcha"){
      $cap = multibot("hcaptcha",$r[$type[2][$x]],host);
      if(!$cap){
        print $cap;
        unset($cap);
        goto refresh;
      }
      $rsp = array(
        $type[1][$x] => $type[2][$x],
        "g-recaptcha-response" => $cap,
        "h-captcha-response" => $cap
      );
      break;
    } elseif($type[2][$x] == "recaptcha"){
      $cap = multibot("recaptchav2",$r[$type[2][$x]],host);
      if(!$cap){
        unset($cap);
        goto refresh;
      }
      $rsp = array(
        $type[1][$x] => $type[2][$x],
        "g-recaptcha-response" => $cap
      );
      break;
    } elseif($type[2][$x] == "solvemedia"){
      $cap = solvemedia($r[$type[2][$x]],host);
      if(!$cap[0]){
        unset($cap);
        goto refresh;
      }
      $rsp = array(
        $type[1][$x] => $type[2][$x],
        "adcopy_response" => $cap[0],
        "adcopy_challenge" => $cap[1]
      );
      break;
    } else {
      die("metode captcha gada asu");
    }
  }
  $data = http_build_query(array_merge($t, $rsp));
  print $data.n;
  $r1 = base_run(host."faucet", $data, 1);
  unset($rsp);
  unset($data);
}

*/


c();
$x = 0;
home:
$x++;
$r = base_run(host);#die(print_r($r));
if($r["status"] == 403){
  print m."cloudflare!".n;
  unlink(cookie_only);
  goto DATA;
} elseif($r["account"]){
  print m."cookie expired!".n;
  unlink(cookie_only);
  goto DATA;
}
if($x == 1){
  c().asci(sc).ket("username",$r["username"]);
  ket("balance",$r["balance"]);
  line();
  print n;
}
if($r["claim_reward"] >= 1){
  print k."wait claimed reward levels".n;
  line();
  L(5);
  goto claim_reward;
} else {
  L(5);
  goto daily_task;
}



claim_reward:
while(true){
  $r = base_run(host."levels");
  if($r["status"] == 403){
    print m."cloudflare!".n;
    unlink(cookie_only);
    goto DATA;
  } elseif($r["account"]){
    print m."cookie expired!".n;
    unlink(cookie_only);
    goto DATA;
  } elseif(!$r["tasks_level"][0]){
    goto daily_task;
  }
  L(5);
  $r1 = base_run(host.$r["tasks_level"][0]);
  if(preg_match('#suc#is',$r1["notif"])){
    print text_line(h.$r1["notif"]);
  } else {
    print m.$r1["notif"];
    r();
  }
}

daily_task:
$r = base_run(host."tasks");
#die(file_put_contents("response_body.html",$r["res"]));
if($r["status"] == 403){
  print m."cloudflare!".n;
  unlink(cookie_only);
  goto DATA;
} elseif($r["account"]){
  print m."cookie expired!".n;
  unlink(cookie_only);
  goto DATA;
}
$b = -1;
while(true){
  $b++;
  if(!$r["mark"][$b]){
    goto shortlinks;
  }
  if(preg_match('#disabled#is',$r["mark"][$b])){
    continue;
  }
  L(5);
  $r1 = base_run(host.$r["tasks_level"][$b]);
  if(preg_match('#suc#is',$r1["notif"])){
    print text_line(h.$r1["notif"]);
  } else {
    print m.$r1["notif"];
    r();
  }
}




shortlinks:
while(true){
  $r = base_run(host."shortlinks");
  if($r["status"] == 403){
    print m."cloudflare!".n;
    unlink(cookie_only);
    goto DATA;
  } elseif($r["account"]){
    print m."cookie expired!".n;
    unlink(cookie_only);
    goto DATA;
  }
  $bypas = visit_short($r);
  if($bypas == "refresh"){
    continue;
  } elseif(!$bypas){
    goto auto;
  }
  $r1 = base_run($bypas);
  if(preg_match('#suc#is',$r1["notif"])){
    print h.$r1["notif"].n;
    line();
  } else {
    print m.$r1["notif"];
    r();
  }
}


auto:
$r = base_run(host);#die(print_r($r));
if($r["status"] == 403){
  print m."cloudflare!".n;
  unlink(cookie_only);
  goto DATA;
} elseif($r["account"]){
  print m."cookie expired!".n;
  unlink(cookie_only);
  goto DATA;
} elseif(!$r["token"]){
  goto auto;
}
$rsp = array("coins" => "usdt");
$data = data_post($r["token"], "null");
$n = 0;
while(true){
  $n++;
  if($n == 2){
    unset($data);
  }
  if(diff_time(2, "7:01") == 1){
    goto home;
  }
  $r = base_run(host."start", $data);
  if($r["status"] == 403){
    print m."cloudflare!".n;
    unlink(cookie_only);
    goto DATA;
  } elseif($r["account"]){
    print m."cookie expired!".n;
    unlink(cookie_only);
    goto DATA;
  } elseif(!$r["timer"]){
    continue;
  }
  tmr(2, $r["timer"]);
  $js = base_run(host."internal-api/payout/")["json"];
  if($js->success == true){
    ket("balance",number_format($js->balance)." ACP");
    ket("reward",$js->logs->USDT." Satoshi USDT");
    ket("time_left",$js->time_left);
    line();
  }
}

function base_run($url, $data = 0, $xml = 0){
  global $host;
  $header = head_fire($xml);
  $r = curl($url,$header,$data,true,false);
  unset($header);
  #$r[1] = file_get_contents("response_body.html");
  #die(file_put_contents("response_body.html",$r[1]));
  $json = json_decode(base64_decode($r[1]));
  if(!$json){
    $json = $r[2];
  }
  
  preg_match_all("#name='(.*?)'(.*?).val(.*?)'(.*?)'#is",$r[1],$uniqid);
  preg_match_all('#class="sl-title">(.*?)<#is',strtolower($r[1]),$name);
  preg_match_all('#class="boxviews-left-box">(.*?)<#is',trimed($r[1]),$left);
  if($name[1]){
    preg_match_all('#<formtarget="_blank"action="/(.*?)[0-9]*/"method="POST"style="display:inline(.*?)"><buttontype="submit"(.*?)target="_blank">(.*?)<#is',str_replace('"value="','=',str_replace('"><inputtype="hidden"name="','&',trimed($r[1]))),$sl);
    for($z=0;$z<count($name[1]);$z++){
      if($name[1][0] == $name[1][$z]){
        $y = "0";
      } else {
        $y += explode("/",$left[1][$z])[1];
      }
      $qq += explode("/",$left[1][$z])[1];
      for($x=$y;$x<$qq;$x++){
        if($sl[1][$qq-1] == $sl[1][$x]){
          $xx[] = $sl[4][$x];
          $yy[] = $sl[1][$x].$sl[4][$x];
          $zz[] = $sl[2][$x];
          $cc = [$xx,$yy,$zz];
        }
      }
      $aa[$name[1][$z]] = $cc;
      unset($cc);
      unset($zz);
      unset($xx);
      unset($yy);
    }
    $combine = array_merge($aa, array_combine($uniqid[1], $uniqid[4]));
    $code = $uniqid[1];
    #die(print_r($combine));
  } else {
    $combine = ["script" => "firekontol"];
  }
  preg_match_all('#<input type="hidden" name="(.*?)" value="(.*?)">#is',$r[1],$token);
  preg_match('#(retry after|back after) ([0-9]*) (seconds|minutes)#is',$r[1],$timer);
  preg_match("#(Dont have an account?)#is",$r[1],$account);
  preg_match_all('#(Welcome,</div> |1d202b"><b>)(.*?)<#is',$r[1],$info);
  preg_match('#class="(error_msg hoverable|success_msg hoverable)">(.*?)</div>#is',$r[1],$notif);
  preg_match('#Claim Rewards (.*?)<#is',$r[1],$claim_reward);
  preg_match_all('#<a href="/((levels?[a-zA-Z0-9-=?&]*claim[a-zA-Z0-9-=&]*)|(tasks?[a-z-\/]*collect[0-9-\/]*))#is',$r[1],$tasks_level);
  preg_match_all('#\d+/\d+#is',str_replace(['</span>','<bstyle="color:#00b8a5">'],"",trimed($r[1])),$part);
  preg_match_all('#class="btn waves-effect waves-light collect(.*?)"#is',$r[1],$mark);
  preg_match("#captcha-recaptcha','(.*?)'#is",$r[1],$recaptcha);
  preg_match("#captcha-hcaptcha','(.*?)'#is",$r[1],$hcaptcha);  
  preg_match('#challenge.script(.*?)k=(.*?)"#is',$r[1],$solvemedia);
  preg_match_all('#<input name="(.*?)" type="radio" id="select-(.*?)"#is',$r[1],$type);
  
  if(trimed($info[2][0]) == "Xianying7"){
    $solve = "z59ESC-Y0q8vs9l4gg1yur9HoeNRbisB";
  }
  print p;
  return array_merge($combine, [
    "account" => $account,
    "res" => $r[1],
    "json" => $json,
    "visit" => $left[1],
    "left" => $left[1],
    "name" => $name[1],
    "username" => $info[2][0],
    "balance" => $info[2][1]." ACP",
    "token" => $token,
    "timer" => $timer[2],
    "notif" => strip_tags($notif[2]),
    "claim_reward" => preg_replace("/[^0-9]/","",$claim_reward[1]),
    "tasks_level" => $tasks_level[1],
    "mark" => $mark[0],
    "private_solvemedia" => $solve,
    "solvemedia" => $solvemedia[2],
    "recaptcha" => $recaptcha[1],
    "hcaptcha" => $hcaptcha[1],
    "type" => $type,
    "url" => $r[0][0]["location"],
    "code" => $code
    ]);
}

function head_fire($xml = false){
  global $u_a, $u_c;
  $header = array();
  $header[] = "Host: ".explode("/",host)[2];
  $header[] = "referer: ".host;
  $header[] = "user-agent: ".$u_a;
  if($xml){
    $header[] = "x-requested-with: XMLHttpRequest";
  }
  if($u_c){
    $header[] = "cookie: ".$u_c;
  }
  return $header;
}