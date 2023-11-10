<?php


/*
function get_e($input){
    while(true){
        $string = file_get_contents($input);
        if(!$string){
            continue;
        } else {
            return $string;
        }
    }
} 
*/
if($eval == false){
    error_reporting(0);
    eval(str_replace('<?php',"",get_e("build_index.php")));
    eval(str_replace('<?php',"",get_e("shortlink_index.php")));
}
#die(print_r(analysis_icon($img)));
eval(str_replace('name_host',explode(".","earnbitmoon.club")[0],str_replace('example','earnbitmoon.club','const host="https://example/",sc="name_host",cookie_only="cookie_example",mode="vie_free";')));



DATA:
$u_a = save("useragent");
$u_c = save(cookie_only);


c();
$r = base_run(host);
if($r["status"] == 403){
    print m."cloudflare!".n;
    unlink(cookie_only);
    goto DATA;
} elseif($r["logout"]){
    print m."cookie expired!".n;
    unlink(cookie_only);
    goto DATA;
}
$update = $r["info"][1];
ket(">","earnbitmoon test");
ket("username",$r["username"]);
ket("balance",$r["balance"][0],"value",$r["balance"][1]);
ket("claim today",$r["info"][0],"total claim",$r["info"][1]);
line();
print n;

faucet:

while(true){
  $r = base_run(host);
  if($r["status"] == 403){
    print m."cloudflare!".n;
    unlink(cookie_only);
    goto DATA;
  } elseif($r["logout"]){
    print m."cookie expired!".n;
    unlink(cookie_only);
    goto DATA;
  }
  if($r["timer"]){
    if($update == $r["info"][1]){
      /*update jadi kontol babi ngemtot*/
    } else {
      ket("balance",$r["balance"][0],"value",$r["balance"][1]);
      ket("claim today",$r["info"][0],"total claim",$r["info"][1]);
      line();
    }
    countdown($r["countdown"]);
    continue;
  }
  $icon_answer = icon_answer();
  if(!$icon_answer){
    continue;
  }
  $data = http_build_query([
    "a" => "getFaucet",
    "token" => $r["token"],
    "captcha" => 3,
    "challenge" => false,
    "response" => false,
    "ic-hf-id" => 1,
    "ic-hf-se" => $icon_answer,
    "ic-hf-hp" => ""
    ]);
    $r = base_run(host."system/ajax.php", $data, 1);
    if($r["status"] == 200){
      $js = $r["json"];
      ket("number",number_format($js->number,0,',',','));
      ket("reward",$js->reward);
      line();
    }
}





function base_run($url, $data = 0, $xml = 0,  $boundary = 0){
  $header = head($xml, $boundary);
  $r = curl($url,$header,$data,true,false);
  unset($header);
  #$r[1] = file_get_contents("bitmun.html");
  #die(file_put_contents("bitmun.html",$r[1]));
  $json = json_decode(base64_decode($r[1]));
  if(!$json){
  $json = $r[2];
  }
  preg_match("#(Keep me logged in for 1 week)#is",$r[1],$logout);
  preg_match_all('#="(sidebarCoins|text-success|text-dark|text-danger)">(.*?)<#is',str_replace("<b>","",$r[1]),$info);
 # die(print_r($info));
  preg_match("#([a-z0-9]{64})#is",$r[1],$token);
  preg_match_all("#([0-9]{13})#is",$r[1],$countdown);
  preg_match('#(var secs = |id="claimTime">)([0-9]{2}|[0-9]{1})(;| h| m| s)#is',$r[1],$tmr);
  print p;
  return [
    "logout" => $logout,
    "res" => $r[1],
    "json" => $json,
    "username" => $info[2][0],
    "balance" => [$info[2][1],$info[2][2]],
    "info" => [$info[2][3],$info[2][4]],
    "token" => $token[1],
    "countdown" => $countdown[1],
    "timer" => $tmr[2],
    "status" => $r[0][1]["http_code"]
    
    ];
  }
  

  





