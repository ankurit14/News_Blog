jQuery.noConflict();
jQuery(document).ready(function($){

    $('#profile_picture').on('change', function(){
        var file = this.files[0]; // Get the selected file
        if (file) {
            var reader = new FileReader(); // Create a new FileReader object
            reader.onload = function(e) {
                $('#profile_image').attr('src', e.target.result); // Set the src attribute of the image with the data URL of the selected file
                $('#profile_image').css('display', 'block');
            };
            reader.readAsDataURL(file); // Read the selected file as a data URL
        }
    });
            
        $(document).ready(function() {
                const fields = [
                    { id: '#first_name', errorMsg: 'First Name', isPatternRequired: true },
                    { id: '#last_name', errorMsg: 'Last Name', isPatternRequired: true },
                    { id: '#city', errorMsg: 'City', isPatternRequired: true },
                    { id: '#state', errorMsg: 'State', isPatternRequired: true },
                    { id: '#country', errorMsg: 'Country', isPatternRequired: true },
                    { id: '#address_line1', errorMsg: 'Address Line 1', isPatternRequired: false },
                    { id: '#address_line2', errorMsg: 'Address Line 2', isPatternRequired: false },
                    { id: '#phone', errorMsg: 'Phone Number', isPatternRequired: false, isPhoneNumber: true },
                    { id: '#zip_code', errorMsg: 'Zip Code', isPatternRequired: false, isNumeric: true }
                ];
            
                const namePattern = /^[A-Za-z\s]+$/;  // Pattern for fields that only allow letters
                const numericPattern = /^[0-9]+$/;  // Pattern for fields that only allow numbers
                const phonePattern = /^\+91\d{10}$/;  // Indian phone number format (+91 followed by 10 digits)
            
                fields.forEach(field => {
                    $(field.id).on('input', function() {
                        let formIsValid = true;
                        let fieldValue = $(this).val().trim();
            
                        // Apply uppercase transformation for all fields (except phone and zip)
                        if (field.id !== "#phone" && field.id !== "#zip_code") {
                            $(this).val($(this).val().toUpperCase());
                        }
            
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
            
                        // Check if the field requires numeric validation
                        if (field.isNumeric && !numericPattern.test(fieldValue)) {
                            formIsValid = false;
                            $(field.id + '_error').text(field.errorMsg + ' should only contain numbers.');
                        }
            
                        // For phone number validation
                        // if (field.isPhoneNumber) {
                        //     // Allow only numeric values for the phone number
                        //     fieldValue = fieldValue.replace(/\D/g, ''); // Remove non-numeric characters
            
                        //     // Handle the formatting of the phone number
                        //     if (fieldValue.length <= 10) {
                        //         // Format phone number as +91 123-456-7890 (only if the input is valid)
                        //         if (fieldValue.length === 10) {
                        //             let formattedPhone = `+91 ${fieldValue.slice(0, 3)}-${fieldValue.slice(3, 6)}-${fieldValue.slice(6, 10)}`;
                        //             $(this).val(formattedPhone); // Set the formatted value in the input
                        //         } else {
                        //             $(this).val(`+91 ${fieldValue.slice(0, 3)}-${fieldValue.slice(3, 6)}-${fieldValue.slice(6, 10)}`.slice(0, fieldValue.length + 4));
                        //         }
                        //     }
                        //     // If the user types more than 10 digits, prevent additional input
                        //     if (fieldValue.length > 10) {
                        //         formIsValid = false;
                        //         $(field.id + '_error').text('Phone number must contain exactly 10 digits.');
                        //     }
                        // }
            
                        // Show or hide error message based on validation
                        if (formIsValid) {
                            $(field.id + '_error').text('');  // Clear error if valid
                        }
            
                    });
                });



                
            });

    $("#viewUserProfile").on("submit",function(e){
        e.preventDefault();
        var formDate = new FormData(this);
        formDate.append('action','submit');
        $.ajax({
            url: "../controller/controllerUserProfile.php",
            type: "post",
            data: formDate,
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            success: function(result) {
                // var data = JSON.parse(result);
                if (result.status === "success") {
                    // Apply text-success class for success message
                    $("#msg").removeClass('text-danger').addClass('text-success');
                    $("#msg").html(result.message);
                    setTimeout(function() {
                        $("#msg").html(''); // Clear the message
                        $('#profile_image').css('display', 'none');
                        $("#viewUserProfile")[0].reset();
                    }, 3000);
                } else {
                    // Apply text-danger class for error message
                    $("#msg").removeClass('text-success').addClass('text-danger');
                    
                    // Handling error in a user-friendly way
                    let errorMessage = "An error occurred. Please try again later.";
    
                    if (result.message.includes("Duplicate entry") && result.message.includes("email")) {
                        errorMessage = "This email address is already registered. Please use a different email.";
                    } else if (result.message.includes("Duplicate entry") && result.message.includes("username")) {
                        errorMessage = "This username is already taken. Please choose a different username.";
                    }
    
                    // Display the error message
                    $("#msg").html(errorMessage);
                  
                }
            },
            error: function(xhr, status, error) {
                console.log('AJAX Error:', status, error);
                // Apply text-danger class for error message
                $("#msg").removeClass('text-success').addClass('text-danger');
                $("#msg").html("Request failed. Please try again.");
                setTimeout(function() {
                    $("#msg").html(''); // Clear the message
                    // $("#viewUserProfile")[0].reset();
                }, 3000);
            }
        });
});
    
});