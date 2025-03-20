<?php

namespace App\Traits;

use App\StorageSpaceCount;
use Session;

trait StorageSpace
{
	public function getDirectorySize($path,$total_storage_space_limit)
    {
        $totalsize = 0;
        $totalcount = 0;
        $dircount = 0;
        if ($handle = opendir ($path))
        {
            while (false !== ($file = readdir($handle)))
            {
                $nextpath = $path . '/' . $file;
                if ($file != '.' && $file != '..' && !is_link ($nextpath))
                {
                    if (is_dir ($nextpath))
                    {
                    	$dircount++;
                      	$result = $this->getDirectorySize($nextpath,$total_storage_space_limit);
                      	$totalsize += $result['size'];
                    }
                    elseif (is_file ($nextpath))
                    {
                      	$totalsize += filesize ($nextpath);
                      	$totalcount++;
                    }
                }
            }
        }
        closedir ($handle);
        $total['size'] = $totalsize;
        $total['allocated_size'] = $total_storage_space_limit;
        return $total;
    }

    public function sizeFormat($size)
    {
        if($size<1024)
        {
            return $size." bytes";
        }
        else if($size<(1024*1024))
        {
            $size=round($size/1024,1);
            return $size." KB";
        }
        else if($size<(1024*1024*1024))
        {
            $size=round($size/(1024*1024),1);
            return $size." MB";
        }
        else
        {
            $size=round($size/(1024*1024*1024),1);
            return $size." GB";
        }
    }
}