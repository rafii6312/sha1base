<?php

class sha1base_hive extends sha1base
{
	public $repoList = array();
	public $repoListDesc = array();
	
	public function __construct()
	{
		
	}
	
	public function addRepo($link)
	{
		
		if(is_array($link))
		{
			array_push($this->repoList, $link[0]);
			array_push($this->repoListDesc, $link[1]);
		} else {
			array_push($this->repoList, $link);
			array_push($this->repoListDesc, '');
		}
	}
	
	
	public function removeRepo($link)
	{
		$i = 0;
		foreach($this->repoList as $repo)
		{
			if($repo == $link)
			{
				unset($this->repoList[$i]);
				unset($this->repoListDesc[$i]);
			}
			$i++;
		}
	}
}

?> 