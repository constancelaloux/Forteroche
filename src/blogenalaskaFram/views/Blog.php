<?php
$title = 'Form page';
//ob_start();
//ob_start();
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//$renderer->render('Header');
echo 'voici la page de blog';
//$content = 'test';
//var_dump($params['form']);
echo $form->getFormOpen();
//echo $form->getImput();
echo $form->getImputText();
echo $form->getImputPassword();
echo $form->getImputDate();
echo $form->getTextarea();
echo $form->getButton();
echo $form->getFormClose();
//var_dump($params['form']);
//echo $params['form'];
/*echo $params['input'];
echo $params['textarea'];
echo $params['button'];*/
/*foreach ($params as $key => $value) {
    echo $value;
}*/
//$content = ob_get_clean();
//$content = ob_get_clean();