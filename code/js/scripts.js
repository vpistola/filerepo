/*!
* Start Bootstrap - Bare v5.0.7 (https://startbootstrap.com/template/bare)
* Copyright 2013-2021 Start Bootstrap
* Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-bare/blob/master/LICENSE)
*/
// This file is intentionally blank
// Use this file to add JavaScript to your project
/*
 * Author: Evangelos Pistolas
 * Date: 05/11/2021 
 */

//Disabling autoDiscover
//Dropzone.autoDiscover = false;

uploader = $('#uploadFrm');

Dropzone.options.uploadForm = { // The camelized version of the ID of the form element
    url: "actions.php",
    //paramName: "imgs",
    uploadMultiple: true,
    maxFilesize: 10,
    maxFiles: 10,
    acceptedFiles: "image/jpeg,image/jpg,image/png,application/pdf,application/doc,application/docx",
    autoProcessQueue: false,
    addRemoveLinks: true,
  
    // The setting up of the dropzone
    init: function() {
        var myDropzone = this;
  
        //First change the button to actually tell Dropzone to process the queue.
        this.element.querySelector("button[type=submit]").addEventListener("click", function(e) {
            // Make sure that the form isn't actually being sent.
            console.log(uploader);
            e.preventDefault();
            e.stopPropagation();
            myDropzone.processQueue();
        });

        // this.element.querySelector(".upload_images").addEventListener("click", function(e) {
        //     // Make sure that the form isn't actually being sent.
        //     console.log(uploader);
        //     e.preventDefault();
        //     e.stopPropagation();
        //     myDropzone.processQueue();
        // });

        
        // this.element.querySelector(".upload_files").addEventListener("click", function(e) {
        //     // Make sure that the form isn't actually being sent.
        //     console.log(uploader);
        //     e.preventDefault();
        //     e.stopPropagation();
        //     myDropzone.processQueue();
        // });

        // $("button.upload1", uploader).click(
        //     function (e) {
        //         console.log(uploader);
        //         e.preventDefault();
        //         myDropzone.processQueue();
        //     }
        // );
  
        // Listen to the sendingmultiple event. In this case, it's the sendingmultiple event instead
        // of the sending event because uploadMultiple is set to true.
        this.on("sendingmultiple", function() {
        // Gets triggered when the form is actually being sent.
        // Hide the success button or the complete form.
        });

        this.on("successmultiple", function(files, response) {
        // Gets triggered when the files have successfully been sent.
        // Redirect user or notify of success.
        });

        this.on("errormultiple", function(files, response) {
        // Gets triggered when there was an error sending the files.
        // Maybe show form again, and notify user of error
        });

        this.on(
            "success", function (file) {
                //console.log("success > " + file.name);
                //console.log(file);
                //window.location.href = './actions.php';
            }
        );

    }   
}


$(function() {

    var url = window.location.pathname;
    var page = url.indexOf('index'); 

    // page = 1 if index found (index.php visited)
    if (page >= 0) {
        $("#home-nav").addClass("active");
    } else { // page = -1 if editor.php visited
        $("#editor-nav").addClass("active");
    }
    
    var fileList = [];
    var files = [];
    const validFileTypes = ['image/gif', 'image/jpeg', 'image/png', 'application/pdf', 'application/msword',
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];

    $('#example').DataTable({responsive: true});
    $('#modal_close').on('click', function() {
        $('#modal').modal('hide');
    })

    $('#upload').click(function() {
        event.preventDefault();    
        const selectedFiles = document.getElementById('formFileMultiple').files;
        console.log(selectedFiles);
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
                //window.location.reload();
            },
            error: function (response) {
                $('#msg').html(response);
                //console.error(response);
            }
        });

    });


    $(document).on('submit','#formid', function(event){
		event.preventDefault();
		$('#save').attr('disabled','disabled');
		var formData = $(this).serialize();
        console.log(formData);
		$.ajax({
			url:"./actions.php",
			method:"POST",
			data:formData,
			success:function(data){				
				//console.log(data);
                $('#formid')[0].reset();
				$('#modal').modal('hide');				
				$('#save').attr('disabled', false);
                window.location.reload();
			}
		})
	});	


    $(document).on('click', '.update', function(){
		var id = $(this).attr("id");
        var action = "fetchbyid";
        $('.modal-title').html("<i class='fa fa-plus'></i> Update");
		$.ajax({
			url:'./actions.php',
			method:"POST",
			data:{id:id, action:action},
			success:function(data){
				console.log(data);
                dt = JSON.parse(data);
                //console.log(dt[0]);
				$('#modal').modal('show');
                $('#modal_id').val(dt[0].Id);
				$('#modal_title').val(dt[0].Title);
                $('#modal_desc').val(dt[0].Description);	
                $('#modal_3durl1').val(dt[0].Threedurl1);
                $('#modal_3durl2').val(dt[0].Threedurl2);
                $('#modal_additional').val(dt[0].AdditionalInfoUrl);	
                $("#modal_opt1").val(dt[0].Option1);
                $('#modal_opt2').val(dt[0].Option2);
                $('#model_jsondata').val(dt[0].JsonData);	
				//$('.modal-title').html("<i class='fa fa-plus'></i> Edit Task");
				$('#action').val('update');
				$('#save').val('Update');
			},
            error: function (request, error) {
                console.log(arguments);
                console.log(" Can't do because: " + error);
            }
		})
	});	


    $(document).on('click', '.delete', function(){
		var id = $(this).attr("id");		
		var action = "delete";
		if(confirm("Are you sure you want to delete this entry?")) {
			$.ajax({
				url:"./actions.php",
				method:"POST",
				data:{id:id, action:action},
				success:function(data) {	
                    window.location.reload();
				}
			});
		} else {
			return false;
		}
	});	

    //$('#modal').modal('toggle');



});