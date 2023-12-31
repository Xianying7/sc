<?php


if (!$eval) {
    error_reporting(0);
    eval(str_replace('<?php', "", get_e("build_index.php")));
    eval(str_replace('<?php', "", get_e("shortlink_index.php")));
}

eval(str_replace('name_host', explode(".", "earnbitmoon.club")[0], str_replace('example', 'earnbitmoon.club', 'const host="https://example/",sc="name_host",cookie_only="cookie_example",mode="earnbitmoon";')));

DATA:
$u_a = save("useragent");
$u_c = save(cookie_only);

home:
  c();
  $home = base_run(host . "ptc.html");#die(print_r($home));

  if ($home["status"] == 403) {
    print m . "cloudflare!" . n;
    unlink(cookie_only);
    goto DATA;
  } elseif ($home["logout"]) {
    print m . "cookie expired!" . n;
    unlink(cookie_only);
    goto DATA;
  }

  if ($home["ptc"] || $home["shortlinks"] || $home["faucet"]) {
    print "ok";
    r();
  } else {
    goto home;
  }

$update = $home["balance"][0];
c().asci(sc).ket("username", $home["username"]);
ket("balance", $home["balance"][0], "value", $home["balance"][1]);
ket("claim today", $home["info"][0], "total claim", $home["info"][1]);
line();
print n;
tolol:

ket(1, "all star", 2, "shortlinks", 3, "faucet", 4, "ptc");
$p = preg_replace("/[^0-9]/","",trim(tx("number")));
if($p == 1){
  if ($home["ptc"][1] >= 1) {
    goto ptc;
  } elseif ($home["shortlinks"][1] >= 1) {
    goto shortlinks;
  }
} elseif($p == 2){
  goto shortlinks;
} elseif($p == 3){
  goto faucet;
} elseif($p == 4){
  goto ptc;
} else {
  goto tolol;
}

ptc:
$ptc = $home["ptc"][0];

if (!$ptc) {
    $ptc = $r["ptc"][0];
}

while (true) {
    $r = base_run(host . $ptc);

    if ($r["status"] == 403) {
        print m . "cloudflare!" . n;
        unlink(cookie_only);
        goto DATA;
    } elseif ($r["logout"]) {
        print m . "cookie expired!" . n;
        unlink(cookie_only);
        goto DATA;
    }

    if ($update == $r["balance"][0]) {
        # update jadi kontol babi ngemtot
    } else {
        ket("balance", $r["balance"][0], "value", $r["balance"][1]);
        line();
    }

    if (!$r["id"]) {
        lah(1, "ptc");
        L(5);
        goto shortlinks;
    }
    for ($i = 0; $i < 11; $i++) {
      $r1 = base_run(host . $r["surf_id"]);
      $icon_answer = captcha_bitmoon();
      if ($icon_answer) {
        break;
      }
    }
    L($r1["timer"]);
    


        $data = http_build_query([
            "a" => "proccessPTC",
            "data" => $r["id"],
            "token" => $r1["token"],
            "ic-hf-id" => true,
            "ic-hf-se" => $icon_answer,
            "ic-hf-hp" => ""
        ]);

        $js = base_run(host . "system/ajax.php", $data)["json"];

        if ($js->status == 200) {
            ket("message", explode("received ", $js->message)[1]);
            line();
        }
    
}



shortlinks:
$links = $home["shortlinks"][0];

if (!$links) {
  $links = $r["shortlinks"][0];
}

while (true) {
  $r = base_run(host . $links);
  
  if ($r["status"] == 403) {
    print m . "cloudflare!" . n;
    unlink(cookie_only);
    goto DATA;
  } elseif ($r["logout"]) {
    print m . "cookie expired!" . n;
    unlink(cookie_only);
    goto DATA;
  }

  $update = $r["balance"][0];
  $bypas = visit_short($r);

  if ($bypas == "refresh") {
    continue;
  } elseif (!$bypas) {
    $delay = $r["delay"];

    if (!$delay) {
      continue;
    }

    lah(1, "shortlinks");
    L(5);

    if ($r["ptc"][1] >= 1) {
      goto ptc;
    }
    $waktu_awal = time() + min($delay);
    goto faucet;
  }

  $r1 = base_run($bypas);
  $update = $r1["balance"][0];

  if ($r1["notif"]) {
    $reward = explode("!", $r1["notif"]);
    print h . $reward[0];
    r();
    ket("reward", explode("received ", $reward[1])[1]);
    ket("balance", $r1["balance"][0], "value", $r1["balance"][1]) . line();
  }
}


faucet:

while (true) {
    $r = base_run(host);

    if ($r["status"] == 403) {
        print m . "cloudflare!" . n;
        unlink(cookie_only);
        goto DATA;
    } elseif ($r["logout"]) {
        print m . "cookie expired!" . n;
        unlink(cookie_only);
        goto DATA;
    }

    if (explode(" ", $r["info"][0])[0] >= rand(40, 60)) {
        print m . "claim limit has reached limit" . n;
        line();
        tmr(2, $waktu_awal - time());
        goto shortlinks;
    }

    if ($r["locked"]) {
        print m . $r["locked"] . n;
        line();
        tmr(2, min($delay));
        unset($delay);
        goto ptc;
    }

    if ($r["timer"]) {
        if ($update == $r["balance"][0]) {
            /*update jadi kontol babi ngemtot*/
        } else {
            ket("balance", $r["balance"][0], "value", $r["balance"][1]);
            ket("claim today", $r["info"][0], "total claim", $r["info"][1]);
            line();
        }
        countdown($r["countdown"]);
        continue;
    }

    $icon_answer = captcha_bitmoon();

    if (!$icon_answer) {
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

    $r = base_run(host . "system/ajax.php", $data, 1);

    if ($r["status"] == 200) {
        $js = $r["json"];
        ket("number", number_format($js->number, 0, ',', ','));
        ket("reward", $js->reward);
        line();
    }
}



function base_run($url, $data = 0, $xml = 0, $boundary = 0)
{
    $header = head($xml, $boundary);
    $r = curl($url, $header, $data, true, false);
    unset($header);

    $json = json_decode(base64_decode($r[1]));

    if (!$json) {
        $json = $r[2];
    }
    #die(file_put_contents("response_body.html",$r[1]));
    #$r[1] = get_e("response_body.html");
    preg_match("#(Keep me logged in for 1 week)#is", $r[1], $logout);
    preg_match_all('#="(sidebarCoins|text-success|text-dark|text-danger)">(.*?)<#is', str_replace("<b>", "", $r[1]), $info);
    preg_match("#([a-z0-9]{64})#is", $r[1], $token);
    preg_match("#childWindow=open(.*?)',#is", trimed($r[1]), $surf);

    preg_match('#website_block" id="(.*?)"#is', $r[1], $id);
    if ($id[1][0]) {
        $surf_id = str_replace("'+a+'", $id[1], str_replace("(base+'/", "", $surf[1]));
    }

    preg_match_all("#([0-9]{13})#is", $r[1], $countdown);
    preg_match('#(var secs = |id="claimTime">)([0-9]{2}|[0-9]{1})(;| h| m| s)#is', $r[1], $tmr);
    preg_match_all('#align-middle">(.*?)</td><tdclass="align-middletext-center"><bclass="badgebadge-dark">(.*?)</b></td><tdclass="align-middletext-center"><bclass="badgebadge-dark">(.*?)</b></td><tdclass="(text-right|align-middletext-center)">(.*?)(role|"class=)#is', trimed($r[1]), $sl);
    preg_match('#(successmt-0"|alert-success mt-0" )role="alert">(.*?)<#is', $r[1], $n);
    preg_match("#Faucet Locked!#is", $r[1], $locked);
    preg_match("#(Unexpected error occurred)#is", $r[1], $failed);
    preg_match_all('#data-seconds-left="(.*?)"#is', $r[1], $delay);
    preg_match_all('#(" href="/([a-z-.\/=?]*)"><i class="(link|external-link|btc|eye)"></i> (.*?) <span class="badge badge-info">(.*?)</span>)#is', str_replace("view ads", "ptc", str_replace(["fa fa-", " fa-fw", "visit ", "http://", "https://", "earnbitmoon.club"], "", strtolower($r[1]))), $cek);

    # die(print_r($cek));
    $array1 = array_combine($cek[4], $cek[2]);
    $array2 = array_combine($cek[4], $cek[5]);

    print p;
    return array_merge([
        "logout" => $logout,
        "res" => $r[1],
        "json" => $json,
        "username" => $info[2][0],
        "balance" => [$info[2][1], $info[2][2]],
        "info" => [$info[2][3], $info[2][4]],
        "token" => $token[1],
        "id" => $id[1],
        "surf_id" => $surf_id,
        "countdown" => $countdown[1],
        "timer" => $tmr[2],
        "visit" => preg_replace("/[^0-9]/", "", $sl[5]),
        "left" => $sl[3],
        "name" => $sl[1],
        "notif" => $n[2],
        "delay" => $delay[1],
        "locked" => $locked[0],
        "failed" => $failed[0],
        "delay" => $delay[1],
        "status" => $r[0][1]["http_code"]
    ], array_merge_recursive($array1, $array2));
}


