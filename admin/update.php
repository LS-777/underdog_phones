<!-- objectif= pouvoir modifier les valeurs des propriétés des items, en écrasant les modifiées, et gardant les inchangées, le tout en récupérant les valeurs initiales de l'item en question
-->


<?php
require 'database.php';

if(!empty($_GET['id']))
{
    $id = checkInput($_GET['id']);
}

$nameError = $ramError = $romError = $priceError = $ratingError = $categoryError = $imgError = $name = $ram = $rom = $price = $rating = $category = $img = "";


if(!empty($_POST))
{
    $name       = checkInput($_POST['name']);
    $ram        = checkInput($_POST['ram']);
    $rom        = checkInput($_POST['rom']);
    $price      = checkInput($_POST['price']);
    $rating     = checkInput($_POST['rating']);
    $category   = checkInput($_POST['category']);
    $img        = checkInput($_FILES['img']['name']);
    $imgPath    = '../img/' . basename($img);
    $imgExtension = pathinfo($imgPath, PATHINFO_EXTENSION);
    $isSuccess   = true;

    if(empty($name))
    {
        $nameError = "Champ requis";
        $isSuccess = false;
    }
    if(empty($ram))
    {
        $ramError = "Champ requis";
        $isSuccess = false;
    }
    if(empty($rom))
    {
        $romError = "Champ requis";
        $isSuccess = false;
    }
    if(empty($price))
    {
        $priceError = "Champ requis";
        $isSuccess = false;
    }
    if(empty($rating))
    {
        $ratingError = "Champ requis";
        $isSuccess = false;
    }
    if(empty($category))
    {
        $categoryError = "Champ requis";
        $isSuccess = false;
    }
    if(empty($img))
    {
        $isImgUpdated = false;

    }
    else
    {
        $isImgUpdated = true;
        $isUploadSuccess = true;
        if($imgExtension != "jpg" && $imgExtension != "png" && $imgExtension != "jpeg" && $imgExtension != "gif" )
        {
            $imgError = "Formats autorisés: .jpg, .jpeg, .png, .gif";
            $isUploadSuccess = false;
        }
        if(file_exists($imgPath))
        {
            $imgError = "Le fichier existe déjà";
            $isUploadSuccess = false;
        }
        if($_FILES["img"]["size"] > 1000000)
        {
            $imgError = "La taille du fichier ne doit pas dépasser 1MB";
            $isUploadSuccess = false;
        }
        if($isUploadSuccess)
        {
            if(!move_uploaded_file($_FILES["img"]["tmp_name"], $imgPath))
            {
                $imgError = "Il y a eu une erreur lors de l'upload";
                $isUploadSuccess = false;

            }
        }
    }

    if(($isSuccess && $isImgUpdated && isUploadSuccess) || ($isSuccess && !$isImgUpdated ))
    {
        $db = Database::connect();
        if($isImgUpdated){
            $statement = $db->prepare("UPDATE items set name = ?, ram = ?, rom = ?, price = ?, img = ?, category = ?, rating = ? WHERE id = ?");
            $statement->execute(array($name,$ram,$rom,$price,$img,$category,$rating, $id));
        }
        else
        {
            $statement = $db->prepare("UPDATE items set name = ?, ram = ?, rom = ?, price = ?, category = ?, rating = ? WHERE id = ?");
            $statement->execute(array($name,$ram,$rom,$price,$category,$rating, $id));
        }

        Database::disconnect();
        header("Location: index.php");
    }

    else if($isImgUpdated && !$isUploadSuccess)
    {
        $db = Database::connect();
        $statement = $db->prepare("SELECT img FROM items WHERE id = ?");
        $statement->execute(array($id));
        $item = $statement->fetch();
        $img = $item['img'];
        Database::disconnect();


    }

}
else
{
    $db = Database::connect();
    $statement = $db->prepare("SELECT * FROM items WHERE id = ?");
    $statement->execute(array($id));
    $item = $statement->fetch();
    $name = $item['name'];
    $ram = $item['ram'];
    $rom = $item['rom'];
    $price = $item['price'];
    $rating = $item['rating'];
    $category = $item['category'];
    $img = $item['img'];
    Database::disconnect();
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

                    <div class="col-sm-6">
                        <h3 class="font-weight-bold">Modifier un item:</h3>
                        <br>
                        <form class="form" role="form" action="<?php echo 'update.php?id=' . $id; ?>" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="name">Nom:</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Nom" value="<?php echo $name ?>">
                                <span class="help-inline"><?php echo $nameError; ?></span>
                            </div>
                            <div class="form-group">
                                <label for="ram">Ram:</label>
                                <input type="text" class="form-control" id="ram" name="ram" placeholder="Ram" value="<?php echo $ram ?>">
                                <span class="help-inline"><?php echo $ramError; ?></span>
                            </div>
                            <div class="form-group">
                                <label for="rom">Rom:</label>
                                <input type="text" class="form-control" id="rom" name="rom" placeholder="Rom" value="<?php echo $rom ?>">
                                <span class="help-inline"><?php echo $romError; ?></span>
                            </div>
                            <div class="form-group">
                                <label for="prix">Prix: (€)</label>
                                <input type="number" step="0.1" class="form-control" id="price" name="price" placeholder="Prix" value="<?php echo $price ?>">
                                <span class="help-inline"><?php echo $priceError; ?></span>
                            </div>
                            <div class="form-group">
                                <label for="note">Note:</label>
                                <input type="text" class="form-control" id="rating" name="rating" placeholder="Rating: xx/10" value="<?php echo $rating ?>">
                                <span class="help-inline"><?php echo $ratingError; ?></span>
                            </div>
                            <div class="form-group">
                                <label for="category">Catégorie:</label>
                                <select class="form-control" id="category" name="category">
                                    <?php
                                    $db = Database::connect();
                                    foreach($db->query('SELECT * FROM categories') as $row)
                                    {
                                        if($row['id'] == $category)
                                            echo '<option selected="selected" value="' . $row['id'] . '">' . $row['name'] . '</option>';
                                        else
                                            echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                                    }
                                    Database::disconnect();

                                    ?>
                                </select>
                                <span class="help-inline"><?php echo $categoryError; ?></span>
                            </div>


                            <div class="form-group">
                                <label>Image actuelle: </label>
                                <p><?php echo $img; ?></p>
                                <label for="img">Sélectionner une image:</label>
                                <input type="file" id="img" name="img">
                                <span class="help-inline"><?php echo $imgError; ?></span>
                            </div>


                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-pencil-alt" aria-hidden="true"> </i> Modifier</button>
                                <a class="btn btn-secondary" href="index.php" role="button"> &larr; Retour</a>
                            </div>
                        </form>
                    </div>
                    <div  class="col-sm-6 col-md-5 my-auto mx-auto card">

                        <img src="<?php echo '../img/' . $img ; ?>" alt="phone-img" class="rounded img-fluid p-3">
                        <div class="price"><h3 class="text-center"><?php echo ' '. $price . ' €'; ?></h3></div>
                        <div class="caption mx-2">
                            <hr>
                            <div class="specs mx-4">

                                <h4 class="text-center font-weight-bold"><?php echo ' '. $name; ?>
                                </h4>
                                <h6>Ram:
                                    <em><?php echo ' '. $ram; ?></em>
                                </h6>
                                <h6>Rom:
                                    <em><?php echo ' '. $rom; ?></em>
                                </h6>
                                <h6><?php echo ' '. $rating; ?>
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
                </div>




            </div>
        </section>
    </body>

</html>
