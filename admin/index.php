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
                    <h3 class="font-weight-bold">Liste des items (modeles): <a href="insert.php" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"> </i> Ajouter</a>
                    </h3>
                    <table class="table table-striped table-bordered my-5">
                       <!-- static table header -->
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Ram</th>
                                <th>Rom</th>
                                <th>Prix</th>
                                <th>Note</th>
                                <th>Catégorie</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                           <!-- dynamic part of the table, showing all item stored in the database -->
                            <?php
                            require 'database.php';
                            $db = Database::connect();
                            //Displaying the db items
                            $statement = $db->query('SELECT items.id, items.name, items.ram, items.rom, items.price, items.rating, categories.name AS category FROM items LEFT JOIN categories ON items.category = categories.id
                                                   ORDER BY items.id DESC');
                            while($item = $statement->fetch())
                            {
                                echo '<tr>';
                                echo '<td>' . $item['name'] . '</td>';
                                echo '<td>' . $item['ram'] . '</td>';
                                echo '<td>' . $item['rom'] . '</td>';
                                echo '<td>' . number_format((float)$item['price'],2,'.','') . '</td>';
                                echo '<td>' . $item['rating'] . '</td>';
                                echo '<td>' . $item['category'] . '</td>';
                                echo '<td width=350>';
                                echo '<a class="btn btn-dark" href="view.php?id=' . $item['id'] . '"><i class="fa fa-eye" aria-hidden="true"> </i> Voir</a>';
                                echo ' ';
                                echo '<a class="btn btn-primary" href="update.php?id=' . $item['id'] . '"><i class="fas fa-pencil-alt"></i> Modifier</a>';
                                echo ' ';
                                echo '<a class="btn btn-danger" href="delete.php?id='. $item['id'] . '"><i class="fas fa-times"></i>Supprimer</a>';
                                echo ' ';
                                echo '</td>';
                                echo '</tr>';
                            }
                            Database::disconnect();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </body>

</html>
