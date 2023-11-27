<?php


if($eval == false) {
    eval(str_replace('<?php',"",get_e("build_index.php")));
    eval(str_replace('<?php',"",get_e("shortlink_index.php")));
}

go:
c();
$web = [
    1 => "autofaucet.org",
    2 => "autoclaim.in",
    3 => "autobitco.in"
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
eval(str_replace('name_host',explode(".",$host)[0],str_replace('example',$host,'const host="https://example/",sc="name_host",cookie_only="cookie_example",mode="af";c();')));
$asu = cookie_only;DATA:
$u_a = save("useragent");
$u_c = save(cookie_only);
c();
$r = base_run(host."dashboard/claim/auto");
if($r["status"] == 403){
    print m.sc." cloudflare!".n;
    unlink(cookie_only);
    goto DATA;
} elseif($r["register"]){
    print m.sc." cookie expired!".n;
    unlink(cookie_only);
    goto DATA;
}
ket("+","script for ".explode("/",host)[2]);
ket("✓","Target Autofaucet Credits (1% bonus)");
frequency:ket("•","Choose the frequency").line();
for($s=2;$s<11;$s++){
    if($s == 2){
        ket($s-1,$s." minutes");
    } elseif($s == 5){
        ket($s-3,$s." minutes (1% bonus)");
    } elseif($s == 10){
        ket($s-7,$s." minutes (2% bonus)");
        line();}
    }
    $fq=tx("number").line();
    preg_match("([0-3]{1})",$fq,$frequency);
    if($fq == 0 or !$frequency[0]){
        goto frequency;
    }
    boost:ket("•","Payment Boost").line();
    for($i=1;$i<5;$i++){
        ket($i,$i."x boost");
    }
    line();
    $bs=tx("number").line();
    preg_match("([0-4]{1})",$bs,$boost);
    if($bs == 0 or !$boost[0]){
        goto boost;
    }
    $r = base_run(host."dashboard/shortlinks");
    if($r["status"] == 403){
        print m.sc." cloudflare!".n;
        unlink(cookie_only);
        goto DATA;
    } elseif($r["register"]){
        print m.sc." cookie expired!".n;
        unlink(cookie_only);
        goto DATA;
    }
    c().asci(sc).ket("username",$r["username"],"balance",$r["balance"]).line();
    shortlinks:
    while(true){
        $r = base_run(host."dashboard/shortlinks");
        if($r["status"] == 403){
            print m.sc." cloudflare!".n;
            unlink(cookie_only);
            goto DATA;
        } elseif($r["register"]){
            print m.sc." cookie expired!".n;
            unlink(cookie_only);
            goto DATA;
        }
        if($r["status"] == 1){
            base_run(host."verify/hshort",http_build_query(["status" => 1]));
            goto shortlinks;
        }
        $bypas = visit_short($r);
        if($bypas == "refresh"){
            goto shortlinks;
        } elseif(!$bypas){
            lah(1,"shortlinks");
            goto auto;
        }
        $r3 = base_run($bypas);
        if($r3["notif"]){
            an(h.$r3["notif"].n);
            line().ket("balance",$r3["balance"]).line();
        }
    }
    auto:
    $r1 = base_run(host."verify/cl-au",http_build_query(["currency" => "USDT","payout" => 1,"frequency" => $frequency[0],"boost" => $boost[0]]));
    $r2 = base_run(host."verify/cli-au",http_build_query(["currencies[]" => "USDT","payout" => 1,"frequency" => $frequency[0],"boost" => $boost[0]]));
    if($r2["res"]){
        print k.$r2["res"];
        r();
    }
    if($frequency[0] == 1){
      $fr = 2;
    } elseif($frequency[0] == 2){
      $fr = 5;
    } elseif($frequency[0] == 3){
      $fr = 10;
    }
    if(sc == "autofaucet"){
      $tg="8";
    } elseif(sc == "autoclaim"){
      $tg="15";
    } elseif(sc == "autobitco"){
      $tg="1";
    }
    
    while(true){
        if(diff_time($fr, $tg.":30") == 1){
          goto shortlinks;
        }
        $r3 = base_run(host."dashboard/claim/auto/start");
        if($r3["status"] == 403){
            print m.sc." cloudflare!".n;
            unlink(cookie_only);
            goto DATA;
        } elseif($r3["register"]){
            print m.sc." cookie expired!".n;
            unlink(cookie_only);
            goto DATA; 
        } elseif($r3["notif"]){
            an(h.$r3["notif"].n);
            line();
            ket("balance",$r3["balance"]).line();
        } elseif($r3["time"]){
            tmr(1,$r3["time"]);
        } else {
            print m."FCT TOKEN not found".n;
            goto shortlinks;
    }
}
    
function base_run($url,$data=0){
    $header = head();
    $r = curl($url,$header,$data,true,false);
    unset($header);
    preg_match("#(signup|register|signin)#is",$r[1],$register);
    preg_match('#<p class="username">(.*?)</p>#is',$r[1],$username);
    preg_match('#<p class="amount">(.*?)</span>#is',$r[1],$balance);
    preg_match('#shortlinks" value="(.*?)"#is',$r[1],$status);
    preg_match_all('#<p class="name">(.*?)<#is',$r[1],$name);
    preg_match_all('#" action="/(.*?)"#is',$r[1],$visit);
    preg_match_all('#id="views">(.*?)<#is',$r[1],$left);
    preg_match_all('#hidden" name="(.*?)" value="(.*?)"#is',$r[1],$t_cs);
    preg_match('#content="(.*?)"#is',$r[1],$tmr);
    preg_match('#class="(alert alert-success" style="margin: 30px;" role="alert"|fas fa-check green"></i)>(.*?)(.</p>|</div>|. <script)#is',$r[1],$n_r);
    //print_r($amn);
    //die(print_r());
    return [
        "res" => $r[1],
        "status" => $r[0][1]["http_code"],
        "register" => $register[0],
        "username" => $username[1],
        "balance" => strip_tags($balance[1]),
        "status" => $status[1],
        "visit" => $visit[1],
        "left" => $left[1],
        "name" => $name[1],
        "token" => $t_cs,
        "time" => $tmr[1],
        "notif" => str_replace(". ",n,strip_tags($n_r[2])),
        "url" => $r[0][0]["location"]
    ];
}

