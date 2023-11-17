<?php




if($eval == false){
    error_reporting(0);
    eval(str_replace('<?php',"",get_e("build_index.php")));
    eval(str_replace('<?php',"",get_e("shortlink_index.php")));
}

eval(str_replace('name_host',explode(".","freebitco.in")[0],str_replace('example','freebitco.in','const host="https://example/",sc="name_host",cookie_only="cookie_example";')));


DATA:
$u_a = save("useragent");
$u_c = save(cookie_only);

foreach(explode(";",substr(str_replace(" ","",$u_c),0)) as $i => $line){
  list($key, $value) = explode('=',$line);
  $header_array[$key] = $value;
}

$csrf_token = $header_array["csrf_token"];
if(!$csrf_token){
  print m.sc." cookie expired!".n;
  unlink(cookie_only);
  goto DATA;
}

$r = base_run(host."?op=home");
if(!$r["email"]){
  print m.sc." cookie expired!".n;
  unlink(cookie_only);
  goto DATA;
}
c().asci(sc).ket("address",$header_array["btc_address"],"email",$r["email"],"balance",$r["balance"]).line();

while(true){
  if($r["timer"]){
    tmr(1,$r["timer"]);
  }
  $method = "hcaptcha";
  $cap = multibot($method,$r[$method],host."?op=home");
  if(!$cap){
    continue;
  }
  $data = http_build_query([
    "csrf_token" => $csrf_token,
    "op" => "free_play",
    "fingerprint" => "3aaa8b289296f05a860f0558305a5c78",
    "client_seed" => az_num(16),
    "fingerprint2" => "3377443749",
    "pwc" => false,
    "h_recaptcha_response" => $cap
    ]);
    $r1 = base_run(host, $data);
    $notif = explode(":",$r1["res"]);
    if($notif[0] == "s"){
      ket("reward",$notif[3]." BTC");
      ket("balance",$notif[2]." BTC");
      line();
      tmr(1,3605);
    }
}


function base_run($url, $data = 0){
  while(true){
    $header = ua($data);
    $r = curl($url, $header, $data, true, false);
    if($r[0][1]["http_code"] == 0){
      unset($header);
      continue;
      }
      #$r[1] = file_get_contents("bitmun.html");
      #die(file_put_contents("bitmun.html",$r[1]));
      $json = json_decode(base64_decode($r[1]));
      if(!$json){
        $json = $r[2];
      }
      preg_match_all('#id="(contact_form_email" value="|balance2">)(.*?)("|<)#is',$r[1],$info);
      preg_match_all('#none;">(\d+)<#is',$r[1],$poin);
      preg_match_all('#(title_countdown)(.*?)([0-9]{4}|[0-9]{3}|[0-9]{2}|[0-9]{1})(.*?)#is',$r[1],$tmr);
      #die(print_r($poin));
      print p;
      return [
        "res" => $r[1],
        "json" => $json,
        "email" => $info[2][1],
        "balance" => $info[2][0],
        "poin" => $poin[1][2],
        "timer" => $tmr[3][0],
        "hcaptcha" => "6ba78ccd-f275-4c2d-be45-5e4b46a4a4d8",
        "status" => $r[0][1]["http_code"]
        ];
  }
}
  



function ua($data=0){
  global $csrf_token,$u_a,$u_c;
  $header[] = 'Host: freebitco.in';
  if($data){
    $header[] = 'content-length: '.strlen($data);
    $header[] = 'x-csrf-token: '.$csrf_token;
    $header[] = 'content-type: application/x-www-form-urlencoded; charset=UTF-8';
    $header[] = 'accept: */*';
    $header[]="x-requested-with: XMLHttpRequest";
    $header[] = 'origin: https://freebitco.in';
    $header[] = 'referer: '.host.'?op=home';
    $header[] = 'sec-fetch-site: same-origin';
    $header[] = 'sec-fetch-mode: cors';
    $header[] = 'sec-fetch-dest: empty';
  } else {
    $header[] = 'cache-control: max-age=0';
    $header[] = 'upgrade-insecure-requests: 1';
    $header[] = 'user-agent: '.$u_a;
    $header[] = 'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9';
    $header[] = 'sec-fetch-site: none';
    $header[] = 'sec-fetch-mode: navigate';
    $header[] = 'sec-fetch-user: ?1';
    $header[] = 'sec-fetch-dest: document';
  }
  $header[] = 'sec-ch-ua: "Chromium";v="93", " Not;A Brand";v="99"';
  $header[] = 'sec-ch-ua-mobile: ?1';
  $header[] = 'accept-encoding: gzip, deflate';
  $header[] = 'accept-language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7';
  $header[] = 'cookie: '.$u_c;
  return $header;
}

