<?php
class FileRemote
{
	public static function getFromUrl($source, $target)
	{
		$ret = self::_downloadFileCurl($source, $target);
		if(!$ret){
			$ret = self::_downloadFileGetContent($source, $target);
		}
		if(!$ret){
			$ret = self::_downloadFileSystemCmd($source, $target);
		}
		return $ret;
	}

	private static function _downloadFileCurl($url, $target) {
		// timeout in seconds
		$timeOut = 30;
		$result = false;

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT, $timeOut);
		$rawdata=curl_exec($ch);
		if(!curl_errno( $ch ))
		{
			if($rawdata)
			{
				//save to file
				if(file_exists($target)){
					unlink($target);
				}
				$fp = fopen($target,'w');
				fwrite($fp, $rawdata);
				fclose($fp);
				if(md5_file($url) == md5_file($target)) $result = true;
			}
		}
		curl_close ($ch);

		return $result;
	}

	private static function _downloadFileGetContent($source, $target) {
		// timeout in seconds
		$timeOut = 5;
		$result = false;

		$rawdata = file_get_contents($source);
		file_put_contents($target, $rawdata);
		if(md5_file($source) == md5_file($target)) $result = true;

		return $result;
	}

	private static function _downloadFileSystemCmd($url, $outputfile)
	{
		$cmd="wget -q -t 3 \"$url\" -O $outputfile";
		system($cmd, $retval);
		@chmod($outputfile, 0777);
		if($retval !== false){
			return true;
		}
		return $retval;
	}
}