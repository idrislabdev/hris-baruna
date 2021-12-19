<?php

function mencrypt($input,$key="hartatahtawanita"){
$key = substr(md5($key),0,24);
$td = mcrypt_module_open('tripledes', '', 'ecb', '');
$iv = mcrypt_create_iv(mcrypt_enc_get_iv_size ($td), MCRYPT_RAND);
mcrypt_generic_init($td, $key, $iv);
$encrypted_data = mcrypt_generic($td, $input);
mcrypt_generic_deinit($td);
mcrypt_module_close($td);
return trim(chop(url_base64_encode($encrypted_data)));
}
 
function mdecrypt($input,$key="hartatahtawanita"){

if($input == "") return "";

$input = trim(chop(url_base64_decode($input)));
$td = mcrypt_module_open('tripledes', '', 'ecb', '');
$key = substr(md5($key),0,24);
$iv = mcrypt_create_iv (mcrypt_enc_get_iv_size ($td), MCRYPT_RAND);
mcrypt_generic_init ($td, $key, $iv);
$decrypted_data = mdecrypt_generic ($td, $input);
mcrypt_generic_deinit ($td);
mcrypt_module_close ($td);
return trim(chop($decrypted_data));
}
 
function url_base64_encode($str){
return strtr(base64_encode($str),
array(
'+' => '999999999x99',
'=' => '888888888x88',
'/' => '777777777x77'
)
);
}
 
function url_base64_decode($str){
return base64_decode(strtr($str,
array(
'999999999x99' => '+',
'888888888x88' => '=',
'777777777x77' => '/'
)
));
}
?>