<?php


if (!$eval) {
    eval(str_replace('<?php', "", get_e("build_index.php")));
    eval(str_replace('<?php', "", get_e("shortlink_index.php")));
}

go:
c();

$web = [
    "tokenmix.pro",
    "paybits.xyz"
];

for ($i = 0; $i < count($web); $i++) {
    if ($web[$i]) {
        ket($i + 1, $web[$i]);
    }
}

$p = tx("number", 1);
$host = $web[$p - 1];
if (!$host) {
    goto go;
}
#$r = json_decode(file_get_contents("patak.html"));
eval(str_replace('name_host', explode(".", $host)[0], str_replace('example', $host, 'const host="https://example/",sc="name_host",cookie_only="cookie_example";')));

DATA:
$u_a = save("useragent");
$u_c = save(cookie_only);


$r = base_run(host . "infos/dashboard_info",1);

c() . asci(sc).ket("email", $r["email"]);
ket("balance", $r["coins"], "points", $r["activity_points"]);
line();
print n;


while (true) {
    $data = json_encode(["page" => "sl"]);
    $r = base_run(host . "infos/auth_page_info", $data, 1);
    
    if ($r["status"] == 403) {
        print m . sc . " cloudflare!" . n;
        unlink(cookie_only);
        goto DATA;
    } elseif ($r["login"]) {
        print m . sc . " cookie expired!" . n;
        unlink(cookie_only);
        goto DATA;
    }

    $bypass = bypass_shortlinks_tokenmix($r["json"]);

    if ($bypass == "refresh") {
        continue;
    } elseif ($bypass["end"] == 1) {
        $countdown = countdown_array($bypass["reset"]);
        tmr(2,  $countdown - time());
        continue;
    }

    $r1 = base_run($bypass["link"]);

    if ($r1["notif"]) {
        print h . $r1["notif"];
        r();
        $r3 = base_run(host . "infos/dashboard_info", 1);
        
        if ($r3["status"] == 403) {
            print m . sc . " cloudflare!" . n;
            unlink(cookie_only);
            goto DATA;
        } elseif ($r3["login"]) {
            print m . sc . " cookie expired!" . n;
            unlink(cookie_only);
            goto DATA;
        }
        ket("reward", $bypass["reward"]);
        ket("balance", $r3["coins"], "points", $r3["activity_points"]);
        line();
    }
}


function base_run($url, $data = 0, $json = 0) {
    $header = h_tk($json);
    $r = curl($url, $header, $data, true, false);
    unset($header);
    $js = $r[2]->user;
    #$r[1] = file_get_contents("bitmun.html");
    #die(file_put_contents("asu.html",$r[1]));
    preg_match("#(please login again)#is", $r[1], $login);
    if (preg_match("#succes#is", $r[0][0]["location"])) {
       $notif = "successfully";
    }

    return [
        "status" => $r[0][1]["http_code"],
        "res" => $r[1],
        "json" => $r[2],
        "email" => $js->email,
        "coins" => $js->coins,
        "login" => $login,
        "activity_points" => $js->activity_points,
        "notif" => $notif
    ];
}



function h_tk($json = 0) {
    global $u_a,$u_c;
    $header[] = 'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9';
    if ($json) {
       $header[] = 'content-type: application/json';
    }
    $header[] = 'user-agent: '.$u_a;
    $header[] = 'referer: '.host;
    $header[] = 'cookie: '.$u_c;
    return $header;
}


function bypass_shortlinks_tokenmix($r) {
    $file_name = "control";
    $control = file($file_name);
    if (!$control[0]) {
        $control = ["tolol"];
    }
    $config = config();

    $sls = $r->sls;
    if (!$sls[0]) {
        return "refresh";
    }

    for ($i = 0; $i < count($sls); $i++) {
        $views = $sls[$i]->views24Hours;
        $_id = $sls[$i]->_id;
        $name = remove_emoji($sls[$i]->name);
        $reward = $sls[$i]->reward;
        $completed = $sls[$i]->completed;
        $reset[] = $completed->reset_in;

        for ($s = 0; $s < count($control); $s++) {
          if (trimed(strtolower($name)) == trimed(strtolower($control[$s])) || $completed->times >= $views) {
              goto next;
          }
        }
        
        for ($z = 0; $z < count($config); $z++) {
          if (trimed(strtolower($name)) == trimed(strtolower($config[$z]))) {
             goto upload;
          }
        }

        next:
    }
    return [
        "end" => 1,
        "reset" => $reset
    ];
    upload:
    $data = json_encode(["slId" => $_id, "vote" => null, "type" => null]);
    $js = base_run(host . "user/generateSl", $data, 1)["json"];

    if ($js->success == true) {
        ket_line("", $name, "left", $views - $completed->times."/".$views);
        ket("", k . $js->shortenedUrl).line();

        for ($h = 0; $h < 3; $h++) {
            $bypass_shortlinks = bypass_shortlinks($js->shortenedUrl);

            if (preg_match("#(http)#is", $bypass_shortlinks)) {
                return [
                    "link" => str_replace("http:", "https:", $bypass_shortlinks),
                    "reward" => $reward,
                    "reset" => $reset
                ];
            }
        }
    } else {
        return "refresh";
    }
}

function countdown_array($array) {
    $count = array_count_values($array);
    $countdown = [];

    foreach ($array as $item) {
        foreach ($count as $value) {
            if ($count[$item] == 1) {
                $countdown[] = $item;
                break;
            }
        }
        continue;
    }

    return round(min($countdown) / 1000);
}


