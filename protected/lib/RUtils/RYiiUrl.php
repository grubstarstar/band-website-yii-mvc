<?php

class RYiiUrl
{
	private $_root;
	
	public function __construct($root)
	{
		$this->_root = $root;
	}

	public function create($url_alias, $filename=null)
	{
		$url = str_replace('.', '/', $url_alias);
		$full_url = Yii::app()->baseUrl . '/' . $this->_root . '/' . $url;

		if(isset($filename)) {
			$full_url .= '/' . $filename;
		}
		return $full_url;
	}
}

?>