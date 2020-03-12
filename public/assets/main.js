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
        pageLength : 5,
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
            console.log(extension+' 111');
            if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)
            {
                console.log(extension+' 222');
                alert("Invalid Image File");
                $('#property_image').val('');
                return false;
            }
        }
        console.log("erdhi2");
        $.ajax({
            url:"/crud/property/createUpdate.php",
            method:'POST',
            data:new FormData(this),
            contentType:false,
            processData:false,
            success:function(data)
            {
                console.log(data);
                $('#property_form')[0].reset();
                $('#propertyModal').modal('hide');
                dataTable.ajax.reload();
            }
        });
    });

    $(document).on('click', '.edit', function(){
        var uuid = $(this).attr("id");
        $.ajax({
            url:"/crud/property/readOne.php",
            method:"GET",
            data:{uuid:uuid},
            dataType:"json",
            success:function(data)
            {
                $('#propertyModal').modal('show');
                $('.modal-title').text("Edit property");
                $('#uuid').val(uuid);
                $('#property_uploaded_image').html(data.property_image);
                $('#action').val("Edit");
                $('#operation').val("Edit");
                //fill in all the data retrieved
                Object.keys(data).forEach(function (index) {
                    //console.log('#property_form input[name="'+ index +'"]');
                    $('#property_form input[name="'+ index +'"]').val(data[index]);
                });
            }
        })
    });
});