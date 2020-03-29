<?php

$this->session = new PHPSession();
if($this->session->get('success'))
{
    ?>
        <div class="alert alert-success" role="alert">
          This is a success alert—check it out!
        </div>
        <div id='#myAlert' class="alert alert-danger">          
            <?php echo $this->session->get('success');
            ?>
        </div>
    <?php
}