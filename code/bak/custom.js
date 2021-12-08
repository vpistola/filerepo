/*
 * Author: Evangelos Pistolas
 * Date: 05/11/2021 
 */

//Dropzone Configuration
//Dropzone.autoDiscover = false;

$(function() {

    Dropzone.options.myDropzone = {
        url: 'actions.php',
        autoProcessQueue: false,
        uploadMultiple: true,
        parallelUploads: 5,
        maxFiles: 5,
        maxFilesize: 1,
        acceptedFiles: 'image/*',
        addRemoveLinks: true,
        init: function() {
            dzClosure = this; // Makes sure that 'this' is understood inside the functions below.
    
            // for Dropzone to process the queue (instead of default form behavior):
            document.getElementById("upload").addEventListener("click", function(e) {
                // Make sure that the form isn't actually being sent.
                e.preventDefault();
                e.stopPropagation();
                dzClosure.processQueue();
            });
    
            //send all the form data along with the files:
            this.on("sendingmultiple", function(data, xhr, formData) {
                formData.append("title", jQuery("#title").val());
                formData.append("desc", jQuery("#desc").val());
            });
        }
    }

    var fileList = [];
    var files = [];
    const validFileTypes = ['image/gif', 'image/jpeg', 'image/png', 'application/pdf', 'application/msword',
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];


    $('#upload1').click(function() {
        event.preventDefault();    
        const selectedFiles = document.getElementById('formFileMultiple').files;

        for (var i = 0; i < selectedFiles.length; i++) {
            const file = selectedFiles[i];
            const fileType = file['type'];
            if (validFileTypes.includes(fileType)) {
                fileList.push(selectedFiles[i].name);
                files.push(selectedFiles[i]);
            } else {
                alert("Only .gif, .jpeg, .png, .pdf, .doc and .docx file extensions are permitted..");
            }
        }

        //console.log(JSON.stringify(fileList.join(";")));
        var json_data = JSON.stringify(fileList.join(";"));
        //console.log(files);

        var action = 'upload'; 
        var title = $('#title').val();
        var desc = $('#desc').val();
        var threedurl = $('#3durl').val();
        var additionalinfourl = $('#additionalinfourl').val();
        var option1 = $('#option1').val();
        var option2 = $('#option2').val();
        var formFileMultiple = json_data;
    
        data = { 
            action: action, 
            title: title,
            desc: desc, 
            threedurl: threedurl, 
            additionalinfourl: additionalinfourl,
            option1: option1, 
            option2: option2, 
            formFileMultiple: formFileMultiple
        };
        //console.log(data);
    
        $.ajax({
            type: "POST",
            url: "./actions.php",
            data: data,
            success: function ( response ) {
                console.log(response);
                // toastr.success(
                //     'The upload was successful..',
                //     '',
                //     {
                //         closeButton: true,
                //         timeOut: 1000,
                //         fadeOut: 1000,
                //         onHidden: function () {
                //             window.location.reload();
                //         }
                //     }
                // );
            },
            error: function (response) {
                toastr.error('There was an error in upload..');
                console.error(response);
            }
        });
    });


    $('#upload').click(function() {
        event.preventDefault();    
        const selectedFiles = document.getElementById('formFileMultiple').files;

        for (var i = 0; i < selectedFiles.length; i++) {
            const file = selectedFiles[i];
            const fileType = file['type'];
            if (validFileTypes.includes(fileType)) {
                fileList.push(selectedFiles[i].name);
                files.push(selectedFiles[i]);
            } else {
                alert("Only .gif, .jpeg, .png, .pdf, .doc and .docx file extensions are permitted..");
            }
        }

        var form_data = new FormData();
        var ins = document.getElementById('formFileMultiple').files.length;
        console.log(ins);
        for (var x = 0; x < ins; x++) {
            form_data.append("files[]", document.getElementById('formFileMultiple').files[x]);
        }

        var json_data = JSON.stringify(fileList.join(";"));

        var action = 'upload'; 
        var title = $('#title').val();
        var desc = $('#desc').val();
        var threedurl = $('#3durl').val();
        var additionalinfourl = $('#additionalinfourl').val();
        var option1 = $('#option1').val();
        var option2 = $('#option2').val();
        var formFileMultiple = json_data;
    
        //form_data.append("action", action);
        form_data.append("title", title);
        form_data.append("desc", desc);
        form_data.append("threedurl", threedurl);
        form_data.append("additionalinfourl", additionalinfourl);
        form_data.append("option1", option1);
        form_data.append("option2", option2);
        form_data.append("formFileMultiple", formFileMultiple);
    
        $.ajax({
            type: "POST",
            url: "./actions.php",
            dataType: 'text',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function ( response ) {
                $('#msg').html(response);
            },
            error: function (response) {
                $('#msg').html(response);
            }
        });

    });


});
