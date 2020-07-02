<?php

namespace blog;

use blog\ResponseInterface;

/**
* Description of HTTPResponse
* Ce que l'on va renvoyer au client.
* @author constancelaloux
*/

class HTTPResponse implements ResponseInterface
{  
    /**
    * @return string
     * De rediriger l'utilisateur.
    */
    public function redirectResponse(string $location)
    {
        header('Location: '.$location);
        exit;
    }

    /**
    * @return string
     * De le rediriger vers une erreur 404.
     * On commence d'abord par créer une instance de la classe Page 
     * que l'on stocke dans l'attribut correspondant.
     * On assigne ensuite à la page le fichier qui fait office de vue 
     * à générer. Ce fichier contient le message d'erreur formaté. 
     * Vous pouvez placer tous ces fichiers dans le dossier /Errors 
     * par exemple, sous le nom code.html. Le chemin menant au fichier
     * contenant l'erreur 404 sera donc /Errors/404.html.
     * un header disant que le document est non trouvé (HTTP/1.0 404 Not Found).
     * On envoie la réponse.
    */
    public function redirect404()
    {
       // $location = __DIR__.'/views/Page404.php';
        header('Location: '.$location);
        exit("");
    }
}
