<?php

class parseResource
{
	public $resourcePath;
	public $key;
	public $error;
	public $alias;
	function getResourcePath()
	{
		return $this->resourcePath;
	}
	function getKey()
	{
		return $this->key;
	}
	function getAlias()
	{
		return $this->alias;
	}
	function setResourcePath($path)
	{
		$this->resourcePath = $path;
	}
	function setAlias($alias)
	{
		$this->alias = $alias;
	}
	function setKey($key)
	{
		$this->key = $key;
	}
	function createCGZFromCGN()
	{ {
			//dd('hello');
			$filenameInput = $this->getResourcePath() . "/resource.cgn";
			//dd($filenameInput);
			$handleInput = fopen($filenameInput, "r");
			//dd($handleInput);
			$contentsInput = fread($handleInput, filesize($filenameInput));
			//dd($contentsInput);
			$filenameOutput = $this->getResourcePath() . "/resource.cgz";
			//dd($filenameOutput);
			@unlink($filenameOutput);
			$handleOutput = fopen($filenameOutput, "w");
			//dd($contentsInput);
			$dec = $this->decryptData($contentsInput, $this->key);

			fwrite($handleOutput, $dec);
			fclose($handleInput);
			fclose($handleOutput);
		}
		return true;
	}
	function readZip()
	{
		$s = ""; {
			$filenameInput = $this->getResourcePath() . "/resource.cgz";
			//dd($filenameInput);
			$zip = new ZipArchive();
			$zp = $zip->open($filenameInput);
			if ($zp === TRUE) {
				$zip->extractTo($this->resourcePath);
				$zip->close();
			} else {
				echo 'failed';
				$this->error = "Failed to unzip file";
			}
			if (strlen($this->error) === 0) {
				$xmlNameInput = $this->resourcePath . '/' . $this->getAlias() . ".xml";
				//dd($xmlNameInput);
				$xmlHandleInput = fopen($xmlNameInput, "r");
				$xmlContentsInput = fread($xmlHandleInput, filesize($xmlNameInput));
				fclose($xmlHandleInput);
				//dd($xmlHandleInput);
				unlink($xmlNameInput);
				$s = $xmlContentsInput;
				//dd($s);
				$s = $this->decryptData($s, $this->key);
				//	dd($s);
			} else {
				$this->error = "Unable to open resource";
			}
			return $s;
		}
	}

	function decryptData($data, $key)
	{
		//$data = mcrypt_decrypt ( MCRYPT_3DES, $key, $data, MCRYPT_MODE_ECB );
		$method = "des-ede";
		$data = base64_encode($data);
		$data = openssl_decrypt($data, $method, $key);
		//dd($data);
		//$data = openssl_decrypt($data,'des-ede', $key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING);

		//$block = mcrypt_get_block_size ( 'tripledes', 'ecb' );
		//$len = strlen ( $data );
		//$pad = ord ( $data [$len - 1] );
		$decr = substr($data, 0, strlen($data));
		return $decr;
	}


	function getBytes($s)
	{
		$hex_ary = array();
		$size = strlen($s);
		for ($i = 0; $i < $size; $i++)
			$hex_ary[] = chr(ord($s[$i]));
		return $hex_ary;
	}

	function getString($byteArray)
	{
		$s = "";
		foreach ($byteArray as $byte) {
			$s .= $byte;
		}
		return $s;
	}
	function StartsWith($Haystack, $Needle)
	{
		return strpos($Haystack, $Needle) === 0;
	}

	function EndsWith($Haystack, $Needle)
	{
		return strrpos($Haystack, $Needle) === strlen($Haystack) - strlen($Needle);
	}

	function xor_string($string)
	{
		$buf = '';
		$size = strlen($string);
		for ($i = 0; $i < $size; $i++)
			$buf .= chr(ord($string[$i]) ^ 255);
		return $buf;
	}
}
