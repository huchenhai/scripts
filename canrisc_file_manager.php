<?php

//Specify Log File
$LogFile = "/root/scripts/brokerload.log";
$basepath = "/srv/candoc/commitment/";
$path = "/srv/candoc/Autofile/";
$error = "/srv/candoc/Autofile/error/";

$pattern = '/^\d+/';
//Running this job as a crontab requires the timezone be set
//$fh = fopen($LogFile, 'ab') or die("can't open file");
//Open Log File for writing
date_default_timezone_set('America/Toronto');

if(is_dir($path))
{
	$FileList = scandir($path);
	foreach (array_diff($FileList, ['.','..','error']) as $filename) {
		$rawname = $filename;
		$filename=ltrim(str_ireplace('RE','', str_ireplace ('FW','', $filename)));
		$CommitNum=(preg_match($pattern, $filename,$result)==1)?(int)$result[0]:0;
		$basename = pathinfo($rawname,PATHINFO_FILENAME);
			$oldfile = "$path$rawname";
			print_r("Filename:".$filename."\n");
		if($CommitNum!=0&&file_exists("$basepath$CommitNum/$rawname")){
			$ext = pathinfo($rawname,PATHINFO_EXTENSION);	
			$newfile = "$basepath"."$CommitNum/"."$rawname-".date('Ymd\THis\Z').".$ext";
			
				if(!rename($oldfile,$newfile))
				rename($oldfile,"$error$rawname");
			
		}
		elseif($CommitNum!=0){
			if(!rename($oldfile, "$basepath"."$CommitNum/"."$rawname"))
				rename($oldfile,"$error$rawname");
		}
		else rename($oldfile,"$error$rawname");
	

	
}

} else
        {
        $LogEntry = "File added to _Errors - " . date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']) . " - $basepath does not exist";
        }





?>