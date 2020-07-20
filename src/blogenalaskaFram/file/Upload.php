<?php

namespace blog\file;

use blog\file\UploadedFilesInterface;

use blog\HTTPResponse;

/**
 * Description of Upload
 *
 * @author constancelaloux
 */
class Upload implements UploadedFilesInterface
{
    /**
     * The path where we want to save
     */
    protected $path;
    
    /**
     * Image format
     */
    protected $formats;
    
    /**
     * Allowed origins to upload images
     */
    //protected $accepted_origins = array("http://localhost:8888", "http://127.0.0.1:8888",  "http://www.jeanforteroche.ozoisans.com");
protected $accepted_origins = array("http://www.jeanforteroche.ozoisans.com");
    /**
     * Images upload path
     */
    protected $imageFolder = __DIR__."/../../../public/images/";
    
    protected $tmp;
    
    protected $tmpName;
    
    protected $filename;
    
    protected $HTTPResponse;
    
    public function __construct(?string $path = null)
    {
        $this->HTTPResponse = new HTTPResponse();
        /**
         * If the path is defined
         */
        if($path)
        {
            $this->path = $path;
        }
        
        if(isset($this->newwidth))
        {
            $this->newwidth;
        }
    }
    
    /**
     * Get the image name
     * @param type $file
     * @return type
     */
    private function getClientFilename(array $file)
    {
        $this->tmp = current($file);
        
        //print_r($this->tmp);
        if(is_uploaded_file($this->tmp['tmp_name']))
        {
            if(isset($_SERVER['HTTP_ORIGIN']))
            {
                //print_r($_SERVER['HTTP_ORIGIN']);
                //print_r($this->accepted_origins);
                /**
                 * Same-origin requests won't set an origin. If the origin is set, it must be valid.
                 */
                if(in_array($_SERVER['HTTP_ORIGIN'], $this->accepted_origins))
                {
                    //die("meurs");
                    header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
                }
                else
                {
                    //die('meurs denied');
                    header("HTTP/1.1 403 Origin Denied");
                    return;
                }
            }

            /**
             * Sanitize input
             */
            if(preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $this->tmp['name']))
            {
                header("HTTP/1.1 400 Invalid file name.");
                return;
            } 

            /**
             * Verify extension
             */
            if(!in_array(strtolower(pathinfo($this->tmp['name'], PATHINFO_EXTENSION)), array("gif", "jpg", "png")))
            {
                header("HTTP/1.1 400 Invalid extension.");
                return;
            }
            return $this->tmpName = $this->tmp['name'];
        }
    }
    
    /**
     * We send the file to the target file
     * @param type $targetPath
     */
    public function moveTo($targetPath)
    {
        //print_r($this->tmp['tmp_name']);
        //print_r(__DIR__.$targetPath);
        //die('meurs');
        
        //if(move_uploaded_file($this->tmp['tmp_name'], __DIR__.$targetPath))
        if(move_uploaded_file($this->tmp['tmp_name'], __DIR__.$targetPath))
        {
        /**
         * I generate the image format
         */
            $this->generateFormats(__DIR__.$targetPath);
        }
        else 
        {
            /**
             * Notify editor that the upload failed
             */
            header("HTTP/1.1 500 Server Error");
        } 
    }
    
    /**
     * Takes in parameter the file that we have uploaded
     * Upload the file to the correct folderier
     * Returns a string which will be the name of the file
     * Then in order to save this file
     */
    public function upload($file, ?string $oldFile = null)//, ?string $oldFile): string//UploadedFileInterface $file, ?string $oldFile = null): string
    {
            /**
             * We check if the old file exists
             */
            $this->delete($oldFile);

            /**
             * I get the name of the file
             */
            $this->filename = $this->getClientFilename($file);
            //print_r($this->filename);
            //die('meurs');

            /**
             * I add the image in the target path and a copy with the copy extension if the image already exists
             */
            $targetPath = $this->addCopySuffix($this->path .DIRECTORY_SEPARATOR . $this->filename);

            /**
             * Vefor to upload, i check if the folder exist
             */
            $dirname = pathinfo($targetPath, PATHINFO_DIRNAME);
            
            if(!file_exists($dirname))
            {
                //mkdir($dirname, 777, TRUE);
            }

            /**
             * I send the image with its path in the target file
             */
            $this->moveTo($targetPath);

            /**
             * We recover the name of the file + the extension (ex: test.php)
             */
            $path_parts = pathinfo($targetPath);

            $image = $path_parts['basename'];
            
            if(!empty($this->filename))
            {
                $showImage = $this->path.DIRECTORY_SEPARATOR.$image;
                //echo "<img src='$showImage' />";
                //return $showImage;
                return $path_parts['basename'];
            }
    }
    
    /**
     * Check if the file exists
     */
    private function addCopySuffix(?string $targetPath): ?string
    {
        if(file_exists($targetPath))
        {
            /**
             * I build a new path with copy at the end because the file already exists in the folder
             */
            return $this->addCopySuffix($this->getPathWithSuffix($targetPath, 'copy'));
        }   
        return $targetPath;
    }
    
    /**
     * Delete folder
     */
    public function delete(?string $oldFile): void
    {
        if($oldFile)
        {
            $oldFile = $this->path . DIRECTORY_SEPARATOR . $oldFile;
            if(file_exists($oldFile))
            {
                print_r("je passe la");
                /**
                 * Delete old folder
                 */
                unlink($oldFile);
            }
        }
    }
    
    private function getPathWithSuffix(?string $path, ?string $suffix)//: ?string
    {
        $info = pathinfo($path);
        if(isset($info['extension']))
        {
            /**
             * I buil a new path
             */
            return $info['dirname'] . 
                    DIRECTORY_SEPARATOR . 
                    $info['filename'] . 
                    '_'. $suffix.'.' .
                    $info['extension'];
        }
    }
    
    /**
     * We generate the different formats
     */
    private function generateFormats($targetPath)
    {
        /**
         * Gonna search the size of the image
         */
        $size = getimagesize($targetPath);

        $uploadImageType = $size[2];

        /**
         * I recover in the variables the width and the height of my image
         */
        $width = $size[0];
        $height = $size[1];

        /**
         * I suggest an height and a width for the new image
         */
        $Reduction = ( ($this->newwidth * 100)/$width);
        $newheight= ( ($height * $Reduction)/100 );

        /**
         * I create an empty miniature image
         */
        /**
         * imagecreatetruecolor crée une nouvelle image en couleurs vraies, autrement dit une image noire dont il faudra préciser la largeur et la hauteur.
         */
        $miniature = imagecreatetruecolor($this->newwidth, $newheight);
        
        switch ($uploadImageType) 
        {
            case IMAGETYPE_JPEG:
                $image = ImageCreateFromJpeg($targetPath);

                /**
                 * I create the miniature
                 */
                ImageCopyResampled($miniature, $image, 0, 0, 0, 0, $this->newwidth, $newheight, $width, $height );

                /**
                 * I upload the image to the file. This last function is not least useful since 
                 * it will offer us the opportunity not only to save our new image in a file, but also to 
                 * determine the quality with which we will save it!
                 */
                ImageJpeg($miniature, $targetPath, 100 );

                imagedestroy($miniature);
                imagedestroy($image);
            break;

            case IMAGETYPE_GIF:
                $image = imagecreatefromgif($this->path . $this->tmp['name']);

                /**
                 * I create the miniature
                 */
                ImageCopyResampled($miniature, $image, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

                imageGif($miniature, $this->path .$this->tmp['name'], 100 );
            break;

            case IMAGETYPE_PNG:
                $image = imagecreatefrompng($this->path .$this->tmp['name']);
                /**
                 * I create the miniature
                 */
                ImageCopyResampled($miniature, $image, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

                imagePng($miniature, $this->path .$this->tmp['name'], 9 );
            break; 
        }
    }
}