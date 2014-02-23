<?php

class sha1base_encrypt extends sha1base
{
	public $encryption = MCRYPT_RIJNDAEL_256;
	public $mode = MCRYPT_MODE_CBC;
    public $pass = 'testa';
	public $salt = '?anything!';
	
	public function __construct()
	{
	
	}
	
	public function encrypt($plaintext)
    {
        $td = mcrypt_module_open($this->encryption, '', $this->mode, '');
        $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        mcrypt_generic_init($td, (md5($this->pass)), $iv);
        $crypttext = mcrypt_generic($td, $plaintext);
        mcrypt_generic_deinit($td);
        return base64_encode($iv.$crypttext);
    }

    public function decrypt($crypttext)
    {
        $crypttext = base64_decode($crypttext);
        $plaintext = '';
        $td        = mcrypt_module_open($this->encryption, '', $this->mode, '');
        $ivsize    = mcrypt_enc_get_iv_size($td);
        $iv        = substr($crypttext, 0, $ivsize);
        $crypttext = substr($crypttext, $ivsize);
        if ($iv)
        {
            mcrypt_generic_init($td, (md5($this->pass)), $iv);
            $plaintext = mdecrypt_generic($td, $crypttext);
        }
        return trim($plaintext);
    }
	
	public function encrypt_file($file)
	{
		if(count($file) == 2)
		{
			$inp = $file[0];
			$outp = $file[1];
			if(file_exists($inp))
			{
				file_put_contents($outp, base64_decode($this->encrypt(base64_encode(file_get_contents($inp)))));
			} else {
				echo 'inp does not exist';
			}
		} else {
			echo 'wrong supply of args';
		}
	}
	
	public function decrypt_file($file)
	{
		if(count($file) == 2)
		{
			$inp = $file[0];
			$outp = $file[1];
			if(file_exists($inp))
			{
				file_put_contents($outp, base64_decode($this->decrypt(base64_encode(file_get_contents($inp)))));
			} else {
				echo 'inp does not exist';
			}
		} else {
			echo 'wrong supply of args';
		}
	}
	
	public function addFile($file)
	{
		$filesFolder = "";
		if(file_exists($file))
		{
			$hash = @sha1_file($file);
			if ($this->hashExists($hash) != true)
			{
				if(rename($file, $filesFolder . $hash))
				{
					return array(1, $hash);
				} else {
					return array(3, 'copying failed');
				}
			} else {
				unlink($file);
				return array(2, $hash);
			}
		} else {
			return array(4, 'file not found');
		}
	}
}


?>