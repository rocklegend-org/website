<?php
# last changes: 23.01.2006 

//clean up tmp (could be a cron job instead)
$handle = opendir ('tmp/');
$now = time();
while (false !== ($file = readdir ($handle)))
	if ($file!='.' && $file!='..') {
		if ($now - filemtime('tmp/'.$file)>86400) 
			unlink('tmp/'.$file); // 24 h
	}
closedir($handle);

include('readme.htm');
?>