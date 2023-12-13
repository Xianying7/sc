<?php



if($eval == false){
  eval(str_replace('<?php',"",get_e("build_index.php")));
  eval(str_replace('<?php',"",get_e("shortlink_index.php")));
}


eval(str_replace('name_host',explode(".",'my.dropz.xyz')[0],str_replace('example','my.dropz.xyz','const host="https://example/",sc="name_host",cookie_only="cookie_example",mode="site_url";')));

DATA:
$u_a = save("useragent");
$u_c = save(cookie_only);

$r = base_run(host."member/task/sitefriends");
if($r["status"] == 403){
  print m."cloudflare!".n;
  unlink(cookie_only);
  goto DATA;
} elseif($r["status"] >= 201){
  goto DATA;
} elseif(!$r["username"]){
  print m."cookie expired!".n;
  unlink(cookie_only);
  goto DATA;
}

c().asci(sc).ket("username",$r["username"],"balance",$r["balance"],"drops",$r["drops"]);
line();
print n;

while(true){
$u_c = save(cookie_only);
$r = base_run(host."member/task/sitefriends");
if($r["status"] == 403){
  print m."cloudflare!".n;
  unlink(cookie_only);
  goto DATA;
} elseif($r["status"] >= 201){
  continue;
} elseif($notif == true){
  ket("balance",$r["balance"],"drops",$r["drops"]);
  line();
  unset($notif);
}
$data = json_encode([
  '_token' => $r["csrf"],
  'components' => [
    [
      'snapshot' => $r["data_visit"],
      'updates' => json_decode('{}'),
      'calls' => [
        [
          'path' => '',
          'method' => 'visitSite',
          'params' => [
            $r["user_token"]
          ]
        ]
      ]
    ]
  ]
]);
$r1 = base_run(host."livewire/update", 1, $data);
if($r1["status"] == 403){
  print m."cloudflare!".n;
  unlink(cookie_only);
  goto DATA;
} elseif($r1["status"] >= 201){
  continue;
}
if(!$r1['param'][1]){
$r = base_run("https://my.dropz.xyz/member/check-point?redirect=http%3A%2F%2Fmy.dropz.xyz%2Fmember%2Ftask%2Fsitefriends");
if($r["status"] == 403){
  print m."cloudflare!".n;
  unlink(cookie_only);
  goto DATA;
} elseif($r["status"] >= 201){
  continue;
}

print("bypass hcaptcha".n);
$cap = multibot("hcaptcha","5cb93c93-ed2d-4f52-bcbb-9a896cc6b071",host."member/task/sitefriends");
$data = json_encode([
  '_token' => $r["csrf"],
  'components' => [
    [
      'snapshot' => $r["data_begal"],
      'updates' => json_decode('{}'),
      'calls' => [
        [
          'path' => '',
          'method' => '__dispatch',
          'params' => [
            'validate-session',
            [
            'hCaptchaResponse' => $cap,
            'redirect' => 'http://my.dropz.xyz/member/task/sitefriends'
            ]
          ]
        ]
      ]
    ]
  ]
]);
$r1 = base_run(host."livewire/update", 1, $data);
if($r1["status"] >= 201){
  continue;
}
unlink(cookie_only);
$new_cookie = new_cookie($u_c, $r1["cookie"]);
file_put_contents(cookie_only, $new_cookie);
unset($u_c);
continue;
}
base_run(host."member/external/visit/".$r1['param'][2]."/".$r1['param'][1]);
L(15);

$data = json_encode([
  '_token' => $r["csrf"],
  'components' => [
    [
      'snapshot' => $r["data_visit"],
      'updates' => json_decode('{}'),
      'calls' => [
        [
          'path' => '',
          'method' => '__dispatch',
          'params' => [
            'validate-visit',
            [
            'visitResponse' => $r1['param'][2],
            'adsId' => $r1['param'][1]
            ]
          ]
        ]
      ]
    ]
  ]
]);

$r2 = base_run(host."livewire/update", 1, $data);
if(preg_match("#yey!#is",$r2["notif"])){
   print h.$r2["notif"].n;
   line();
   $notif[] = 1;
} else {
  print m.$r2["notif"];
  r();
  }
}



function base_run($url, $js = 0, $data = 0){
  $header = h_p($js);
  $r = curl($url,$header,$data,true,false);
  unset($header);
  #$r[1] = file_get_contents("fola.html");
  #die(file_put_contents("bitmun.html",$r[1]));
  $j = json_decode($r[1])->components[0]->effects;
  if($j){
    $node = executeNode($j->html);
  } else {
    $node = executeNode($r[1]);
  }
  preg_match_all('#(class="font-weight-bold">Hi, |class="mb-0 font-weight-bold">)(.*?)<#is',$r[1],$info);
  preg_match_all('#(title|message)":"(.*?)"#is',$r[1],$notif);  
  if($node["snapshot"]){#die(print_r($node["snapshot"]));
    for($i=0;$i<count($node["snapshot"]);$i++){
      if(preg_match('#"user":#is',$node["snapshot"][$i])){
        $data_user = $node["snapshot"][$i];
      }
      if(preg_match('#"clicksAvailable":#is',$node["snapshot"][$i])){
        $data_visit = $node["snapshot"][$i];
      }
      if(preg_match('#"auth.checkpoint.main"#is',$node["snapshot"][$i])){
        $data_begal = $node["snapshot"][$i];
      }
    }
  }
  #"memo":{"id
  #die(print_r($data_begal));
  print p;
  return [
    "cookie" => set_cookie($r[0][2]),
    "res" => $r[1],
    "json" => $j->html,
    "username" => $info[2][0],
    "balance" => $info[2][1],
    "drops" => $info[2][2],
    "csrf" => $node["csrf"],
    "user_token" => $node["user_token"],
    "data_user" => $data_user,
    "data_visit" => $data_visit,
    "data_begal" => $data_begal,
    "vghhh" => $node["snapshot"],
    "param" => $j->dispatches[0]->params[0]->param,
    "notif" => $notif[2][0]." ".$notif[2][1],
    "status" => $r[0][1]["http_code"]
    ];
}



function h_p($js){
    global $u_a,$u_c;
    $headers[] = 'Host: my.dropz.xyz';
    $headers[] = 'user-agent: '.$u_a;
    if($js){
      $headers[] = 'content-type: application/json
accept: */*';
    } else {
      $headers[] = 'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9';
    }
    $headers[] = 'referer: https://my.dropz.xyz/';
    $headers[] = 'accept-language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7';
    $headers[] = 'cookie: '.$u_c;
    return $headers;
}
