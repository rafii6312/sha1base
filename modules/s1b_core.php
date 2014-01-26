<?php
error_reporting(E_ALL);

class sha1base
{
	public $extensions = array();
	public $extensionsNames = array();
	protected $_data = array('version' => '0.1', 'build' => '2');

    public function __get($name) {
        if (isset($this->_data[$name])) {
            return $this->_data[$name];
        }
    }

    public function __set($name, $value) {  }
    
	public function __construct() {  }
	
	public function loadModule($modFile, $constructor, $outp = false)
	{
		if(file_exists($modFile . '.php'))
		{
			try
			{
				include($modFile . '.php');
				if ($outp) echo '<b>' . $modFile . '</b> successful loaded.<br>';
				array_push($this->extensions, new $constructor());
				array_push($this->extensionsNames, $constructor);
			}
			catch (Exception $e)
			{
				echo 'Failed to load <b>' . $modFile . '</b>: ' . $e->getMessage() . '<br>';
				echo 'Error: ' . $e->getMessage() . '<br>';
				exit();
			}
		} else {
			echo 'File ' . $modFile . '.php' . ' not found!<br>';
		}
	}
	
	public function moduleLoaded($modName)
	{
		$e = false;
		foreach($this->extensionsNames as $mod)
		{
			if($mod == $modName)
			{
				$e = true;
			}
		}
		return $e;
	}
		
	public function callExtFunction($extName, $func, $attr = '')
	{ 
		$i = 0; $ret = null; 
		foreach($this->extensions as $ext) 
		{ 
			if($this->extensionsNames[$i] == $extName) 
			{ 
				$ret = $this->extensions[$i]->$func($attr); 
				break; 
			} 
				$i++; 
		}
		return $ret;
	}
	
	public function cEF($e, $f, $a = '')
	{
		return $this->callExtFunction($e, $f, $a);
	}
	
	public function getExtVar($extName, $attr)
	{ 
		$i = 0;
		$ret = null; 
		foreach($this->extensions as $ext) 
		{ 
			if($this->extensionsNames[$i] == $extName) 
			{ 
				$ret = $this->extensions[$i]->$attr; 
				break; 
			} 
				$i++; 
		}
		return $ret;
	}
	
	public function setExtVar($extName, $attr, $value, $index = false)
	{ 
		$i = 0;
		$ret = null; 
		foreach($this->extensions as $ext) 
		{ 
			if($this->extensionsNames[$i] == $extName) 
			{ 
				$this->extensions[$i]->$attr = $value;
				if($this->extensions[$i]->$attr == $value)
				{
					$ret = true;
				}
				break; 
			} 
				$i++; 
		}
		return $ret;
	}
}

?>
