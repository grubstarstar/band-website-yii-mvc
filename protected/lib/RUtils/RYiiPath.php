<?php

class RYiiPath
{
	private $_root;

	public function __construct($root)
	{
		$this->_root = $root;
	}

	public function create($path_alias, $filename=null)
	{
		$path = str_replace('.', DIRECTORY_SEPARATOR, $path_alias);

		$full_path =
			str_replace(DIRECTORY_SEPARATOR . 'protected', '', Yii::app()->basePath) .
			DIRECTORY_SEPARATOR .
			$this->_root .
			DIRECTORY_SEPARATOR .
			$path;

		$this->_createdir($full_path);

		if(isset($filename)) {
			$full_path .= DIRECTORY_SEPARATOR . $filename;
		}
		return $full_path;
	}

	private function _createdir($path) {
		if(!is_dir($path))
		{
			return mkdir($path);
		}
	}

	public static function changeExtension($filename, $new_ext)
	{
		$prefix = '.';
		if($new_ext{0} == '.')
		{
			$prefix = '';
		}
		return preg_replace('/\..*$/', $prefix.$new_ext, $filename);
	}
}

?>