<?php
class helper{
	public static function downloadAvatar($fileSource, $fileName='')
	{
		$fileSystem = new Filesystem();
		$storagePath = SITE_PATH.DS.'storage';
		$year = date('Y');
		$month = date('m');
		$day = date('d');
		$folderPathDest = $storagePath.DS.$year.'_'.$month.DS.$day.DS.'source';
		FileHelper::_makeFolder($folderPathDest);
		$ext = explode('.', $fileSource);
		$fileDest = $folderPathDest.DS.$fileName.'.'.$ext[count($ext)-1];
		$download = FileHelper::_downloadFileCurl($fileSource, $fileDest);
		return $year.'_'.$month.'/'.$day.'/source/'.$fileName.'.'.$ext[count($ext)-1];
	}
	public static function makeFriendlyUrl($string, $allowUnder = false, $sep='-')
	{
		static $charMap = array(
				"à"=>"a","ả"=>"a","ã"=>"a","á"=>"a","ạ"=>"a","ă"=>"a","ằ"=>"a","ẳ"=>"a","ẵ"=>"a","ắ"=>"a","ặ"=>"a","â"=>"a","ầ"=>"a","ẩ"=>"a","ẫ"=>"a","ấ"=>"a","ậ"=>"a",
				"đ"=>"d",
				"è"=>"e","ẻ"=>"e","ẽ"=>"e","é"=>"e","ẹ"=>"e","ê"=>"e","ề"=>"e","ể"=>"e","ễ"=>"e","ế"=>"e","ệ"=>"e",
				"ì"=>'i',"ỉ"=>'i',"ĩ"=>'i',"í"=>'i',"ị"=>'i',
				"ò"=>'o',"ỏ"=>'o',"õ"=>"o","ó"=>"o","ọ"=>"o","ô"=>"o","ồ"=>"o","ổ"=>"o","ỗ"=>"o","ố"=>"o","ộ"=>"o","ơ"=>"o","ờ"=>"o","ở"=>"o","ỡ"=>"o","ớ"=>"o","ợ"=>"o",
				"ù"=>"u","ủ"=>"u","ũ"=>"u","ú"=>"u","ụ"=>"u","ư"=>"u","ừ"=>"u","ử"=>"u","ữ"=>"u","ứ"=>"u","ự"=>"u",
				"ỳ"=>"y","ỷ"=>"y","ỹ"=>"y","ý"=>"y","ỵ"=>"y",
				"À"=>"A","Ả"=>"A","Ã"=>"A","Á"=>"A","Ạ"=>"A","Ă"=>"A","Ằ"=>"A","Ẳ"=>"A","Ẵ"=>"A","Ắ"=>"A","Ặ"=>"A","Â"=>"A","Ầ"=>"A","Ẩ"=>"A","Ẫ"=>"A","Ấ"=>"A","Ậ"=>"A",
				"Đ"=>"D",
				"È"=>"E","Ẻ"=>"E","Ẽ"=>"E","É"=>"E","Ẹ"=>"E","Ê"=>"E","Ề"=>"E","Ể"=>"E","Ễ"=>"E","Ế"=>"E","Ệ"=>"E",
				"Ì"=>"I","Ỉ"=>"I","Ĩ"=>"I","Í"=>"I","Ị"=>"I",
				"Ò"=>"O","Ỏ"=>"O","Õ"=>"O","Ó"=>"O","Ọ"=>"O","Ô"=>"O","Ồ"=>"O","Ổ"=>"O","Ỗ"=>"O","Ố"=>"O","Ộ"=>"O","Ơ"=>"O","Ờ"=>"O","Ở"=>"O","Ỡ"=>"O","Ớ"=>"O","Ợ"=>"O",
				"Ù"=>"U","Ủ"=>"U","Ũ"=>"U","Ú"=>"U","Ụ"=>"U","Ư"=>"U","Ừ"=>"U","Ử"=>"U","Ữ"=>"U","Ứ"=>"U","Ự"=>"U",
				"Ỳ"=>"Y","Ỷ"=>"Y","Ỹ"=>"Y","Ý"=>"Y","Ỵ"=>"Y",
		);
	
		$string = strtr($string, $charMap);
	
		$string = self::CleanUpSpecialChars($string, $allowUnder, $sep);
		return strtolower($string);
	}
	
	public static function CleanUpSpecialChars($string, $allowUnder = false, $sep='-'){
		//$string = preg_replace( array("`[^a-zA-Z0-9\$_+*'()]`i","`[-]+`") , "-", $string);
		$regExpression = "`\W`i";
		if($allowUnder) $regExpression = "`[^a-zA-Z0-9-]`i";
	
		$string = preg_replace( array($regExpression, "`[-]+`",) , "$sep", $string);
		$string = str_replace("$sep$sep", "$sep", $string);
		$string = str_replace("'", "", $string);
		return trim($string, $sep);
	}
}