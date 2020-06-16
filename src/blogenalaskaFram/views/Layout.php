<!DOCTYPE html>
   
<meta charset="utf-8" />
<title><?= $title ?? 'Jean Forteroche'?></title></>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<link rel="icon" type="image/png" href="images/favicon.png" />

<!--CSS-->
<link href="/public/css/style.css" rel="stylesheet" />

<!--Jquery-->
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>-->
<!--<link href="/blogenalaska/jquery/jquery-ui.min.js"  rel="stylesheet"/>-->
<!--<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!--Datatables-->
<!--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>-->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>

<!--Tinymce-->
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<!--<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>-->
<script type="text/javascript" src="/../../public/js/Tinymce.js"></script>
<script type="text/javascript" src="/../../public/js/fr_FR.js"></script>
<!--<script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=your_API_key"></script> -->

<!--Bootstrap-->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>     
<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"  crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" crossorigin="anonymous"></script>-->
<!--<link href="/blogenalaska/bootstrap-4.0.0/css/bootstrap.min.css"  rel="stylesheet"/>
<link href="/blogenalaska/bootstrap-4.0.0/js/bootstrap.min.js"  rel="stylesheet"/>-->

<!--Logo fontawesome-->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

<!--Police-->
<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,900" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Bad+Script&amp;subset=cyrillic" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=News+Cycle" rel="stylesheet">
<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">-->
<!--<script src="/blogenalaska/Bootstrap/js/bootstrap.min.js"></script>
<link href="/blogenalaska/Bootstrap/css/bootstrap.css" rel="stylesheet">-->

<!--Articles-->
<script type="text/javascript" src="/../../public/js/Backoffice.js"></script>

<!--Upload-->
<!--<script type="text/javascript" src="/../../public/js/upload.js"></script>-->
<script type="text/javascript" src="/../../public/js/UploadFile.js"></script>

<!--Scroll nav-->
<script type="text/javascript" src="/../../public/js/scrollnav.js"></script>

<!--List of comments backend-->
<script type="text/javascript" src="/../../public/js/CommentsBackend.js"></script>

<!--Countclicks-->
<script type="text/javascript" src="/../../public/js/Countclicks.js"></script>

<body>
    <?php 
    //if (session_status() === PHP_SESSION_NONE)
   /* {
        session_start();
    } */
?>
    <?php 
        if ($_SESSION['status'] === 'admin')
        {
            require __DIR__.'/../views/AdminHeader.php';
        }
        else 
        {
            require __DIR__.'/../views/Header.php'; 
        }
    ?>

    <!--Main layout-->
    <main role="main" class="main">				
        <!--Main container-->
        <div id="spy" data-spy="scroll" data-target="#navbar" data-offset="0">
        <div class="container-fluid" id="main-container">
            <!-- ce qui doit etre fait normalement pour le message flash -->
            <?php
            //print_r($_SESSION);
            if($session->get('success'))
            {
            ?>
                <div class="alert alert-success mt-5" role="alert">
            <?php
                echo $session->get('success');
            ?>
                </div>   
            <?php
            }
            else if($session->get('error'))
            {
            ?>
                <div id='#myAlert' class="alert alert-danger mt-5">
            <?php
                echo $session->get('error');
            }
            ?>
                </div>
            <?= $content ?> 
        </div>
        </div>
        <!--Main container-->				
    </main>
    <!--Main layout-->
    <?php require __DIR__.'/../views/Footer.php'; ?>
</body>



