<?php


if($eval == false){
    error_reporting(0);
    eval(str_replace('<?php',"",get_e("build_index.php")));
    eval(str_replace('<?php',"",get_e("shortlink_index.php")));
}
go:
c();
$web = [
    1 => "ltchunt.com",
    2 => "btccanyon.com"
];
for($i=1;$i<10;$i++){
    if($web[$i]){
        ket($i,$web[$i]);
    }
}
$p = preg_replace("/[^0-9]/","",trim(tx("number")));
$host=$web[$p];
if(!$host){
    goto go;
}

eval(str_replace('name_host',explode(".",$host)[0],str_replace('example',$host,'const host="https://example/",sc="name_host",cookie_only="cookie_example",mode="icon";c();')));

DATA:
$u_a = save("useragent");
$u_c = save(cookie_only);

c();
$r = base_run(host."ptc.html");
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
c().asci(sc).ket("username",$r["username"]);
ket("balance",$r["balance"][0],"value",$r["balance"][1]);
line();
print n;


ptc:
while(true){
  $r = base_run(host."ptc.html");
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
    if(!$r["id"]) {
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
        ket("message",explode("received ",$js->message))[1];
        line();
        }
    }
}


shortlinks:
while(true) {
  $r = base_run(host."shortlinks.html");
  if($r["status"] == 403){
    print m."cloudflare!".n;
    unlink(cookie_only);
    goto DATA;
  } elseif($r["logout"]){
    print m."cookie expired!".n;
    unlink(cookie_only);
    goto DATA;
  }
  $bypas = visit_short($r);
  if($bypas == "refresh") {
    continue;
  } elseif(!$bypas) {
    lah(1,"shortlinks");
    $delay = $r["delay"];
    rsort($delay);
    tmr(2, $delay[0]);
    goto ptc;
  }
  $r1 = base_run($bypas);
  if($r1["notif"]) {
    $reward = explode("!",$r1["notif"]);
     print h.$reward[0];
     r();
     ket("reward",explode("received ",$reward[1])[1]);
     ket("balance",$r1["balance"][0],"value",$r1["balance"][1]).line();
  }
}



function base_run($url, $data = 0, $xml = 0){
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
  preg_match_all('#(font|<div) class="(text-success|text-primary|text-warning)">(.*?)<#is',str_replace("<b>","",$r[1]),$info);
  preg_match("#childWindow=open(.*?)',#is",trimed($r[1]),$surf);
  preg_match('#website_block" id="(.*?)"#is',$r[1],$id);
  if($id[1][0]){
    $surf_id = str_replace("'+a+'",$id[1],str_replace("(base+'/","",$surf[1]));
  }
  preg_match("#([a-z0-9]{64})#is",$r[1],$token);
  preg_match_all("#([0-9]{13})#is",$r[1],$countdown);
  preg_match('#(var secs = |id="claimTime">)([0-9]{2}|[0-9]{1})(;| h| m| s)#is',$r[1],$tmr);
  preg_match_all('#align-middle">(.*?)</td><tdclass="align-middletext-center"><bclass="badgebadge-dark">(.*?)</b></td><tdclass="align-middletext-center"><bclass="badgebadge-dark">(.*?)</b></td><tdclass="(text-right|align-middletext-center)">(.*?)(role|"class=)#is',trimed($r[1]),$sl);
  preg_match('#(successmt-0"|alert-success mt-0" )role="alert">(.*?)<#is',$r[1],$n);
  preg_match_all('#data-seconds-left="(.*?)"#is',$r[1],$delay);
  print p;
  return [
    "logout" => $logout,
    "res" => $r[1],
    "json" => $json,
    "username" => $info[3][0],
    "balance" => [$info[3][1],$info[3][2]],
    "token" => $token[1],
    "id" => $id[1],
    "surf_id" => $surf_id,
    "countdown" => $countdown[1],
    "timer" => $tmr[2],
    "visit" => $sl[5],
    "left" => $sl[3],
    "name" => $sl[1],
    "notif" => $n[2],
    "delay" => $delay[1],
    "status" => $r[0][1]["http_code"]
    
    ];
}
  
