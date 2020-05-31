<?php

namespace blog\file;

use blog\file\Upload;
/**
 * Description of PostUpload
 *
 * @author constancelaloux
 */
class PostUpload extends Upload
{
    protected $path = __DIR__.'/../../../public/images';
    
    protected $formats = 
            [
                'thumb' => [320, 180]
            ];
}
