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
  print m."cookie expired!".n;
  unlink(cookie_only);
  goto DATA;
}

c().asci(sc).ket("username",$r["username"],"balance",$r["balance"],"drops",$r["drops"]);
line();
print n;

while(true){
$r = base_run(host."member/task/sitefriends");
if($r["status"] == 403){
  print m."cloudflare!".n;
  unlink(cookie_only);
  goto DATA;
} elseif($r["status"] >= 201){
  print m."cookie expired!".n;
  unlink(cookie_only);
  goto DATA;
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
  print m."cookie expired!".n;
  unlink(cookie_only);
  goto DATA;
}
if(!$r1['param'][1]){
die("hcaptcha");
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
  
  print p;
  return [
    "res" => $r[1],
    "json" => json_decode($r[1])->components[0]->effects->html,
    "username" => $info[2][0],
    "balance" => $info[2][1],
    "drops" => $info[2][2],
    "csrf" => $node["csrf"],
    "user_token" => $node["user_token"],
    "data_user" => $node["snapshot"][1],
    "data_visit" => $node["snapshot"][4],
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

