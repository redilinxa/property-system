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
            },
            {
                "targets": [ 9 ],
                "render": $.fn.dataTable.render.number( ',', '.', 2, '$' )
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
        var formData = new FormData(this);
        formData.set('price', formData.get('price').replace(/\$|,/g,''));
        var extension = $('#property_image').val().split('.').pop().toLowerCase();
        if(extension != '')
        {
            if(jQuery.inArray(extension, ['png','jpg','jpeg']) == -1)
            {
                alert("Invalid Image File. Please choose one of the following: 'png','jpg','jpeg'.");
                $('#property_image').val('');
                return false;
            }
        }
        $.ajax({
            url:"/crud/property/createUpdate.php",
            method:'POST',
            data:formData,
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
    //validate form
    $("#property_form").validate();

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
            $('#property_form #description').val(data.description);
            $('#property_form input[name="type"][value="'+data.type+'"]').prop('checked', true);
            //fill in all the remaining data retrieved
            Object.keys(data).forEach(function (index) {
                if (index !== 'image_full'){
                    $('#property_form input[name="'+ index +'"]').val(data[index]);
                }
            });
        })
        .fail((error) => {
            console.log(error);
        });
    });
    document.getElementById('property_image').addEventListener('change', fileChange, false);
    // Canvas function to resize the images
    function fileChange(e) {
        document.getElementById('property_image_thumbnail').value = '';
        var file = e.target.files[0];

        if (file.type == "image/jpeg" || file.type == "image/png") {

            var reader = new FileReader();
            reader.onload = function(readerEvent) {

                var image = new Image();
                image.onload = function(imageEvent) {
                    var max_size = 300;
                    var w = image.width;
                    var h = image.height;

                    if (w > h) {
                        if (w > max_size) { h*=max_size/w; w=max_size;}
                    } else{
                        if (h > max_size) { w*=max_size/h; h=max_size;}
                    }

                    var canvas = document.createElement('canvas');
                    canvas.width = w;
                    canvas.height = h;
                    canvas.getContext('2d').drawImage(image, 0, 0, w, h);

                    if (file.type == "image/jpeg") {
                        var dataURL = canvas.toDataURL("image/jpeg", 1.0);
                    } else {
                        var dataURL = canvas.toDataURL("image/png");
                    }
                    document.getElementById('property_image_thumbnail').value = dataURL;
                }
                image.src = readerEvent.target.result;
            }
            reader.readAsDataURL(file);
        } else {
            document.getElementById('inp_file').value = '';
            alert('Please only select images in JPG- or PNG-format.');
        }
    }

    // currency formatter.

    $("input[data-type='currency']").on({
        keyup: function() {
            formatCurrency($(this));
        },
        blur: function() {
            formatCurrency($(this), "blur");
        }
    });


    function formatNumber(n) {
        // format number 1000000 to 1,234,567
        return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    }


    function formatCurrency(input, blur) {
        // appends $ to value, validates decimal side
        // and puts cursor back in right position.

        // get input value
        var input_val = input.val();

        // don't validate empty input
        if (input_val === "") { return; }

        // original length
        var original_len = input_val.length;

        // initial caret position
        var caret_pos = input.prop("selectionStart");

        // check for decimal
        if (input_val.indexOf(".") >= 0) {

            // get position of first decimal
            // this prevents multiple decimals from
            // being entered
            var decimal_pos = input_val.indexOf(".");

            // split number by decimal point
            var left_side = input_val.substring(0, decimal_pos);
            var right_side = input_val.substring(decimal_pos);

            // add commas to left side of number
            left_side = formatNumber(left_side);

            // validate right side
            right_side = formatNumber(right_side);

            // On blur make sure 2 numbers after decimal
            if (blur === "blur") {
                right_side += "00";
            }

            // Limit decimal to only 2 digits
            right_side = right_side.substring(0, 2);

            // join number by .
            input_val = "$" + left_side + "." + right_side;

        } else {
            // no decimal entered
            // add commas to number
            // remove all non-digits
            input_val = formatNumber(input_val);
            input_val = "$" + input_val;

            // final formatting
            if (blur === "blur") {
                input_val += ".00";
            }
        }

        // send updated string to input
        input.val(input_val);

        // put caret back in the right position
        var updated_len = input_val.length;
        caret_pos = updated_len - original_len + caret_pos;
        input[0].setSelectionRange(caret_pos, caret_pos);
    }
});
