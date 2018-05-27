<?php
require 'database.php';

if(!empty($_GET['id']))
{
    $id = checkInput($_GET['id']);
}

$db = Database::connect();
$statement = $db->prepare('SELECT items.id, items.name, items.ram, items.rom, items.price, items.img, items.rating, categories.name AS category FROM items LEFT JOIN categories ON items.category = categories.id WHERE items.id = ?');
$statement->execute(array($id));
$item = $statement->fetch();
Database::disconnect();



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



                    <div class="col-sm-6 mt-5 mx-auto">
                        <h3 class="font-weight-bold">Voir un item:</h3>
                        <br>
                        <form>
                            <div class="form-group">
                                <label>Nom:</label><?php echo ' '. $item['name']; ?>
                            </div>
                            <div class="form-group">
                                <label>Ram:</label><?php echo ' '. $item['ram']; ?>
                            </div>
                            <div class="form-group">
                                <label>Rom:</label><?php echo ' '. $item['rom']; ?>
                            </div>
                            <div class="form-group">
                                <label>Prix:</label><?php echo ' '. number_format((float)$item['price'],2,'.',''). ' €'; ?>
                            </div>
                            <div class="form-group">
                                <label><?php echo ' '. $item['rating']; ?></label>
                            </div>
                            <div class="form-group">
                                <label>Catégorie:</label><?php echo ' '. $item['category']; ?>
                            </div>
                            <div class="form-group">
                                <label>Image:</label><?php echo ' '. $item['img']; ?>
                            </div>
                        </form>
                        <div class="form-actions">
                            <a class="btn btn-secondary" href="index.php" role="button"> &larr; Retour</a>
                        </div>
                    </div>




                    <!-- 1 item-->
                    <div  class="col-sm-6 col-md-4 my-4 mx-auto card">

                        <img src="<?php echo '../img/' . $item['img'] ; ?>" alt="phone-img" class="rounded img-fluid p-3">
                        <div class="price"><h3 class="text-center"><?php echo ' '. $item['price'] . ' €'; ?></h3></div>
                        <div class="caption mx-2">
                            <hr>
                            <div class="specs mx-4">

                                <h4 class="text-center font-weight-bold"><?php echo ' '. $item['name']; ?>
                                </h4>
                                <h6>Ram:
                                    <em><?php echo ' '. $item['ram']; ?></em>
                                </h6>
                                <h6>Rom:
                                    <em><?php echo ' '. $item['rom']; ?></em>
                                </h6>
                                <h6><?php echo ' '. $item['rating']; ?>
                                </h6>
                            </div>
                            <div class="mx-auto text-center my-4">
                                <a href="#" class="btn btn-block btn-order btn-outline font-weight-bold" role="button">
                                    <span>
                                        <i class="fas fa-crosshairs">   </i>
                                    </span> See detailed specs</a>
                            </div>

                        </div>
                    </div>
                    <!-- end item-->
                </div>




            </div>
        </section>
    </body>

</html>
