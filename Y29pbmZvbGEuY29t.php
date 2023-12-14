<?php




if($eval == false){
  eval(str_replace('<?php',"",get_e("build_index.php")));
  eval(str_replace('<?php',"",get_e("shortlink_index.php")));
}





eval(str_replace('name_host',explode(".",'coinfola.com')[0],str_replace('example','coinfola.com','const host="https://example/",sc="name_host",cookie_only="cookie_example",mode="site_url";')));


DATA:
$u_a = save("useragent");
$u_c = save(cookie_only);
#$r = base_run(host."shortlinks");#die(print_r($r));




$r = base_run(host."account");
if($r["status"] == 403){
  print m."cloudflare!".n;
  unlink(cookie_only);
  goto DATA;
} elseif($r["status"] == 302){
  print m."cookie expired!".n;
  unlink(cookie_only);
  goto DATA;
}

c().asci(sc).ket("username",$r["username"],"balance",$r["balance"]);
line();
print n;


shortlinks:
while(true){
  $r = base_run(host."shortlinks");#die(print_r($r));
  if($r["status"] == 403){
    print m."cloudflare!".n;
    unlink(cookie_only);
    goto DATA;
  } elseif($r["status"] == 302){
    print m."cookie expired!".n;
    unlink(cookie_only);
    goto DATA;
  }
  $bypas = visit_short($r, host."shortlinks", "csrfToken=&go=");
  if($bypas == "refresh"){
    continue;
  } elseif(!$bypas){
    die(lah(1,"shortlinks"));
  }
  $r1 = base_run($bypas);
  if(preg_match("#cong#is",$r1["notif"])){
     print h.$r1["notif"].n;
     line();
  }
}



function base_run($url, $data = 0){
  $header = head();
  $r = curl($url,$header,$data,true,false);
  unset($header);
  #$r[1] = file_get_contents("fola.html");
  #die(file_put_contents("bitmun.html",$r[1]));
  $json = json_decode(base64_decode($r[1]));
  preg_match_all('#(class="fa-regular fa-user"></i> |<span id="balance">)(.*?)<#is',$r[1],$info);  
  preg_match_all("#message: '(.*?)'#is",$r[1],$notif);  
  preg_match_all('#" data-id="(.*?)"#is',$r[1],$visit);
  preg_match_all('#<span class="fw-bold">(.*?)<#is',$r[1],$name);  
  preg_match_all('#pointer"></i>(.*?)</span#is',$r[1],$left);
  #die(print_r($left));
  
  print p;
  return [
    "res" => $r[1],
    "username" => $info[2][0],
    "balance" => $info[2][1],
    "notif" => $notif[1][0].n.$notif[1][1],
    "name" => $name[1],
    "visit" => preg_replace("/[^0-9]/","",$visit[1]),
    "left" => preg_replace("/[^0-9]/","",$left[1]),
    "url" => $r[0][0]["location"],
    "status" => $r[0][1]["http_code"]
    ];
}
