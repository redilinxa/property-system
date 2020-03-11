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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="public/assets/main.css"
</head>
<body>

<div class="container box">
    <div class="table-responsive">
        <br />
        <div align="right">
            <button type="button" id="add_button" data-toggle="modal" data-target="#userModal" class="btn btn-info btn-lg">Add</button>
            <button type="button" id="refresh" data-toggle="modal" class="btn btn-warning btn-lg">Refresh</button>
        </div>
        <br /><br />

        <table id="property-data" class="table table-bordered table-striped">
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
        </table>
    </div>
<?php require_once ('template/crud.php')?>
</div>
</main>
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="public/assets/main.js" type="application/javascript"></script>
</body>
</html>