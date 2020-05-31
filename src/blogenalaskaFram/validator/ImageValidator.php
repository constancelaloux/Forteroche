<?php

namespace blog\validator;

use blog\validator\Validator;

/**
 * Description of ImageValidator
 *
 * @author constancelaloux
 */
class ImageValidator extends Validator
{
    private const MIME_TYPES =
    [
        'jpg' => 'image/jpeg',
        'png' => 'image/png',
        'pdf' => 'application/pdf'
    ];

    public function isValid($value)
    {

    }

    public function checkImage()
    {
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
    /**
     * Vérifie le format de fichier
     * @param string $key
     * @param array $extension
     * @return \self
     */
    public function extension(string $key, array $extensions): self
    {
        $file = $this->getValue($key);
        /**
         * Ca veut dire que l'on a pas eu d'erreur d'upload UPLOAD_ERR_OK
         */
        if($file !== NULL && $file->getError() === UPLOAD_ERR_OK)
        {
            $type = $file->getClientMediaType();
            $extension = mb_strtolower(pathinfo($file->getClientFilename(), PATHINFO_EXTENSION));
            $expectedType = self::MIME_TYPES[$extension] ?? NULL;
            /**
             * Si cette extension est dans le tableau des extensions
             */
            if(!in_array($extension, $extensions) || $expectedType !== $type )
            {
                $this->addError($key, 'fileType', [join(',', $extensions)]);
            }
        }
        return $this;
    }
    
    /**
     * Vérifie que le fichier doit étre nécessairement uploadé
     * @param string $key
     */
    public function uploaded(string $key): self
    {
        $file = $this->getValue($key);
        if($file === NULL || $file->getError() !== UPLOAD_ERR_OK)
        {
            $this->addError($key, 'uploaded');
        }
        return $this;
    }
}
