
jQuery.noConflict();
jQuery(document).ready(function ($) {
    var action = "load";

    function load_table() {
        $.ajax({
            url: "../controller/controllerCategory.php",
            type: "post",
            data: { action: action },// Pass as an object with key-value pair
            success: function (result) {
                var data = JSON.parse(result);
                if (data['status'] === "success") {
                    // Insert the HTML table into the DOM
                    $("#tableContainer").html(data['table']);  // Assuming you have a div with id 'tableContainer'
                } else {
                    // Handle error if needed
                    console.error(result.message);
                }
            }
        });
    }
    load_table();

    $(document).ready(function () {
        const fields = [
            { id: '#Category_name', errorMsg: 'Category Name', isPatternRequired: true },
            { id: '#Category_description', errorMsg: 'Category Description', isPatternRequired: true },
        ];
        const namePattern = /^[A-Za-z\s.,!?'"()\-]+$/;  // Pattern for fields that only allow letters
        fields.forEach(field => {
            $(field.id).on('input', function () {
                let formIsValid = true;
                let fieldValue = $(this).val().trim();
                // Apply uppercase transformation for all fields (except phone and zip)
                // $(this).val($(this).val().toUpperCase());
                // Clear previous error message
                $(field.id + '_error').text('');
                // Check if the field is empty
                if (!fieldValue) {
                    formIsValid = false;
                    $(field.id + '_error').text(field.errorMsg + ' is required.');
                }
                // Check if the field requires alphabetic validation
                if (field.isPatternRequired && !namePattern.test(fieldValue)) {
                    formIsValid = false;
                    $(field.id + '_error').text(field.errorMsg + ' should only contain letters.');
                    $(this).val(''); // Optionally clear the value
                }
                // Show or hide error message based on validation
                if (formIsValid) {
                    $(field.id + '_error').text('');  // Clear error if valid
                }
            });
        });
    });

    // $("#category").on("submit", function(e){
    $("#category").on('click', '#btnSave', function (e) {
        e.preventDefault();
        // var formData = new FormData(this);
        var formData = new FormData($('#category')[0]);
        formData.append("action", "submit");
        $.ajax({
            url: "../controller/controllerCategory.php",
            type: "post",
            data: formData,
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            success: function (result) {
                if (result.status === "success") {
                    // Apply text-success class for success message
                    $("#msg").removeClass('text-danger').addClass('text-success');
                    $("#msg").html(result.message);
                    setTimeout(function () {
                        $("#msg").html(''); // Clear the message
                        $("#category")[0].reset();
                        load_table();
                    }, 1000);
                } else {
                    // Apply text-danger class for error message
                    $("#msg").removeClass('text-success').addClass('text-danger');
                    // Handling error in a user-friendly way
                    let errorMessage = "An error occurred. Please try again later.";
                    // Display the error message
                    $("#msg").html(errorMessage);
                }
            },
            error: function (xhr, status, error) {
                console.log('AJAX Error:', status, error);
                // Apply text-danger class for error message
                $("#msg").removeClass('text-success').addClass('text-danger');
                $("#msg").html("Request failed. Please try again.");
                setTimeout(function () {
                    $("#msg").html(''); // Clear the message
                    // $("#viewUserProfile")[0].reset();
                }, 1000);
            }
        });
    });

    $("#category").on('click', '#btnUpdate', function (e) {
        e.preventDefault();
        // var formData = new FormData(this);
        var formData = new FormData($('#category')[0]);
        formData.append("action", "update");
        $.ajax({
            url: "../controller/controllerCategory.php",
            type: "post",
            data: formData,
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            success: function (result) {
                if (result.status === "success") {
                    // Apply text-success class for success message
                    $("#msg").removeClass('text-danger').addClass('text-success');
                    $("#msg").html(result.message);
                    $('#desgid').val(""); // Assuming you have a dropdown or input field for status
                    $('#btnUpdate').text("Save");
                    $('#btnUpdate').attr('name', "btnSave");
                    $('#btnUpdate').attr('id', "btnSave");
                    setTimeout(function () {
                        $("#msg").html(''); // Clear the message
                        $("#category")[0].reset();
                        load_table();
                    }, 1000);
                } else {
                    // Apply text-danger class for error message
                    $("#msg").removeClass('text-success').addClass('text-danger');
                    // Handling error in a user-friendly way
                    let errorMessage = "An error occurred. Please try again later.";
                    // Display the error message
                    $("#msg").html(errorMessage);
                }
            },
            error: function (xhr, status, error) {
                console.log('AJAX Error:', status, error);
                // Apply text-danger class for error message
                $("#msg").removeClass('text-success').addClass('text-danger');
                $("#msg").html("Request failed. Please try again.");
                setTimeout(function () {
                    $("#msg").html(''); // Clear the message
                    // $("#viewUserProfile")[0].reset();
                }, 1000);
            }
        });
    });



    $(document).on('click', '#status', function () {
        var categoryId = $(this).data('id'); // Get the category id from the data attribute
        toggleStatus(categoryId);
    });

    function toggleStatus(categoryId) {
        var statusButton = $('button[data-id="' + categoryId + '"]');
        // Send AJAX request to update the status
        $.ajax({
            url: '../controller/controllerCategory.php',  // Path to your PHP script
            method: 'POST',
            data: {
                id: categoryId,
                action: "active",
                status: (statusButton.text().trim() === 'Active' ? 0 : 1) // Toggle status
            },
            success: function (response) {
                var data = JSON.parse(response);
                if (data['status'] == "success") {
                    // Update the button text and class
                    var newStatus = data['newStatus'] == 1 ? 'Active' : 'Inactive';
                    var newClass = data['newStatus'] == 1 ? 'btn-success' : 'btn-warning';
                    // Change the button text and class
                    statusButton.text(newStatus).removeClass('btn-warning btn-success').addClass(newClass);

                } else {
                    alert('Failed to update status.');
                }
            }
        });
    }


    $(document).on('click', '#btnDelete', function () {
        var id = $(this).data('value');
        if (confirm("Are you sure you want to delete this category?")) {
            $.ajax({
                url: '../controller/controllerCategory.php',
                method: 'post',
                data: { 'id': id, 'action': 'delete' },
                success: function (response) {
                    var data = JSON.parse(response);
                    if (data['status'] == "success") {
                        alert("Record deleted successfully");
                        load_table();
                    }
                }
            });
        }
    });


    $(document).on('click', '#btnEdit', function () {
        var id = $(this).data('value');
        $.ajax({
            url: '../controller/controllerCategory.php',
            method: 'post',
            data: { 'id': id, 'action': 'show' },
            success: function (response) {
                var data = JSON.parse(response);
                if (data['status'] == "success") {
                    $('#Category_name').val(data.record.category_name);
                    $('#Category_description').val(data.record.category_description);
                    $('#catid').val(data.record.id); // Assuming you have a dropdown or input field for status
                    $('#btnSave').text("Update");
                    $('#btnSave').attr('name', "btnUpdate");
                    $('#btnSave').attr('id', "btnUpdate");

                } else {
                    alert(data.message);  // Display error message if no data found
                }
            }
        });
    });


});