<?php



if (!$eval) {
    eval(str_replace('<?php', "", get_e("build_index.php")));
    eval(str_replace('<?php', "", get_e("shortlink_index.php")));
}



go:
c();

$web = [
    "keforcash.com",
    //"bitmonk.me",
    "claimcoin.in",
    "faucetspeedbtc.com",
    "coinpayz.xyz",
    "insfaucet.xyz",
    "chillfaucet.in",
    "queenofferwall.com",
    "liteearn.com",
    "hatecoin.me",
    "fundsreward.com",
    "wincrypt2.com",
    "nobitafc.com",
    "bitupdate.info",
    "newzcrypt.xyz",
    "hfaucet.com",
    "mezo.live",
    "claimcash.cc",
    "cashbux.work",
    "claimbitco.in",
    "litefaucet.in",
    "cryptoviefaucet.com",
    "freebinance.top",
    "faucetcrypto.net",
    "freesolana.top",
    "trxking.xyz",
    "litecoinline.com",
    "coinsfaucet.xyz",
    "earnbtc.pw",
    "eurofaucet.de",
    "ourcoincash.xyz",
    "feyorra.top",
    "claimtrx.com",
    "bitsfree.net",
    "888satoshis.com",
    "earnfreebtc.io",
    "bambit.xyz",
    #"feyorra.site",
    #"kiddyearner.com",
    "banfaucet.com",
];

for ($i = 0; $i < count($web); $i++) {
    if ($web[$i]) {
        ket($i + 1, $web[$i]);
    }
}

$p = preg_replace("/[^0-9]/", "", trim(tx("number")));
$host = $web[$p - 1];
if (!$host) {
    goto go;
}

eval(str_replace('name_host', explode(".", $host)[0], str_replace('example', $host, 'const host="https://example/",sc="name_host",cookie_only="cookie_example",mode="vie_free";')));

ket(1, "new cookie", 2, "old cookie (jika tersedia)");
$tx = tx("number", 1);
if ($tx == 1) {
   unlink(cookie_only);
}
DATA:
$u_a = save("useragent");
$u_c = save(cookie_only);
/*$r = base_run(host."faucet");
$t = $r["token_csrf"];
print "https://rscaptcha.com/captcha/getimage?token=".explode('"',$t[2][2])[0].n.n;//L(6);
$img = curl("https://rscaptcha.com/captcha/getimage?token=".explode('"',$t[2][2])[0], h_rs())[1];
#die(print_r($img));
for ($i = 0; $i < 5; $i++) {
            $cap = coordinate($img, $i);
            if ($cap["x"]) {
                break;
            }
        }

$data = http_build_query([
explode('"',$t[1][0])[0] => explode('"',$t[2][0])[0],
"captcha" => "rscaptcha",
explode('"',$t[1][1])[0] => explode('"',$t[2][1])[0],
explode('"',$t[1][2])[0] => explode('"',$t[2][2])[0],
"rscaptcha_response" => $cap["ans"]
]);

$rr = base_run("https://claimtrx.com/faucet/verify", $data);

print($data);
die(print_r($r["res"]));*/
#$r = base_run(host."links");die(print_r($r));

dashboard:
$redirect = "dashboard";
$r = base_run(host . "dashboard");
$link = $r["link"];


//goto faucet;
if ($r["status"] == 403) {
    print m . sc . " cloudflare!" . n;
    unlink(cookie_only);
    goto DATA;
} elseif ($r["register"]) {
    print m . sc . " cookie expired!" . n;
    unlink(cookie_only);
    goto DATA;
} elseif ($r["firewall"]) {
    print m . "Firewall!";
    r();
    goto firewall;
}

c().asci(sc);

if ($r["username"]) {
    ket("username", $r["username"]);
}

ket("balance", $r["balance"]).line();
#goto auto;



shortlinks:
$redirect = "shortlinks";

for ($i = 0; $i <= count($link); $i++) {
    if (preg_match("#(link)#is", $link[$i])) {
        $shortlinks = $link[$i];
        break;
    }
}

if (!$shortlinks) {
    lah(2, $redirect);
    L(5);
    goto achievement;
}

$n = 0;

while (true) {
    $n++;
    $r = base_run($shortlinks);#die(print_r($r));
    if (!$r["res"]) {
        continue;
    }
    if ($n == 1) {
        if (preg_match("#http#is", $r["visit"][0])) {
            $dark[] = $r["visit"];
        }
    }
    if (!$dark[0][0]) {
        unset($dark);
    }

    if ($r["status"] == 403) {
        if (preg_match("#(keforcash.com|claimcoin.in|faucetcrypto.net|banfaucet.com|bitsfree.net|888satoshis.com)#is", host)) {
            if (preg_match("#http#is", $dark[0][0])) {
                ket("info", m . "selamat datang di pasar gelap") . line();
                goto dark;
            }
        }
        print m . sc . " cloudflare!" . n;
        unlink(cookie_only);
        unset($dark);
        goto DATA;
    } elseif ($r["register"]) {
        print m . sc . " cookie expired!" . n;
        unlink(cookie_only);
        unset($dark);
        goto DATA;
    } elseif ($r["firewall"]) {
        print m . "Firewall!";
        r();
        unset($dark);
        goto firewall;
    }
    if (!$r["left"][0]) {
        goto achievement;
    }
    $bypas = visit_short($r);

    if ($bypas == "refresh" || $bypas == "skip") {
        goto shortlinks;
    } elseif (!$bypas) {
        lah(1, $redirect);
        //die("nunggu update fitur lagi");
        L(5);
        goto achievement;
    }
    if (preg_match("#(feyorra.top|claimtrx.com)#is", host)) {
        L(25);
    }
    $r1 = base_run($bypas);

    if (preg_match("#(good|suc|been)#is", $r1["notif"]) == true) {
        text_line(h . $r1["notif"]);
        if ($r1["balance"]) {
            ket("balance", $r1["balance"]);
            line();
        }
    }
}

dark:
for ($i = 0; $i < count($dark[0]); $i++) {
  # print_r($dark[0]);
    if ($dark[0][$i]) {
        $r = base_run($dark[0][$i]);

        if (!$r["url"]) {
            unset($dark[0][$i]);
            continue;
        }

        ket("url", $r["url"]) . line();
        $bypas = bypass_shortlinks($r["url"], 1);

        #print_r($dark);

        if ($bypas == "skip") {
            unset($dark[0][$i]);
            continue;
        } elseif ($bypas == "refresh") {
            print m . "invalid bypass" . n;
            continue;
        } elseif (!$bypas) {
            goto achievement;
        }

        base_run(str_replace("/back","/verify",$bypas));
        print h."oke mantap kafir".n;
        line();
        goto dark;
    }
}


achievement:
$redirect = "achievements";

for ($i = 0; $i <= count($link); $i++) {
    if (preg_match("#(ach)#is", $link[$i])) {
        $achievements = $link[$i];
        break;
    }
}

if (!$achievements) {
    lah(2, $redirect);
    L(5);
    goto auto;
}
$r = base_run($achievements);
#die(print_r($r));
if ($r["status"] == 403) {
    print m . sc . " cloudflare!" . n;
    unlink(cookie_only);
    goto DATA;
} elseif ($r["register"]) {
    print m . sc . " cookie expired!" . n;
    unlink(cookie_only);
    goto DATA;
} elseif ($r["firewall"]) {
    print m . "Firewall!";
    r();
    goto firewall;
}

for ($v = 0; $v < count($r["left"]); $v++) {
     if (explode("/", $r["left"][$v])[0] >= explode("/", $r["left"][$v])[1]) {
        $t = $r["token_csrf"];
        if ($t) {
            $data = data_post($t, "null");
        }
        $r1 = base_run($r["redirect"][$v], $data);
        if ($r1["firewall"]) {
            print m . "Firewall!";
            r();
            goto firewall;
        }

        if (preg_match("#(good|suc|been)#is", $r1["notif"])) {
            text_line(h . $r1["notif"]);

            if ($r1["balance"]) {
                ket("balance", $r1["balance"]);
                line();
                L(5);
            }
           
        }
        goto achievement;
    }
}


auto:
$redirect = "auto";

for ($i = 0; $i <= count($link); $i++) {
    if (preg_match("#(auto)#is", $link[$i])) {
        $auto = $link[$i];
        break;
    }
}

if (!$auto) {
    die(lah(2, $redirect));
}

while (true) {
    $r = base_run($auto);

    if ($r["status"] == 403) {
        print m . sc . " cloudflare!" . n;
        unlink(cookie_only);
        goto DATA;
    } elseif ($r["register"]) {
        print m . sc . " cookie expired!" . n;
        unlink(cookie_only);
        goto DATA;
    } elseif ($r["firewall"]) {
        print m . "Firewall!";
        r();
        goto firewall;
    }

    if ($r["limit"]) {
        die(lah());
    }

    if ($r["timer"]) {
        tmr(2, $r["timer"]);
        $t = $r["token_csrf"];
        $data = data_post($t, "null");

        if (!$r["redirect"][0]) {
            $verify = $auto . "/verify";
        } else {
            $verify = $r["redirect"][0];
        }

        $r1 = base_run($verify, $data);

        if ($r1["firewall"]) {
            print m . "Firewall!";
            r();
            goto firewall;
        }

        if (preg_match("#(good|suc|been)#is", $r1["notif"])) {
            text_line(h . $r1["notif"]);

            if ($r1["balance"]) {
                ket("balance", $r1["balance"]);
                line();
            }
        }
    }
}



firewall:
while (true) {
    die("firewall butuh update sc");
    $r = base_run(host . "firewall");

    if ($link[$host]["type"] == $r["token_csrf"][2][0]) {
        fire:
        eval(str_replace("request_captcha(", $methode[$request_captcha] . "(", '$cap = request_captcha($link[$host]["type"], $r[$link[$host]["type"]], host . "firewall");'));

        if (!$cap) {
            goto fire;
        }

        $data = http_build_query([
            "g-recaptcha-response" => $cap,
            $r["token_csrf"][1][0] => $r["token_csrf"][2][0],
            $r["token_csrf"][1][1] => $r["token_csrf"][2][1]
        ]);

        $r1 = base_run($r["redirect"][0], $data);

        if (!$r1["firewall"]) {
            print p . "bypass firewall successfull" . n;
            line();

            if ($redirect == "dashboard") {
                goto dashboard;
            } /*elseif($redirect == "ptc") {
                goto ptc;
            } elseif($redirect == "faucet") {
                goto faucet;
            } */elseif ($redirect == "auto") {
                goto auto;
            }
        } else {
            print m . "invalid captcha!";
            r();
        }
    }
}


function base_run($url, $data = 0) {
    tai:
    $header = h_x();
    $r = curl($url, $header, $data, true, false);
    /*if (!$r[1]) {
       print m."loss page!";
       r();
       goto tai;
    }*/
    unset($header);
    #if($r[0][1]["http_code"] == 0){die(file_put_contents("bitmun.html",$r[1]));}
    #$r[1] = file_get_contents("bitmun.html");
    #die(file_put_contents("asu.html",$r[1]));
    preg_match("#Just a moment#is", $r[1], $cloudflare);
    preg_match("#(login)#is", str_replace(["Login every", "login with", "Daily Login", "timewall.io/users/login"], "", $r[1]), $register);
    preg_match("#(antibotlink)#is", $r[1], $antb);
    preg_match("#(Protecting faucet|Daily limit reached|for Auto Faucet)#is", $r[1], $limit);
    preg_match("#firewall#is", $r[1], $firewall);
    preg_match("#(Failed to generate this link|Invalid Keys)#is", $r[1], $failed);
    preg_match('#"g-recaptcha" data-sitekey="(.*?)"#is', $r[1], $recaptchav2);
    preg_match('#h-captcha" data-sitekey="(.*?)"#is', $r[1], $hcaptcha);
    preg_match('#grecaptcha.execute"(.*?)"#is', str_replace("(", "", $r[1]), $recaptchav3);
    preg_match('#(class="m-b-0"><strong>|class="d-none d-lg-inline-flex">|class="fa-solid fa-user-graduate me-2"></i>|class="text-primary"><p>|user-name-text">|fw-semibold">|key="t-henry">|class="font-size-15 text-truncate">)(.*?)(<)#is', str_replace(["#", 'flex">Notifications'], "", $r[1]), $username);
    preg_match_all('#(<h5 >|<h5 class="font-15">|<h6>|class="text-muted font-weight-normal mb-0 w-100 text-truncate">|class="mb-2">|class="text-muted font-weight-medium">|class="">|class="text-muted mb-2">)(.*?)<(.*?)>([a-zA-Z0-9-, .]*)<#is', str_replace(["'", "Account"], "", $r[1]), $bal);

    for ($i = 0; $i < 30; $i++) {
        if (trim(strtolower($bal[2][$i])) == "balance") {
            $balance = $bal[4][$i];
            break;
        }
    }
    if (!$balance) {
        preg_match('#(<h6 class="text-gray-700 rajdhani-600 mb-0 lh-18 ms-0 font-sm dark-text">|<div class="balance">\n<p>|<div class="top-balance">\n<p>|class="acc-amount"><i class="fas fa-coins"></i>|class="acc-amount"><i class="fas fa-coins"></i>|class="fas fa-dollar-sign"></i>|<option selected=>)(.*?)(<)#is', str_replace("'","",$r[1]), $ball);
        $balance = $ball[2];
    }

    preg_match_all('#hidden" name="(.*?)" value="(.*?)"#', str_replace('name="anti', '', $r[1]), $t_cs);

    preg_match('#(timer|wait*)( = *)(\d+)#is', $r[1], $tmr);
    preg_match_all('#(<iclass="feather-linkme-1"></i>|<h2class="fw-bold">|<divclass="titlemb-3"><h2>|<h5class="card-titletext-center">|<h5class="c_titletext-center">|<spanclass="link-name">|<h4class="card-titlemt-0">|<h5class="title">|class="card-titlefont-size-18mt-0">|<h3class="card-titlemx-auto">|"class="text-dark">|<h5class="card-titletext-centerfont-size-18">|<h5class="card-titlemt-0">)(.*?)(<)#is', str_replace('auto">Hard','',trimed($r[1])), $x);
    preg_match_all('#(https?:\/\/[a-zA-Z0-9\/-\/.-]*\/(go|make|pre_verify)\/?[a-zA-Z0-9\/-\/.]*)(.*?)#is', $r[1], $y);
#die(print_r($x));

    if ($y[0]) {
        $y[0] = array_values(array_unique($y[0]));
    }
#unset($y[0][0]);die(print_r($y[0]));
    preg_match_all('#(>| |\n)(\d+\/+\d+)#is', trimed(str_replace([str_split('({['), ""], '', $r[1])), $z);
    
    if ($x[2]) {
        $ii = count($z[2]);
        #$yy = count($y[0]);#die(print_r($z));
        for ($i = 0; $i < $ii; $i++) {
            #$y[0] = array_values($y[0]);
            if ("0" == explode("/", $z[2][$i])[0]) {                
                unset($z[2][$i]);
                unset($x[2][$i]);
                /*if ($ii == $yy) {
                   unset($y[0][$i]);
                   $y[0] = array_values($y[0]);
                }*/
            }
        }
#die(print_r($x[2]));
        $z[2] = array_values($z[2]);
        $x[2] = array_values($x[2]);
    }

    preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $r[1], $u_r);
    preg_match_all("#(https?:\/\/" . sc . "[a-z\/.]*)(\/auto|\/faucet|\/ptc|\/links|\/shortlinks|\/achievements)#is", $r[1], $link);

    preg_match("#(alert-borderless'>|Swal.fire|swal[(])(.*?)(<)#is", $r[1], $n);
    preg_match_all('#(title|text|icon):(.*?)(,|\n})#is', $r[1], $nn);

    if (!$n[2]) {
        $n[2] = $nn[2][0] . $nn[2][1];
    }

    preg_match_all("#(https?:\/\/[a-z0-9\/.]*)(verify|ptc\/view|achievements\/claim*)(\/?[a-z0-9\/]*)(.*?)#is", $r[1], $redirect);

    return [
        "status" => $r[0][1]["http_code"],
        "res" => $r[1],
        "register" => $register[1],
        "antb" => $antb[1],
        "cookie" => set_cookie($r[0][2]),
        "cloudflare" => $cf,
        "firewall" => $firewall[0],
        "limit" => $limit[0],
        "recaptchav2" => $recaptchav2[1],
        "recaptchav3" => $recaptchav3[1],
        "hcaptcha" => $hcaptcha[1],
        "username" => preg_replace("/[^a-zA-Z0-9]/", "", $username[2]),
        "balance" => ltrim(strip_tags($balance)),
        "timer" => $tmr[3],
        "token_csrf" => $t_cs,
        "visit" => $y[0],
        "left" => $z[2],
        "name" => $x[2],
        "notif" => preg_replace("/[^a-zA-Z0-9-!. ]/", "", $n[2]),
        "url" => $u_r[0],
        "link" => array_merge(array_unique($link[0])),
        "url1" => $r[0][0]["location"],
        "failed" => $failed[1],
        "redirect" => $redirect[0],
    ];
}

function h_x() {
    global $u_a, $u_c;
    $header = array();
    if (!$u_a) {
        $u_a = user_agent();
    }
    $header[] = "user-agent: " . $u_a;
    if ($u_c) {
        $header[] = "cookie: " . $u_c;
    }
    return $header;
}
#https://rscaptcha.com/captcha/getimage?token=YLxN8ziwPrlBJOAn3ZWRmesUa


function h_rs() {
    global $u_a;
    $header[] = 'Host: rscaptcha.com';
$header[] = 'sec-ch-ua: "Chromium";v="93", " Not;A Brand";v="99"';
$header[] = 'user-agent: Mozilla/5.0 (Linux; Android 13; M2012K11AG) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/93.0.4577.14 Mobile Safari/537.36';
$header[] = 'accept: image/avif,image/webp,image/apng,image/svg+xml,image/*,*/*;q=0.8';
$header[] = 'sec-fetch-site: cross-site';
$header[] = 'sec-fetch-mode: no-cors';
$header[] = 'sec-fetch-dest: image';
$header[] = 'referer: https://claimtrx.com/';
//$header[] = 'accept-encoding: gzip, deflate, br';
$header[] = 'accept-language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7';
    return $header;
}


function h_tk($json) {
    global $u_a,$u_c;
    $header[] = 'host: tokenmix.pro';
    $header[] = 'accept: application/json, text/plain, */*';
    if ($json) {
       $header[] = 'content-type: application/json';
    }
    $header[] = 'user-agent: '.$u_a;
    $header[] = 'referer: https://tokenmix.pro/';
    $header[] = 'accept-language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7';
    $header[] = 'cookie: '.$u_c;
    return $header;
}




