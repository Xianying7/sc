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
c().asci(sc).ket("username",$r["username"]);
ket("balance",$r["balance"]);
line();
print n;


shortlinks:
while(true){
  $time = date("H:i");
  $r = base_run(host."shortlinks");#die(print_r($r));
  #die(file_put_contents("bitmun.html",$r["res"]));
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
  if($r1["notif"]){
    print h.$r1["notif"].n;
    line();
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
  $start = strtotime($time);
  $stop = strtotime(date("H:i"));
  $diff = ($stop - $start);
  if(explode("-",$diff)[1]){
    $dif = explode("-",$diff)[1];
  } else {
    $dif = $diff;
  }
  if($fr * 60 >= $dif){
    goto shortlinks;
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
  
  preg_match("#(Dont have an account?)#is",$r[1],$login);
  preg_match_all('#(Welcome,</div> |1d202b"><b>)(.*?)<#is',$r[1],$info);
  preg_match('#class="success_msg hoverable"><b>(.*?)</div>#is',$r[1],$account);
  preg_match('#class="(error_msg hoverable|success_msg hoverable)">(.*?)</div>#is',$r[1],$notif);
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


