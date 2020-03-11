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
        }).wa
        .fail((error) => {
            console.log(error);
        });
    });

    $('#add_button').click(function(){
        $('#user_form')[0].reset();
        $('.modal-title').text("Add User");
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
    $(document).on('submit', '#user_form', function(event){
        event.preventDefault();
        var firstName = $('#first_name').val();
        var lastName = $('#last_name').val();
        var extension = $('#user_image').val().split('.').pop().toLowerCase();
        if(extension != '')
        {
            if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)
            {
                alert("Invalid Image File");
                $('#user_image').val('');
                return false;
            }
        }
        if(firstName != '' && lastName != '')
        {
            $.ajax({
                url:"insert.php",
                method:'POST',
                data:new FormData(this),
                contentType:false,
                processData:false,
                success:function(data)
                {
                    alert(data);
                    $('#user_form')[0].reset();
                    $('#userModal').modal('hide');
                    dataTable.ajax.reload();
                }
            });
        }
        else
        {
            alert("Both Fields are Required");
        }
    });

    $(document).on('click', '.edit', function(){
        var user_id = $(this).attr("id");
        $.ajax({
            url:"fetch_single.php",
            method:"POST",
            data:{user_id:user_id},
            dataType:"json",
            success:function(data)
            {
                $('#userModal').modal('show');
                $('#first_name').val(data.first_name);
                $('#last_name').val(data.last_name);
                $('.modal-title').text("Edit User");
                $('#user_id').val(user_id);
                $('#user_uploaded_image').html(data.user_image);
                $('#action').val("Edit");
                $('#operation').val("Edit");
            }
        })
    });

    $(document).on('click', '.delete', function(){
        var user_id = $(this).attr("id");
        if(confirm("Are you sure you want to delete this?"))
        {
            $.ajax({
                url:"delete.php",
                method:"POST",
                data:{user_id:user_id},
                success:function(data)
                {
                    alert(data);
                    dataTable.ajax.reload();
                }
            });
        }
        else
        {
            return false;
        }
    });


});