<?php
class StorageHelper{
	public static function storageSolutionEncode($objID, $isUrl = true)
	{
		$step           = 13;    //so bit de ma hoa ten thu muc tren 1 cap
		$max_bits       = PHP_INT_SIZE*8;
		$separator      = $isUrl ? "/" : DIRECTORY_SEPARATOR;
		$result         = "";
	
		// start caculate
		$level            = 0;
		while(true)
		{
			$shift   = $step*$level;
			$layerName  = $shift<=$max_bits?$objID >> $shift:0;
	
			if($layerName == 0) break;
			$result = $layerName.$separator.$result;
			$level++;
		}
	
		return $result;
	}
    public static function generalStoragePath($objId,$fileType='jpg',$storage,$isUrl=false)
    {
        $year = date('Y');
        $month = date('m');
        $day = date('d');
        $sep = $isUrl?'/':DS;
        $exPath = $year.$sep.$month.$sep.$day;
        $filePath = $storage.$sep.$exPath;
        $fileSystem = new Filesystem();
        $res = $fileSystem->mkdirs($filePath,'0755');
        return $filePath.$sep.$objId.'.'.$fileType;
    }

}