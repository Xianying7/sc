<?php

if($eval == false){
  eval(str_replace('<?php',"",get_e("build_index.php")));
  eval(str_replace('<?php',"",get_e("shortlink_index.php")));
}

eval(str_replace('name_host',explode(".","firefaucet.win")[0],str_replace('example',"firefaucet.win",'const host="https://example/",sc="name_host",cookie_only="cookie_example",mode="firefaucet";')));


DATA:
$u_a = save("useragent");
$u_c = save(cookie_only);

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
}


claim_reward:
while(true){
  $r = base_run(host."levels");#die(print_r($r));
  if($r["status"] == 403){
    print m."cloudflare!".n;
    unlink(cookie_only);
    goto DATA;
  } elseif($r["account"]){
    print m."cookie expired!".n;
    unlink(cookie_only);
    goto DATA;
  } elseif(!$r["claim_level"]){
    goto shortlinks;
  }
  L(5);
  $r1 = base_run(host.$r["claim_level"]);
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
$data = data_post($r["token"], "coins", "usdt")["null"];
$n = 0;
while(true){
  $n++;
  if($n == 2){
    unset($data);
  }
  if(diff_time(2, "8:00") == 1){
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

function base_run($url, $data = 0){
  global $host;
  $header = head_fire();
  $r = curl($url,$header,$data,true,false);
  unset($header);
  #$r[1] = file_get_contents("response_body.html");
  #die(file_put_contents("bitmun.html",$r[1]));
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
  preg_match('#retry after ([0-9]*) seconds#is',$r[1],$timer);
  
  preg_match("#(Dont have an account?)#is",$r[1],$account);
  preg_match_all('#(Welcome,</div> |1d202b"><b>)(.*?)<#is',$r[1],$info);
  #preg_match('#class="success_msg hoverable"><b>(.*?)</div>#is',$r[1],$account);
  preg_match('#class="(error_msg hoverable|success_msg hoverable)">(.*?)</div>#is',$r[1],$notif);
  preg_match('#Claim Rewards (.*?)<#is',$r[1],$claim_reward);
  preg_match('#<a href="/(levels?[a-zA-Z0-9-=?&]*claim[a-zA-Z0-9-=&]*)#is',$r[1],$claim_level);
  #die(print_r($claim_level));
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
    "timer" => $timer[1],
    "notif" => strip_tags($notif[2]),
    "claim_reward" => preg_replace("/[^0-9]/","",$claim_reward[1]),
    "claim_level" => $claim_level[1],
    "url" => $r[0][0]["location"],
    "code" => $code
    ]);
}

function head_fire(){
  global $u_a, $u_c;
  $header = array();
  $header[] = "Host: ".explode("/",host)[2];
  $header[] = "referer: ".host;
  $header[] = "user-agent: ".$u_a;
  if($u_c){
    $header[] = "cookie: ".$u_c;
  }
  return $header;
}
