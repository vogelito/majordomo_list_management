<?php
  function urlsafe_b64encode($string) {
    $data = base64_encode($string);
    $data = str_replace(array('+','/','='),array('-','_',''),$data);
    return $data;
  }

  function urlsafe_b64decode($string) {
    $data = str_replace(array('-','_'),array('+','/'),$string);
    $mod4 = strlen($data) % 4;
    if ($mod4) {
        $data .= substr('====', $mod4);
    }
    return base64_decode($data);
  }

  function getIV() {
    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CFB);
    return urlsafe_b64encode(mcrypt_create_iv($iv_size, MCRYPT_DEV_URANDOM));
  }

  function encode($data, $key, $iv) {
    return urlsafe_b64encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $data, MCRYPT_MODE_CFB, urlsafe_b64decode($iv)));
  }

  function decode($data, $key, $iv) {
    return mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, urlsafe_b64decode($data), MCRYPT_MODE_CFB, urlsafe_b64decode($iv));
  }

?>
