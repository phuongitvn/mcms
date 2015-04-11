<?php
class FileHelper {


	public static function _downloadFileCurl($url, $target) {
		$result = false;
		$rawdata = self::_getContentCurl($url);
		if($rawdata)
		{
			//save to file
			if(file_exists($target)){
				@unlink($target);
			}
			$fp = fopen("$target",'w');
			fwrite($fp, $rawdata);
			fclose($fp);
			$result = true;
		}else{
			$result = false;
		}
		return $result;
	}
	public static function _getContentCurl($url)
	{
		// timeout in seconds
		$timeOut = 5;
	
		$ch = curl_init ( $url );
		curl_setopt ( $ch, CURLOPT_HEADER, 0 );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt ( $ch, CURLOPT_BINARYTRANSFER, 1 );
		curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, $timeOut );
		$rawdata = curl_exec ( $ch );
		if (! curl_errno ( $ch )) {
			if ($rawdata) {
				curl_close ( $ch );
				return $rawdata;
			}
		}
		curl_close ( $ch );
		return false;
	}
	public static function _makeFolder($path, $mode = 0777)
	{
		if (is_dir($path))
		{
			return true;
		}
	
		$ret =  @mkdir($path, $mode, true);
		@chmod($path, 0777);
		return $ret;
	}
}