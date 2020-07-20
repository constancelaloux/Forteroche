<?php

namespace blog\file;

/**
 *
 * @author constancelaloux
 */
interface UploadedFilesInterface 
{
    public function moveTo($targetPath);
    
    public function upload($file, ?string $oldFile = null);
    
    public function delete(?string $oldFile);
    
    
}
