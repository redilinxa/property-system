<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round|Open+Sans">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="public/assets/main.css"
</head>
<body>
<?php
include ('./crud/property/read.php');
?>
<main class="bd-content p-5" id="content" role="main">
    <div class="table">
        <div class="table-title">
            <div class="row">
                <div class="col-sm-8"><h2>Property <b>Details</b></h2></div>
                <div class="col-sm-4">
                    <button type="button" class="btn btn-info add-new"><i class="fa fa-plus"></i> Add New</button>
                    <button type="button" class="btn btn-warning add-new"><i class="fa fa-refresh"></i> Refresh API data</button>
                </div>
            </div>
        </div>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>County</th>
                <th>Country</th>
                <th>Town</th>
                <th>Postcode</th>
                <th>Description</th>
                <th>Displayable Address</th>
                <th>Image</th>
                <th>Number of bedrooms</th>
                <th>Number of bathrooms</th>
                <th>Price</th>
                <th>Property Type</th>
                <th>For Sale / For Rent</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($result_set['properties'] as $property) { ?>
                <tr>
                    <td><?php echo $property['county'] ?></td>
                    <td><?php echo $property['country'] ?></td>
                    <td><?php echo $property['town'] ?></td>
                    <td><?php echo $property['postcode'] ?></td>
                    <td><?php echo $property['description'] ?></td>
                    <td><?php echo $property['address'] ?></td>
                    <td><?php echo $property['image'] ?></td>
                    <td><?php echo $property['num_bedrooms'] ?></td>
                    <td><?php echo $property['num_bathrooms'] ?></td>
                    <td><?php echo $property['price'] ?></td>
                    <td><?php echo $property['property_type_id'] ?></td>
                    <td><?php echo $property['type'] ?></td>
                    <td>
                        <a class="add" title="Add" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>
                        <a class="edit" title="Edit" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
                        <a class="delete" title="Delete" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</main>
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="public/assets/main.js" type="application/javascript"></script>
</body>
</html>