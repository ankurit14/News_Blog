jQuery.noConflict();
jQuery(document).ready(function ($) {
    var action = "load";

    function load_table() {
        $.ajax({
            url: "../controller/controllerPostSetting.php",
            type: "POST",
            data: { action: action }, // Pass action as fetchWordLimits to fetch the limits
            success: function (result) {
                var data = JSON.parse(result);  // Parse the JSON response

                if (data.status === "success") {
                    // Check if there's any data in the result
                    if (data.result && data.result.length > 0) {
                        // Loop through the data array and populate form fields dynamically
                        data.result.forEach(function (item) {
                            var fieldName = item.field_name;
                            var wordLimit = item.word_limit;
                            // Select the input field based on field name and set its placeholder and max words limit
                            switch (fieldName) {
                                case 'Title':
                                    $('#title').val(wordLimit);
                                    $('#title').attr('placeholder', 'Enter the word limit for the title');
                                    $('#title').data('word-limit', wordLimit);
                                    $('#titleWordLimit').text('Max ' + wordLimit + ' words').show(); // Show message
                                    break;
                                case 'Description':
                                    $('#description').val(wordLimit);
                                    $('#description').attr('placeholder', 'Enter the word limit for the description');
                                    $('#description').data('word-limit', wordLimit);
                                    $('#descriptionWordLimit').text('Max ' + wordLimit + ' words').show(); // Show message
                                    break;
                                case 'Short Description':
                                    $('#shortDescription').val(wordLimit);
                                    $('#shortDescription').attr('placeholder', 'Enter the word limit for the short description');
                                    $('#shortDescription').data('word-limit', wordLimit);
                                    $('#shortDescriptionWordLimit').text('Max ' + wordLimit + ' words').show(); // Show message
                                    break;
                                case 'Long Description':
                                    $('#longDescription').val(wordLimit);
                                    $('#longDescription').attr('placeholder', 'Enter the word limit for the long description');
                                    $('#longDescription').data('word-limit', wordLimit);
                                    $('#longDescriptionWordLimit').text('Max ' + wordLimit + ' words').show(); // Show message
                                    break;
                                default:
                                    break;
                            }
                        });
                        // Update button only when there is data
                        $("#btnSave").text("Update");
                        $("#btnSave").attr('name', 'btnUpdate');
                        $("#btnSave").attr('id', 'btnUpdate');
                    } else {
                        // Handle the case where there is no data in the table
                        console.log("No data found to update.");
                        // Optionally, you could reset the button to its original state
                        $("#btnSave").text("Submit");
                        $("#btnSave").attr('name', 'btnSave');
                        $("#btnSave").attr('id', 'btnSave');
                    }
                } else {
                    console.error("Failed to load word limits");
                    // Reset button if the request failed
                    $("#btnSave").text("Submit");
                    $("#btnSave").attr('name', 'btnSave');
                    $("#btnSave").attr('id', 'btnSave');
                }
            },
            error: function (err) {
                console.error("Error in AJAX request:", err);
                // Reset button if there's an error in the request
                $("#btnSave").text("Submit");
                $("#btnSave").attr('name', 'btnSave');
                $("#btnSave").attr('id', 'btnSave');
            }
        });
    }

    // Call the function to populate the form
    $(document).ready(function () {
        load_table();
    });

    $('input[type="text"]').on('input', function () {
        var inputValue = $(this).val();
        // Replace any non-numeric characters with an empty string
        $(this).val(inputValue.replace(/[^0-9]/g, ''));
    });

    // $("#designation").on("submit", function(e){
    $("#postSetting").on('click', '#btnSave', function (e) {
        e.preventDefault();
        let isValid = true;
        // Check if required fields are empty
        $('input[required]').each(function () {
            if ($(this).val().trim() === '') {
                isValid = false;
                $(this).css('border-color', 'red');  // Highlight invalid fields with red border
                // exit;
            } else {
                $(this).css('border-color', '');  // Remove the red border if valid
                // exit;
            }
        });

        if (!isValid) {
            alert('Please fill in all required fields with valid numeric values.');
            exit;
        }
        // var formData = new FormData(this);
        var formData = new FormData($('#postSetting')[0]);
        formData.append("action", "submit");
        $.ajax({
            url: "../controller/controllerPostSetting.php",
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
                        $("#postSetting")[0].reset();
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

    $("#postSetting").on('click', '#btnUpdate', function (e) {
        e.preventDefault();
        // var formData = new FormData(this);
        let isValid = true;
        $('input[required]').each(function () {
            if ($(this).val().trim() === '') {
                isValid = false;
                $(this).css('border-color', 'red');  // Highlight invalid fields with red border
                // exit;
            } else {
                $(this).css('border-color', '');  // Remove the red border if valid
                // exit;
            }
        });

        if (!isValid) {
            alert('Please fill in all required fields with valid numeric values.');
            return;
        }
        var formData = new FormData($('#postSetting')[0]);
        formData.append("action", "update");
        $.ajax({
            url: "../controller/controllerPostSetting.php",
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
                        // $("#postSetting")[0].reset();
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
        var designationId = $(this).data('id'); // Get the designation id from the data attribute
        toggleStatus(designationId);
    });

    function toggleStatus(designationId) {
        var statusButton = $('button[data-id="' + designationId + '"]');

        // Send AJAX request to update the status
        $.ajax({
            url: '../controller/controllerDesignation.php',  // Path to your PHP script
            method: 'POST',
            data: {
                id: designationId,
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
        if (confirm("Are you sure you want to delete this designation?")) {
            $.ajax({
                url: '../controller/controllerDesignation.php',
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
            url: '../controller/controllerDesignation.php',
            method: 'post',
            data: { 'id': id, 'action': 'show' },
            success: function (response) {
                var data = JSON.parse(response);
                if (data['status'] == "success") {
                    $('#designation_name').val(data.record.designation_name);
                    $('#designation_description').val(data.record.designation_description);
                    $('#desgid').val(data.record.id); // Assuming you have a dropdown or input field for status
                    $('#btnSave').text("Update");
                    $('#btnSave').attr('name', "btnUpdate");
                    $('#btnSave').attr('id', "btnUpdate");

                } else {
                    alert(data.message);  // Display error message if no data found
                }
            }
        });
    });

    $(document).ready(function () {
        // Attach a click event listener to the cancel button
        $("#btnCancel").on('click', function (e) {
            e.preventDefault();

            // Optional: Reset the form if needed
            $('#postSetting')[0].reset();  // Reset the form if you're using a form with id 'postSetting'

            // Optional: Redirect to another page (if needed)
            // window.location.href = 'index.php';  // Uncomment and set the desired URL if you want to redirect

            // Example: You can send an AJAX request if required
            $.ajax({
                url: "index.php",  // Your target URL for the AJAX request
                type: "post",       // You can change this to POST if you need to send data
                success: function (response) {
                    console.log("Request successful", response);
                    // Optionally, you can do something with the response here
                },
                error: function (error) {
                    console.error("Error:", error);
                    // Handle error if needed
                }
            });
        });
    });

});