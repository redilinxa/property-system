<?php
require_once ('models/PropertyTypes.php');
require_once ('config/database.php');
$database = new Database();

$propertyTypes = new PropertyTypes($database->getConnection());
$types = $propertyTypes->readAll();
?>
<form id="crud" action="#" method="post" enctype="multipart/form-data">
    <div id="userModal" class="modal fade">
        <div class="modal-dialog">
            <form method="post" id="user_form" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add User</h4>
                    </div>
                    <div class="modal-body">
                        <label>Enter County</label>
                        <input type="text" name="county" id="county" class="form-control" />
                        <br />
                        <label>Enter Country</label>
                        <input type="text" name="county" id="county" class="form-control" />
                        <br />
                        <label>Enter Town</label>
                        <input type="text" name="town" id="town" class="form-control" />
                        <br />
                        <label>Enter Postcode</label>
                        <input type="text" name="postcode" id="postcode" class="form-control" /><br />
                        <br />
                        <label>Enter Description</label>
                        <input type="text" name="description" id="description" class="form-control" />
                        <br />
                        <label>Enter Displayable Address</label>
                        <input type="text" name="address" id="address" class="form-control" />
                        <br />
                        <label>Enter No of Bedrooms</label>
                        <input type="number" name="num_bedrooms" id="num_bedrooms" class="form-control" /><br />
                        <br />
                        <label>Enter No of Bathrooms</label>
                        <input type="number" name="num_bathrooms" id="num_bathrooms" class="form-control" />
                        <br />
                        <label>Enter Price</label>
                        <input type="number" name="price" id="price" class="form-control" />
                        <br />
                        <label>Enter Type</label>
                        <select name="property_type_id" id="property_type_id" class="form-control">
                            <?php foreach ($types as $type) {
                                echo "<option value='{$type['id']}'>{$type['title']}</option>";
                            } ?>
                        </select>
                        <br />
                        <label>Chose Status</label>
                        <input type="checkbox" name="rent" id="rent" class="form-control" value = "Rent"/>
                        <input type="checkbox" name="sale" id="sale" class="form-control" value = "Sale"/>
                        <br />
                        <label>Select Image</label>
                        <input type="file" name="user_image" id="user_image" />
                        <span id="user_uploaded_image"></span>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="user_id" id="user_id" />
                        <input type="hidden" name="operation" id="operation" />
                        <input type="submit" name="action" id="action" class="btn btn-success" value="Add" />
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</form>