<?php

namespace blog\file;

use blog\file\UploadedFilesInterface;

/**
 * Description of Upload
 *
 * @author constancelaloux
 */
class Upload 
{
    /**
     * Le chemin vers lequel on veut sauvegarder
     */
    protected $path;
    
    /**
     * Format de l'image
     */
    protected $formats;
    
    // Allowed origins to upload images
    protected $accepted_origins = array("http://localhost:8888", "http://127.0.0.1:8888");

    // Images upload path
    protected $imageFolder = "Forteroche/Public/images/";
    
    protected $tmp;
    
    protected $tmpName;
    
    protected $filename;
    
    /*public function construct(?string $path)
    {
        if($path)
        {
            $this->path = $path;
        }
    }*/
    public function __construct(?string $path = null)
    {
        //print_r($this->path);
        //$this->path = 'public/images';
        //Si le chemin est défini
        if($path)
        {
            //print_r($path);
            //die("meurs dans le construct");
            $this->path = $path;
        }
    }
    
    /**
     * Je récupére le nom de l'image
     * @param type $file
     * @return type
     */
    private function getClientFilename(array $file)
    {
        $this->tmp = current($file);
        //print_r($this->tmp);
        //print_r($this->tmp['tmp_name']);
        if(is_uploaded_file($this->tmp['tmp_name']))
        {
            if(isset($_SERVER['HTTP_ORIGIN']))
            {
                // Same-origin requests won't set an origin. If the origin is set, it must be valid.
                if(in_array($_SERVER['HTTP_ORIGIN'], $this->accepted_origins))
                {
                    //print_r(header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']));
                    header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
                }
                else
                {
                    header("HTTP/1.1 403 Origin Denied");
                    return;
                }
            }

            // Sanitize input
            if(preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $this->tmp['name']))
            {
                header("HTTP/1.1 400 Invalid file name.");
                return;
            } 
            
            // Verify extension
            if(!in_array(strtolower(pathinfo($this->tmp['name'], PATHINFO_EXTENSION)), array("gif", "jpg", "png")))
            {
                header("HTTP/1.1 400 Invalid extension.");
                return;
            }
            //print_r("je vois si je passe ici");
            return $this->tmpName = $this->tmp['name'];
        }
    }
    
    /**
     * On envoi le fichier dans le fichier cible
     * @param type $targetPath
     */
    public function moveTo($targetPath)
    {
        if(move_uploaded_file($this->tmp['tmp_name'], $targetPath))
        {
              echo 'Transfert réussi';
        }
        else
        {
            echo 'erreur dans l\'envoi<br />';
        }
       // move_uploaded_file($this->tmp['tmp_name'], $this->path . $this->filename);
    }
    
    /**
     * Prend en paramétre le fichier que l'on a uploadé
     * Uploader le fichier dans le bon dossier
     * retourne une chaine de caractéres qui sera le nom du fichier
     * Dans le but ensuite de sauvegarder ce fichier
     * @param \blog\file\UploadedFileInterface $file
     */
    public function upload($file, ?string $oldFile = null)//, ?string $oldFile): string//UploadedFileInterface $file, ?string $oldFile = null): string
    {
        /**
         * On vérifie si le vieux fichier existe
         */
        print_r($oldFile);
        $this->delete($oldFile);
        
        /**
         * Je récupére le nom du fichier
         */
        $this->filename = $this->getClientFilename($file);
        //$filename = $file->getClientFilename();

        /**
         * J'ajoute l'image dans le chemin cible et une copie avec l'extension copy si l'image existe déja
         */
        $targetPath = $this->addCopySuffix($this->path .DIRECTORY_SEPARATOR . $this->filename);

        /**
         * Avant d'uploader il faut que je vérifie si le dossier existe
         */
        $dirname = pathinfo($targetPath, PATHINFO_DIRNAME);

        if(!file_exists($dirname))
        {
            mkdir($dirname, 777, TRUE);
        }
        
        /**
         * J'envoi l'image avec son chemin dans le fichier cible
         */
        $this->moveTo($targetPath);
        //$file->moveTo($targetPath);
        
        /**
         * On récupére le nom du fichier + l'extension (ex: test.php)
         */
        $path_parts = pathinfo($targetPath);

        //print_r($path_parts['basename']);
        return $path_parts['basename'];
        //return pathinfo($targetPath['basename']);
        //return $filename;
    }
    
    /**
     * Vérifie si le fichier existe
     * @param string $targetPath
     */
    private function addCopySuffix(string $targetPath): string
    {
        if(file_exists($targetPath))
        {
            //Je construit un nouveau chemin avec copy à la fin car le fichier existe déja dans le dossier
            return $this->addCopySuffix($this->getPathWithSuffix($targetPath, 'copy'));
            //$info = pathinfo($targetPath);
            //Je construit un nouveau chemin
            /*$targetPath = $info['dirname'] . 
                    DIRECTORY_SEPARATOR . 
                    $info['filename'] . 
                    '_copy.' . 
                    $info['extension'];
            return $this->addSuffix($targetPath);*/
        }   
        return $targetPath;
    }
    
    /**
     * Supprimer un fichier
     */
    public function delete(?string $oldFile): void
    {
        if($oldFile)
        {
            print_r("je passe la");
            $oldFile = $this->path . DIRECTORY_SEPARATOR . $oldFile;
            if(file_exists($oldFile))
            {
                print_r("je passe la");
                //Je supprime le vieux fichier
                unlink($oldFile);
            }
            /*foreach ($this->formats as $format => $_) 
            {
                //Si le fichier existe je le supprime
                $oldFileWithFormat = $this->getPathWithSuffix($oldFile, $format);
                
                if(file_exists($oldFileWithFormat))
                {
                    unlink($oldFileWithFormat);
                }
            }*/
        }
    }
    
    private function getPathWithSuffix(string $path, string $suffix): string
    {
        $info = pathinfo($path);
        //Je construit un nouveau chemin
        return $info['dirname'] . 
                DIRECTORY_SEPARATOR . 
                $info['filename'] . 
                '_'. $suffix.'.' .
                $info['extension'];
    }
    
    /**
     * On génére les différents formats
     */
    private function generateFormats($targetPath)
    {
        foreach ($this->formats as $format => $size) 
        {
            $manager = new ImageManager(['driver' => 'gd']);
            $destination = $this->getPathWithSuffix($targetPath, $format);
            [$width, $height] = $size;
            $manager->make($targetPath)->fit($width, $height)->save($destination);
        }
        //Je vais chercher la taille de mon image
        /*$size = getimagesize($imageFolder. $temp['name']);

        $uploadImageType = $size[2];

        //Je récupére dans les variables la largeur et la hauteur de mon image
        $width = $size[0];
        $height = $size[1];

        //Je propose une hauteur et une largeur à ma nouvelle image
        $newwidth = 550;
        $Reduction = ( ($newwidth * 100)/$width);
        $newheight= ( ($height * $Reduction)/100 );

        //Je créé une image miniature vide
        //imagecreatetruecolor crée une nouvelle image en couleurs vraies, autrement dit une image noire dont il faudra préciser la largeur et la hauteur.
        $miniature = imagecreatetruecolor($newwidth,$newheight);*/
    }
}
