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
    //protected $path = __DIR__.'/../../../public/images/upload/posts';
    protected $path = '/../../../public/images/upload/posts';
    /*protected $formats = 
            [
                'thumb' => [320, 180]
            ];*/
    protected $newwidth = 150;
}
