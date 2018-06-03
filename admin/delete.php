<?php
require 'database.php';

if (!empty($_GET['id'])) {
    $id = checkInput($_GET['id']);
}

if (!empty($_POST)) {
    $id = checkInput($_POST['id']);
    $db = Database::connect();
    $statement = $db->prepare("DELETE FROM items WHERE id = ?");
    $statement->execute(array($id));
    Database::disconnect();
    header("Location:index.php");
}

function checkInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>




<!DOCTYPE html>
<html>

    <head>
        <title>Underdog chinese phones</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="icon" type="image/x-icon" href="../img/fav.png">

        <!-- jquery -->
        <script
                src="https://code.jquery.com/jquery-3.3.1.js"
                integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
                crossorigin="anonymous"></script>
        <!-- bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">



        <!-- imported google fonts -->
        <link href="https://fonts.googleapis.com/css?family=Lato|Rubik|Source+Sans+Pro|Space+Mono|Work+Sans" rel="stylesheet">
        <!-- font awesome cdn link -->
        <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
        <!-- css style sheet -->
        <link rel="stylesheet" href="../css/style.css">
        <!-- AOS -->
        <link href="https://cdn.rawgit.com/michalsnik/aos/2.1.1/dist/aos.css" rel="stylesheet">


    </head>
    <body>

        <section class="admin-section py-5">
            <h1 class="text-logo pb-3 text-center">
                UNDERDOG PHONES <img class="flag" src="../img/china.png" width="150px"/>
            </h1>

            <div class="container admin">
                <div class="row">

                    <div class="col-md-12">
                        <h3 class="font-weight-bold">Supprimer un item:</h3>
                        <br>
                        <form class="form" role="form" action="delete.php" method="post">
                            <input type="hidden" name="id" value="<?php echo $id;?>"/>
                            <p class="alert-warning p-3"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>  Êtes-vous sûr?</p>
                            <div class="form-actions">
                                <button type="submit" class="btn btn-warning"><i class="fa fa-trash-alt" aria-hidden="true"> </i> Supprimer</button>
                                <a class="btn btn-secondary" href="index.php" role="button"> &larr; Retour</a>
                            </div>
                        </form>
                    </div>
                </div>




            </div>
        </section>
    </body>

</html>
