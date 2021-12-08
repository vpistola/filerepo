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
        //console.log(selectedFiles);
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

        // var form = $('#fileUploadForm')[0];
        // console.log(form);
        // var form_data = new FormData(form);

        // //var form_data = new FormData();
        // var ins = document.getElementById('formFileMultiple').files.length;
        // //console.log(ins);
        // for (var x = 0; x < ins; x++) {
        //     form_data.append("files[]", document.getElementById('formFileMultiple').files[x]);
        // }

        var json_data = JSON.stringify(fileList.join(";"));

        var action = 'upload'; 
        var title = $('#title').val();
        var desc = $('#desc').val();
        var threedurl1 = $('#3durl1').val();
        var threedurl2 = $('#3durl2').val();
        var additionalinfourl = $('#additionalinfourl').val();
        var option1 = $('#option1').val();
        var option2 = $('#option2').val();
        var formFileMultiple = json_data;
    
        var fdata = {
            action: action,
            title: title,
            desc: desc,
            threedurl1: threedurl1,
            threedurl2: threedurl2,
            additionalinfourl: additionalinfourl,
            option1: option1,
            option2: option2,
            formFileMultiple: formFileMultiple
        };
        //form_data.append("action", action);
        // form_data.append("title", title);
        // form_data.append("desc", desc);
        // form_data.append("threedurl", threedurl);
        // form_data.append("additionalinfourl", additionalinfourl);
        // form_data.append("option1", option1);
        // form_data.append("option2", option2);
        // form_data.append("formFileMultiple", formFileMultiple);
    
        console.log(fdata);
        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: "./actions2.php",
            data: fdata,
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

    function populate_filelist() {
        const selectedFiles = document.getElementById('formFileMultiple').files;
        //console.log(selectedFiles);
        var filelist = $('#filelist');
        var html = 'Selected Files : ' + "<br/>";
        for(let i = 0; i < selectedFiles.length; i++) {
            el = selectedFiles[i];
            html += (i + 1) + ". " + el.name + "<br/>";
        }
        filelist.html(html);
        filelist.css('font-size', '14px');
        filelist.css('font-weight', 'bold');
        filelist.css('font-style', 'italic');
    }

    $('#formFileMultiple').on('change', function() {
        populate_filelist();
    });

});