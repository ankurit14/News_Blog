jQuery.noConflict();
jQuery(document).ready(function($){

var action = "loadtag";
function load_tags() {
    $.ajax({
        url: "../controller/newPostController.php",
        type: "post",
        data: { action: action },// Pass as an object with key-value pair
        success: function(result) {
            var data = JSON.parse(result);
            if (data['status'] === "success") {
                // Insert the HTML table into the DOM
                $("#tag").html(data['table']);  // Assuming you have a div with id 'tableContainer'
            } else {
                // Handle error if needed
                console.error(result.message);
            }
        }
    });
}
load_tags();

    // Initial word limits object
    let wordLimits = {};
    let shortDescription_limt = 0;
    let longDescription_limit = 0;

    // Function to fetch word limits from the server
    function fetchWordLimits() {
        $.ajax({
            url: '../controller/newPostController.php', // URL to your PHP script
            type: 'post',
            data: {action:'fetchlimit'},
            success: function(response) {
                var result = JSON.parse(response);
                if (result.status === 'success') {
                    wordLimits = result.data; // Update wordLimits with the data from the server

                    // Now you can call the function to update word counts for fields
                    updateWordCount($('#title'), wordLimits['Title']);
                    updateWordCount($('#description'), wordLimits['Description']);
                    shortDescription_limt = wordLimits['Short Description'];
                    longDescription_limit = wordLimits['Long Description'];
                    updateWordCount($('#shortDescription'), wordLimits['Short Description']);
                    updateWordCount($('#longDescription'), wordLimits['Long Description']);
                } else {
                    console.error("Failed to load word limits");
                }
            },
            error: function(xhr, status, error) {
                console.error("Error loading word limits: " + error);
            }
        });
    }

    // Function to update word count and remaining words
    function updateWordCount(inputField, limit) {
        const words = inputField.val().trim().split(/\s+/).filter(function(word) {
            return word.length > 0; // Filter out empty entries
        });
        
        const wordCount = words.length;
        const remainingWords = limit - wordCount;

        // Debugging line: Check if the word count is being calculated
        console.log("Current word count for " + inputField.attr('id') + ": ", wordCount);

        // Update the word count display
        const wordCountDisplay = inputField.next('.form-text');
        wordCountDisplay.text('Words: ' + wordCount + '/' + limit);

        // If the word count exceeds the limit, truncate the text
        if (wordCount > limit) {
            inputField.val(words.slice(0, limit).join(" "));
            wordCountDisplay.text('Words: ' + limit + '/' + limit); // Show max word limit
            wordCountDisplay.addClass('word-limit-exceeded');
        }else {
            wordCountDisplay.removeClass('word-limit-exceeded');
        }
    }

    // Fetch word limits when the page loads
    
   
	// tinymce.init({
    //     // General options
    //     selector: '#shortDescription, #longDescription', // Apply TinyMCE to specific textareas
    //     theme: "advanced",
    //     plugins: "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks",
    
    //     // Theme options
    //     theme_advanced_buttons1: "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
    //     theme_advanced_buttons2: "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
    //     theme_advanced_buttons3: "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
    //     theme_advanced_buttons4: "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft,visualblocks",
    //     theme_advanced_toolbar_location: "top",
    //     theme_advanced_toolbar_align: "left",
    //     theme_advanced_statusbar_location: "bottom",
    //     theme_advanced_resizing: true,
    
    //     // Example content CSS (should be your site CSS)
    //     content_css: "css/content.css",
    //     content_style: "body { font-size: 18pt; font-family: Georgia; }",
    
    //     // Drop lists for link/image/media/template dialogs
    //     template_external_list_url: "lists/template_list.js",
    //     external_link_list_url: "lists/link_list.js",
    //     external_image_list_url: "lists/image_list.js",
    //     media_external_list_url: "lists/media_list.js",
    
    //     // Style formats
    //     style_formats: [
    //         { title: 'Bold text', inline: 'b' },
    //         { title: 'Red text', inline: 'span', styles: { color: '#ff0000' } },
    //         { title: 'Red header', block: 'h1', styles: { color: '#ff0000' } },
    //         { title: 'Example 1', inline: 'span', classes: 'example1' },
    //         { title: 'Example 2', inline: 'span', classes: 'example2' },
    //         { title: 'Table styles' },
    //         { title: 'Table row 1', selector: 'tr', classes: 'tablerow1' }
    //     ],
    
    //     content_style: "body {font-size: 18pt;}",
    
    //     // File picker callback for custom file selection
    //     file_picker_callback: function(callback, value, meta) {
    //         // Create file input element
    //         var input = document.createElement('input');
    //         input.setAttribute('type', 'file');
    //         input.setAttribute('accept', 'image/*');  // Restrict to image files
    //         input.click();
    
    //         // Handle file selection
    //         input.onchange = function() {
    //             var file = input.files[0];  // Get the selected file
    //             var reader = new FileReader();  // Read the file
    //             reader.onload = function(e) {
    //                 callback(e.target.result, {
    //                     alt: file.name  // Add alt text for the image (optional)
    //                 });
    //             };
    //             reader.readAsDataURL(file);  // Read the image as Data URL
    //         };
    //     },
    
    //     // Replace values for the template plugin
    //     template_replace_values: {
    //         username: "Some User",
    //         staffid: "991234"
    //     }
    // });
    
    tinymce.init({
        selector: '#shortDescription, #longDescription', // Apply to both fields
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
        menubar: false,
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        setup: function(editor) {
            // When the user types in the editor, update word count
            editor.on('input', function() {
                if (editor.id === 'shortDescription') {
                    updateWordCount2(editor, 'shortDescription', shortDescription_limt);
                } else if (editor.id === 'longDescription') {
                    updateWordCount2(editor, 'longDescription', longDescription_limit);
                }
            });
        },
        file_picker_callback: function(callback, value, meta) {
            var input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');
            input.click();
            input.onchange = function() {
                var file = input.files[0];
                var reader = new FileReader();
                reader.onload = function(e) {
                    callback(e.target.result, {
                        alt: file.name
                    });
                };
                reader.readAsDataURL(file);
            };
        }
    });


    function updateWordCount2(editor, fieldId, limit) {
        // Get the plain text content from the editor
        const content = editor.getContent({ format: 'text' }).trim();
        const words = content.split(/\s+/).filter(function(word) {
            return word.length > 0; // Filter out empty entries
        });
    
        const wordCount = words.length;
        const remainingWords = limit - wordCount;
    
        // Get the word limit display element
        const wordCountDisplay = $('#' + fieldId + 'WordLimit');
    
        // Update the word count display dynamically
        wordCountDisplay.text('Words: ' + wordCount + '/' + limit);
    
        // If the word count exceeds the limit, truncate the text
        if (wordCount > limit) {
            // Truncate the text to the limit and set it back to the editor
            const truncatedText = words.slice(0, limit).join(" ");
            editor.setContent(truncatedText);  // Truncate content in editor
    
            // Apply the "word-limit-exceeded" class to make it red and bold
            wordCountDisplay.addClass('word-limit-exceeded');  // Add red and bold styling
    
            // Update word count to show the maximum limit
            wordCountDisplay.text('Words: ' + limit + '/' + limit); // Show max word limit
        } else {
            // Remove the "word-limit-exceeded" class if word count is within the limit
            wordCountDisplay.removeClass('word-limit-exceeded');
        }
    }
    
    fetchWordLimits();

    // Attach event handlers to the input fields
    $('#title').on('input', function() {
        updateWordCount($(this), wordLimits['Title']);
    });

    $('#description').on('input', function() {
        updateWordCount($(this), wordLimits['Description']);
    });

    $('#shortDescription').on('input', function() {
        updateWordCount($(this), wordLimits['Short Description']);
    });

    $('#longDescription').on('input', function() {
        updateWordCount($(this), wordLimits['Long Description']);
    });

    // Prevent form submission if required fields are not filled (if needed)
    
    // Function to check the word limit on input
    
    $('input[type="file"]').on('change', function() {
        var file = this.files[0]; // Get the selected file
        var imageId = $(this).next('img'); // Get the corresponding image element
        if (file) {
            var reader = new FileReader(); // Create a new FileReader object
            reader.onload = function(e) {
                imageId.attr('src', e.target.result); // Set the src attribute of the image
                imageId.css('display', 'block'); // Show the image
            };
            reader.readAsDataURL(file); // Read the selected file as a data URL
        }
    });


            
    $('#newPost').on('click','#btnSave', function(e) {
        e.preventDefault();
        let isValid = true;

        $('input[required]').each(function() {
            if ($(this).val().trim() === '') {
                isValid = false;
                $(this).css('border-color', 'red');  // Highlight invalid fields with red border
            } else {
                $(this).css('border-color', '');  // Remove the red border if valid
            }
        });

        if (!isValid) {
            alert('Please fill in all required fields.');
            e.preventDefault();
        }
        var shortDescription = tinymce.get('shortDescription').getContent();  // Get content of TinyMCE editor
        var longDescription = tinymce.get('longDescription').getContent(); 
        var formDate = new FormData($('#newPost')[0]);
        formDate.append('shortDescription',shortDescription);
        formDate.append('longDescription',longDescription);
        formDate.append('action','submit');
        $.ajax({
            url: "../controller/newPostController.php",
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
                        $('#tag').val([]).trigger('change'); 
                        $("#newPost")[0].reset();
                        $('#post_image').css('display', 'none');
                        $('#facebook_image').css('display', 'none');
                        $('#instagram_image').css('display', 'none');
                        $('#whatsapp_image').css('display', 'none');
                        $('#datetime-container').css('display', 'none');

                    }, 3000);
                } else {
                    // Apply text-danger class for error message
                    $("#msg").removeClass('text-success').addClass('text-danger');
                    $("#msg").html(result.message);
                    
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





$('#editPost').on('click','#btnUpdate', function(e) {
    e.preventDefault();
    let isValid = true;
    $('input[required]').each(function() {
        if ($(this).val().trim() === '') {
            isValid = false;
            $(this).css('border-color', 'red');  // Highlight invalid fields with red border
        } else {
            $(this).css('border-color', '');  // Remove the red border if valid
        }
    });
    if (!isValid) {
        alert('Please fill in all required fields.');
        e.preventDefault();
    }
    var shortDescription = tinymce.get('shortDescription').getContent();  // Get content of TinyMCE editor
    var longDescription = tinymce.get('longDescription').getContent(); 
    var formData = new FormData($('#editPost')[0]);
    formData.append('shortDescription',shortDescription);
    formData.append('longDescription',longDescription);
    formData.append('action','update');
    var postImage = $('#postImage')[0].files[0];
    if (postImage) {
        formData.append('postImage', postImage);  // Append the selected postImage file
    } else {
        // If no new file is selected, you can optionally append the old file name here
        var oldPostImage = $('#post_image').attr('src').split('/').pop();
        formData.append('postImage', oldPostImage);  // Append the old post image name
    }

    // Check facebookImage
    var facebookImage = $('#facebookImage')[0].files[0];
    if (facebookImage) {
        formData.append('facebookImage', facebookImage);  // Append the selected facebookImage file
    } else {
        var oldFacebookImage = $('#facebook_image').attr('src').split('/').pop();
        formData.append('facebookImage', oldFacebookImage);  // Append the old facebook image name
    }

    // Check instagramImage
    var instagramImage = $('#instagramImage')[0].files[0];
    if (instagramImage) {
        formData.append('instagramImage', instagramImage);  // Append the selected instagramImage file
    } else {
        var oldInstagramImage = $('#instagram_image').attr('src').split('/').pop();
        formData.append('instagramImage', oldInstagramImage);  // Append the old instagram image name
    }

    // Check whatsappImage
    var whatsappImage = $('#whatsappImage')[0].files[0];
    if (whatsappImage) {
        formData.append('whatsappImage', whatsappImage);  // Append the selected whatsappImage file
    } else {
        var oldWhatsappImage = $('#whatsapp_image').attr('src').split('/').pop();
        formData.append('whatsappImage', oldWhatsappImage);  // Append the old whatsapp image name
    }

    $.ajax({
        url: "../controller/newPostController.php",
        type: "post",
        data: formData,
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
                    $('#tag').val([]).trigger('change'); // Reset tag selection
                    $("#editPost")[0].reset(); // Reset the form
                    tinymce.get('shortDescription').setContent(''); // Clear TinyMCE content
                    tinymce.get('longDescription').setContent(''); // Clear TinyMCE content
    
                    // Hide the image previews
                    $('#post_image').css('display', 'none');
                    $('#facebook_image').css('display', 'none');
                    $('#instagram_image').css('display', 'none');
                    $('#whatsapp_image').css('display', 'none');
    
                    // Hide the datetime container if scheduled is not selected
                    $('#datetime-container').css('display', 'none');
    
                    // Redirect to viewPostList.php after a successful update
                    window.location.href = "viewPostList.php"; 
                }, 3000);
            } else {
                // Apply text-danger class for error message
                $("#msg").removeClass('text-success').addClass('text-danger');
                $("#msg").html(result.message);
                
            }
        }
        // error: function(xhr, status, error) {
        //     console.log('AJAX Error:', status, error);
        //     // Apply text-danger class for error message
        //     $("#msg").removeClass('text-success').addClass('text-danger');
        //     $("#msg").html("Request failed. Please try again.");
        //     setTimeout(function() {
        //         $("#msg").html(''); // Clear the message
        //         // $("#viewUserProfile")[0].reset();
        //     }, 3000);
        // }
    });
});
   

});  
