$(document).ready(function(){
    // Add row on add button click
    $("#refresh").click(function(){
        this.disabled = true;
        $datatabple = dataTable;
        $.ajax({
            url: '/crud/property/sync.php',
            data: {},
            type: 'GET',
            crossDomain: true,
            dataType: 'json',
        }).done((response) => {
            console.log(response);
            $datatabple.ajax.reload();
            this.disabled = false;
        })
        .fail((error) => {
            console.log(error);
        });
    });

    $('#add_button').click(function(){
        $('#property_form')[0].reset();
        $('.modal-title').text("Add Property");
        $('#action').val("Add");
        $('#operation').val("Add");
        $('#user_uploaded_image').html('');
    });

    var dataTable = $('#property-data').DataTable({
        "processing":true,
        //"serverSide":true,
        order: [[ 13, "desc" ]],
        pageLength : 5,
        "columnDefs": [
            {
                "targets": [ 13 ],
                "visible": false,
                "searchable": false
            }
        ],
        lengthMenu: [[5, 10, 15, 20, -1], [5, 10, 15, 20, 'All']],
        "ajax":{
            url:"/crud/property/read.php",
            type:"GET"
        }
    });
    $(document).on('submit', '#property_form', function(event){
        event.preventDefault();
        console.log('erdhi');
        var extension = $('#property_image').val().split('.').pop().toLowerCase();
        console.log(extension);
        if(extension != '')
        {
            if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)
            {
                alert("Invalid Image File");
                $('#property_image').val('');
                return false;
            }
        }
        $.ajax({
            url:"/crud/property/createUpdate.php",
            method:'POST',
            data:new FormData(this),
            contentType:false,
            processData:false,
        }).done((data) => {
            console.log(data);
            $('#property_form')[0].reset();
            $('#propertyModal').modal('hide');
            dataTable.ajax.reload();
        })
        .fail((error) => {
            console.log(error);
        });
    });

    $(document).on('click', '.edit', function(){
        var uuid = $(this).attr("id");
        $.ajax({
            url:"/crud/property/readOne.php",
            method:"GET",
            data:{uuid:uuid},
            dataType:"json",
        }).done((data) => {
            $('#propertyModal').modal('show');
            $('.modal-title').text("Edit property");
            $('#uuid').val(uuid);
            $('#property_uploaded_image').html(data.property_image);
            $('#action').val("Edit");
            $('#operation').val("Edit");
            //manually fill the select box and the radio button.
            $('#property_form #property_type_id').val(data.property_type_id);
            $('#property_form input[name="type"][value="'+data.type+'"]').prop('checked', true);
            //fill in all the remaining data retrieved
            Object.keys(data).forEach(function (index) {
                //console.log('#property_form input[name="'+ index +'"]');
                $('#property_form input[name="'+ index +'"]').val(data[index]);
            });
        })
        .fail((error) => {
            console.log(error);
        });
    });
});