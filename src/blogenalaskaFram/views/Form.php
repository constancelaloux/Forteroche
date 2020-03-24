<?php
?>

<h1>Mon formulaire</h1>

<?php
echo $form->getFormOpen();
//echo $form->getImput();
echo $form->getImputText();
echo $form->getImputPassword();
echo $form->getImputDate();
echo $form->getTextarea();
echo $form->getButton();
echo $form->getFormClose();
?>