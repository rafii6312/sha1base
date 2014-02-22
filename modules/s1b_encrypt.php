<?php

class sha1base_encrypt extends sha1base
{
	public $encryption = MCRYPT_RIJNDAEL_256;
	public $mode = MCRYPT_MODE_CBC;
    public $pass = 'test';
	public $salt = '?anything!';
	
	public function __construct()
	{
	}
	
	public function encrypt($plaintext)
    {
        $td = mcrypt_module_open($this->encryption, '', $this->mode, '');
        $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        mcrypt_generic_init($td, ($this->pass . $this->salt), $iv);
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
            mcrypt_generic_init($td, ($this->pass . $this->salt), $iv);
            $plaintext = mdecrypt_generic($td, $crypttext);
        }
        return trim($plaintext);
    }
	
	public function encrypt_file($file)
	{
		if(count($file) == 2)
		{
			
		}
	}
	
	public function decrypt_file($file)
	{
		if(count($file) == 2)
		{
			
		}
	}
}


?>