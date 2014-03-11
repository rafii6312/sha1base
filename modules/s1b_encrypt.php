<?php

class sha1base_encrypt extends sha1base
{
	public $encryption = MCRYPT_RIJNDAEL_256;
	public $mode = MCRYPT_MODE_CBC;
    public $pass = 'default';
	public $salt = '';
	public $delete = true;
	public $useMD5 = false;
	public $bufferSize = 1024; //67108864
	public $bufferSizeOut = 1408; //64 mb
	
	
	public function __construct()
	{
		
	}
	
	public function setPass($p)
	{
		$this->pass = $p;
	}
	
	public function randomString($length = 10)
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
	}
	
	public function encrypt($plaintext)
    {
        $td = mcrypt_module_open($this->encryption, '', $this->mode, '');
        $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        
		if($this->useMD5)
		{
			mcrypt_generic_init($td, (md5($this->pass . $this->salt)), $iv);
		} else {
			mcrypt_generic_init($td, (($this->pass . $this->salt)), $iv);
		}
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
			if($this->useMD5)
			{
				mcrypt_generic_init($td, (md5($this->pass . $this->salt)), $iv);
			} else {
				mcrypt_generic_init($td, (($this->pass . $this->salt)), $iv);
			}
            $plaintext = @mdecrypt_generic($td, $crypttext);
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
				$fp = fopen($inp, "r");
				if(file_exists($outp)) unlink($outp);
				$chunksize = $this->bufferSize;
				while (!feof($fp))
				{
					$raw = fread($fp, $chunksize);
					$part = base64_encode($raw); 
					$epart = base64_decode($this->encrypt($part));
					
					file_put_contents($outp, $epart, FILE_APPEND | LOCK_EX);
				}
				fclose($fp);
				
				
				if($this->delete)
				{
					unlink($inp);
				}
				return true;
			} else {
				return false;
			}
		} else {
			return false;
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
				if(file_exists($outp)) unlink($outp);
				//file_put_contents($outp, base64_decode($this->decrypt(file_get_contents($inp)))); // does work but loads file in memory
				
				$chunksize = $this->bufferSizeOut;
				$fp = fopen($inp, "r");
				while (!feof($fp))
				{
					$part = base64_encode(fread($fp, $chunksize));
					$epart = base64_decode($this->decrypt($part));
					file_put_contents($outp, $epart, FILE_APPEND | LOCK_EX);
				}
				fclose($fp);
				
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}	
}


?>