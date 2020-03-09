$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
    // Append table with add row form on add new button click
    $(".add-new").click(function(){
        $(this).attr("disabled", "disabled");
        var index = $("table tbody tr:last-child").index();
        var row = '<tr>' +
            '<td><input type="text" class="form-control" name="county" id="county"></td>' +
            '<td><input type="text" class="form-control" name="country" id="country"></td>' +
            '<td><input type="text" class="form-control" name="town" id="town"></td>' +
            '<td><input type="text" class="form-control" name="postcode" id="postcode"></td>' +
            '<td><input type="textarea" class="form-control" name="description" id="description"></td>' +
            '<td><input type="text" class="form-control" name="address" id="address"></td>' +
            '<td><input type="file" class="form-control" name="image" id="image"></td>' +
            '<td><input type="number" class="form-control" name="num_bedrooms" id="num_bedrooms"></td>' +
            '<td><input type="number" class="form-control" name="num_bathrooms" id="num_bathrooms"></td>' +
            '<td><input type="number" min="0.00" max="10000.00" step="0.01" class="form-control" name="price" id="price"></td>' +
            '<td><select name="property_type_id" id="property_type_id">\n' +
            '  <option value="volvo">Cottage</option>\n' +
            '  <option value="saab">Flat</option>\n' +
            '  <option value="opel">Detatched</option>\n' +
            '  <option value="audi">Bungalow</option>\n' +
            '</select></td>' +
            '<td><input type="text" class="form-control" name="type" id="type"></td>' +
            '<td>\n' +
            '    <a class="add" title="Add" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>\n' +
            '    <a class="edit" title="Edit" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>\n' +
            '    <a class="delete" title="Delete" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>\n' +
            '</td>' +

            '</tr>';
        $("table").append(row);
        $("table tbody tr").eq(index + 1).find(".add, .edit").toggle();
        $('[data-toggle="tooltip"]').tooltip();
    });
    // Add row on add button click
    $(document).on("click", ".add", function(){
        var empty = false;
        var input = $(this).parents("tr").find('input[type="text"]');
        input.each(function(){
            if(!$(this).val()){
                $(this).addClass("error");
                empty = true;
            } else{
                $(this).removeClass("error");
            }
        });
        $(this).parents("tr").find(".error").first().focus();
        if(!empty){
            input.each(function(){
                $(this).parent("td").html($(this).val());
            });
            $(this).parents("tr").find(".add, .edit").toggle();
            $(".add-new").removeAttr("disabled");
        }
    });
    // Edit row on edit button click
    $(document).on("click", ".edit", function(){
        $(this).parents("tr").find("td:not(:last-child)").each(function(){
            $(this).html('<input type="text" class="form-control" value="' + $(this).text() + '">');
        });
        $(this).parents("tr").find(".add, .edit").toggle();
        $(".add-new").attr("disabled", "disabled");
    });
    // Delete row on delete button click
    $(document).on("click", ".delete", function(){
        $(this).parents("tr").remove();
        $(".add-new").removeAttr("disabled");
    });
});