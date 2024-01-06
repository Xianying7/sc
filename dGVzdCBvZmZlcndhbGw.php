<?php







if($eval == false){
    error_reporting(0);
    eval(str_replace('<?php',"",get_e("build_index.php")));
    eval(str_replace('<?php',"",get_e("shortlink_index.php")));
}

eval(str_replace('name_host',explode(".","bitcotasks.com")[0],str_replace('example','bitcotasks.com','const host="https://example/",sc="name_host",cookie_only="cookie_example",mode="ofer";')));


DATA:
$u_a = save("useragent");
$url = save("url_offerwall");

$build = parse_url(str_replace("//offerwall","/offerwall",$url));
$user = explode("/",$build["path"])[3];
$key = explode("/",$build["path"])[2];


unlink("ofer.txt");

home:
c();
ket(1, "shortlinks", 2, "ptc");#, 3, "game");
$inp = tx("number").line();
if($inp == 1 || $inp == 2){# || $inp == 3){
  print k."start offerwall";
  r();
} else {
  exit;
}
offerwall:
$x = 0;
while(true){
  $x++;
  unlink("ofer.txt");
  $r = base_offer($url);
  #die(print_r($r));
  if($r["status"] == 403){
    die(m."cloudflare!".n);
  } elseif($r["status"] >= 201){
    continue;
  }


  if($inp == 1){
    $data = http_build_query([
      "type" => "shortlinks",
      "token" => $r["data"][0],
      "action" => "switch_cat"
      ]);
      $t = time()+60;
      $r1 = base_offer($url, $data, 1);#die(print_r($r1));
      $data_token = array(
        "sid" => $user,
        "key" => $key,
        "token" => $r["data"][0]
      );
      $bypass = visit_short($r1, $url, $data_token);
      if($bypass == "refresh" || $bypass == "skip"){
        goto offerwall;
      } elseif(!$bypass){
        goto home;
      }
      if($bypass){
        $t1 = time();
        if($t - $t1 >= 1){
          L($t - $t1);
        }
        $r2 = base_offer($bypass);
        if(preg_match("#suc#is",$r2["notif"])){
          print h.$r2["notif"].n;
          line();
          goto offerwall;
        }
      }
      if($x == 3){
        goto home;
      }
      continue;
  } elseif($inp == 2){
  $data = http_build_query([
    "type" => "ptc",
    "token" => $r["data"][0],
    "action" => "switch_cat"
    ]);
  } elseif($inp == 3){
  games:
  $data = http_build_query([
    "type" => "games",
    "token" => $r["data"][0],
    "action" => "switch_cat"
    ]);
  $r1 = base_offer($url, $data, 1);
  if($r1["lg"]){
    $lg = "https://".$build["host"].$r1["lg"];
    $r1 = base_offer($lg);
    #die(print_r($r1));
    $data = http_build_query([
      "score" => 512,
      "action" => "proccess_game",
      "token" => $r["data"][0],
      ]);print($data);
    L(30); 
    $r1 = base_offer($lg, $data, 1);
    die(print_r($r1));
  } else {
   continue;
  }
  die(print_r($r1));
  die(print_r(json_decode($r1["res"])));
  }
  #die($data);
  $r1 = base_offer($url, $data, 1);
  #die(print_r($r1));
  if($r1["status"] == 403){
    die(m."cloudflare!".n);
  } elseif($r1["status"] >= 201){
    continue;
  } elseif(!$r1["hash"]){
    unlink("ofer.txt");
    die(text_line(m."We're sorry but there are no more offers available right now. Please try again later!"));
  }
  #die(print_r($r1));
  $data = http_build_query([
    "hash" =>  $r1["hash"],
    "sid" => $user,
    "key" => $key,
    "type" => "ptc",
    "token" => $r["data"][0],
    "action" => "init_transaction"
    ]);
    $r2 = base_offer($url, $data, 1);
    if($r2["status"] == 403){
      die(m."cloudflare!".n);
    } elseif($r2["status"] >= 201){
      continue;
    }
    $r3 = base_offer($r2["json"]->offer);
    if($r3["status"] == 403){
      die(m."cloudflare!".n);
    } elseif($r3["status"] >= 201){
      continue;
    }
    #die(print_r($r3));
    L($r3["timer"]);
    $cap = icon_offer("https://".$build["host"]."/");
    $data = http_build_query([
      "hash" => $r3["data"][2],
      "sub_id" => $r3["data"][1],
      "key" => $r3["data"][3],
      "token" => $r3["data"][0],
      "captcha-idhf" => 0,
      "captcha-hf" => $cap,
      "action" => "proccessLead"
      ]);
      $js = base_offer("https://".$build["host"]."/system/ajax.php", $data, 1);
      if($js["json"]->status == 200){
      print h.$js["json"]->message.n;
      line();
      }
}



function base_offer($url, $data = 0, $xml = 0){
  $header = head_offer($xml);
  $r = curl($url,$header,$data,true,"ofer.txt");
  unset($header);
  #$r[1] = file_get_contents("bitmun.html");
  #die(file_put_contents("bitmun.html",$r[1]));
  $json = json_decode(base64_decode($r[1]));
  if(!$json){
  $json = $r[2];
  #$json = json_decode($r[1]);
  }
  preg_match("#to_link = '(.*?)'#is",$r[1],$url);
  preg_match_all("#var (token|sub_id|hash|key|game_token) = '(.*?)'#is",$r[1],$data);
  preg_match_all('#data-hash=\\\"(.*?)\\\"#is',$r[1],$hash);
  preg_match_all('#data-slid=\\\"(.*?)\\\"#is',$r[1],$slid);
  preg_match_all('#<h3>(.*?)<#is',str_replace("t<h3><","",$r[1]),$name);
  preg_match_all('#>(\d+•+\d+)<#is',str_replace("<\/span>\/","•",$r[1]),$z);
  preg_match('#<div class="alert alert-success mt-0" role="alert"><b>(.*?)</b>(.*?)</div>#is',$r[1],$notif);
  preg_match("#([a-z0-9]{64})#is",$r[1],$token);  
  preg_match('#(let ctimer = |var duration = |id="claimTime">)([0-9]{3}|[0-9]{2}|[0-9]{1})(;)#is',str_replace("'","",$r[1]),$tmr);
  preg_match_all('#<input type="hidden" name="(.*?)" value="(.*?)">#is',$r[1],$token);
  preg_match('#<button value="(.*?)"#is',$r[1],$game);
  #preg_match_all('#<a href="(.*?)"#is',$r[1],$play);
  preg_match_all('#(https?:\/\/[a-zA-Z0-9\/-\/.-]*\/game\/play\/?[0-9-\/]*)(.*?)#is',$r[1],$play);
  preg_match('#(play )(\d+\/+\d+)#is', $r[1],$ready);
  preg_match('#recaptcha" data-sitekey="(.*?)"#is',$r[1],$recaptchav2);
  preg_match("#window.open[(]'(.*?)'#is",$r[1],$lg);
  # https://coins-battle.com/game/play/353
  print p;
  return [
    "logout" => $logout,
    "res" => $r[1],
    "json" => $json,
    "hash" => $hash[1][0],
    "data" => $data[2],
    "token" => $token[1],
    "visit" => $slid[1],
    "left" => $z[1],
    "name" => $name[1],
    "url" => $url[1],
    "timer" => $tmr[2],
    "notif" => $notif[1].$notif[2],
    "game" => $game[1],
    "play" => $play[1],
    "ready" => $ready[2],
    "token" => $token,
    "recaptchav2" => $recaptchav2[1],
    "lg" => stripslashes($lg[1]),
    "status" => $r[0][1]["http_code"]
    
    ];
  }
  

function head_offer($xml = 0){
  global $u_a;
  $header = array();
  if($xml){
    $header[] = "x-requested-with: XMLHttpRequest";
  }
  if(!$u_a){
    $u_a = user_agent();
  }
  $header[] = "user-agent: ".$u_a;
  return $header;
}



function icon_offer($host){
  $data = http_build_query([
    "cID" => false,
    "rT" => true,
    "tM" => "light"
    ]);
    $r = base_offer($host."system/libraries/captcha/request.php",$data, 1);
    if($r["status"] >= 201){
      return "";
    }
    $hash = $r["json"];
    for ($x = 0; $x < count($hash); $x++){
      $r1 = base_offer($host."system/libraries/captcha/request.php?cid=0&hash=".$hash[$x]);
      if($r1["status"] >= 201){
        return "";
      }
      $file_size[] = strlen(str_replace([n," "],"",trimed($r1["res"])));
    }
    $array = array_count_values($file_size);
    for($i = 0; $i < count($file_size); $i++){
      if(!$file_size[$i]){
        break;
      }
      $code[] = $array[$file_size[$i]];
    }
    for($i = 0; $i < count($file_size); $i++){
      if($code[$i] == 1){
        $proses  = "$i";
        break;
      }
    }
    $answer = $hash[$proses];
    $data1 = http_build_query([
      "cID" => false,
      "pC" => $answer,
      "rT" => 2
      ]);
      $r = base_offer($host."system/libraries/captcha/request.php",$data1, 1);
      if($r["status"] == 200){
        return $answer;
      }
}



