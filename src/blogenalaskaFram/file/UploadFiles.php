<?php
namespace blog\files;

/**
 * Description of UploadFiles
 *
 * @author constancelaloux
 */
class UploadFiles
{
    function upload()
    {
        // Allowed origins to upload images
        $accepted_origins = array("http://localhost:8888", "http://127.0.0.1:8888");

        // Images upload path
        $imageFolder = "Public/images/";

        reset($_FILES);
        $temp = current($_FILES);

        if(is_uploaded_file($temp['tmp_name']))
        {
            if(isset($_SERVER['HTTP_ORIGIN']))
            {
                // Same-origin requests won't set an origin. If the origin is set, it must be valid.
                if(in_array($_SERVER['HTTP_ORIGIN'], $accepted_origins))
                {
                    header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
                }
                else
                {
                    header("HTTP/1.1 403 Origin Denied");
                    return;
                }
            }

            // Sanitize input
            if(preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $temp['name']))
            {
                header("HTTP/1.1 400 Invalid file name.");
                return;
            }

            // Verify extension
            if(!in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), array("gif", "jpg", "png")))
            {
                header("HTTP/1.1 400 Invalid extension.");
                return;
            }

            // Accept upload if there was no origin, or if it is an accepted origin

            $filetowrite1 = "/blogenalaska/" . $imageFolder . $temp['name'];

            if (move_uploaded_file($temp['tmp_name'], $imageFolder . $temp['name']))
            {
                //Je vais chercher la taille de mon image
                $size = getimagesize($imageFolder. $temp['name']);

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
                $miniature = imagecreatetruecolor($newwidth,$newheight);

                switch ($uploadImageType) 
                {
                    case IMAGETYPE_JPEG:
                        //La photo est la source
                        $image = ImageCreateFromJpeg($imageFolder .$temp['name']);

                        //Je créé la miniature
                        ImageCopyResampled($miniature, $image, 0, 0, 0, 0, $newwidth, $newheight, $width, $height );

                        ////J'upload l'image dans le fichier
                        //Cette dernière fonction n'est pas des moins utiles puisqu'elle va nous offrir l'opportunité 
                        //non seulement de sauvegarder notre nouvelle image dans un fichier, 
                        //mais également de déterminer la qualité avec laquelle on va l'enregistrer !
                        ImageJpeg($miniature, $imageFolder . $temp['name'], 100 );

                        imagedestroy($miniature);
                        imagedestroy($image);
                    break;

                    case IMAGETYPE_GIF:
                        //La photo est la source
                        $image = imagecreatefromgif($imageFolder .$temp['name']);

                        //Je créé la miniature
                        ImageCopyResampled($miniature, $image, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

                        imageGif($miniature, $imageFolder . $temp['name'], 100 );
                    break;

                    case IMAGETYPE_PNG:
                        $image = imagecreatefrompng($imageFolder .$temp['name']);
                        //Je créé la miniature
                        ImageCopyResampled($miniature, $image, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

                        imagePng($miniature, $imageFolder . $temp['name'], 9 );
                    break;           
                }       
            }
//END of resize

            // Respond to the successful upload with JSON.
            echo "$filetowrite1";
        } 
        else 
        {
            // Notify editor that the upload failed
            header("HTTP/1.1 500 Server Error");
        }  
    }

    function upload2()
    {
        if (isset($_GET['data']))
        {
            if (!empty($_GET['data']))
            {
                $filetowrite1 = $_GET['data'];

                echo "<img src='$filetowrite1' />";
            }
            else
            {
                $session = new SessionClass();
                $session->setFlash('erreur','error');
            }

        }
        else
        {
            $session = new SessionClass();
            $session->setFlash('erreur','error');
        }
    }
}