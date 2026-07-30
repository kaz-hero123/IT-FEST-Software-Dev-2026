<?php
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://127.0.0.1:8000/login');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);
$res = curl_exec($ch);
preg_match('/XSRF-TOKEN=(.*?);/', $res, $m1);
preg_match('/laravel_session=(.*?);/', $res, $m2);
preg_match('/name="_token" value="(.*?)"/', $res, $m3);
if(!isset($m1[1]) || !isset($m2[1]) || !isset($m3[1])) { die("Failed to parse token/cookie\n"); }
$cookie = 'XSRF-TOKEN=' . $m1[1] . '; laravel_session=' . $m2[1];
$token = $m3[1];
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(['_token' => $token, 'email' => 'a@b.com', 'password' => '123']));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Cookie: ' . $cookie]);
for ($i = 0; $i < 8; $i++) {
    curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    echo $code . "\n";
}
