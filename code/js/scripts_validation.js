/*
 * Author: Evangelos Pistolas
 * Date: 05/11/2021 
 * Use this file to add JavaScript to your project
 */

//Disabling autoDiscover
//Dropzone.autoDiscover = false;


const title1 = 'title';
const desc = 'desc';
const threedurl1 = '3durl1';
const threedurl2 = '3durl2';
const additionalinfourl = 'additionalinfourl';
const option1 = 'option1';
const option2 = 'option2';

const title1Error = 'title_error';
const descError = 'desc_error';
// const threedurl1Error = document.querySelector('#3durl1 + span.error');
// const threedurl2Error = document.querySelector('#3durl2 + span.error');
const threedurl1Error = 'threedurl1_error';
const threedurl2Error = 'threedurl2_error';
const additionalinfourlError = 'additionalinfourl_error';
const option1Error = 'option1_error';
const option2Error = 'option2_error';

const elementsMap = new Map();
elementsMap.set(title1, title1Error);
elementsMap.set(desc, descError);
elementsMap.set(threedurl1, threedurl1Error);
elementsMap.set(threedurl2, threedurl2Error);
elementsMap.set(additionalinfourl, additionalinfourlError);
elementsMap.set(option1, option1Error);
elementsMap.set(option2, option2Error);



function buildEventListeners(el, elError) {
    // var e1 = "'#" + el + "'";
    // var e2 = "'#" + elError  + "'";
    var element = document.getElementById(el);
    var elementError = document.getElementById(elError);
    element.addEventListener('input', function (event) {
        // Each time the user types something, we check if the
        // form fields are valid.
        if (element.validity.valid) {
            // In case there is an error message visible, if the field
            // is valid, we remove the error message.
            elementError.textContent = ''; // Reset the content of the message
            elementError.className = 'error'; // Reset the visual state of the message
        } else {
            // If there is still an error, show the correct error
            showError(element, elementError);
        }
    });
}


function onFormSubmission(el, elError) {
    var element = document.getElementById(el);
    var elementError = document.getElementById(elError);
    // if the title field isn't valid, we don't let the form submit
    if(!element.validity.valid) {
        // If it isn't, we display an appropriate error message
        showError(element, elementError);
        // Then we prevent the form from being sent by canceling the event
        // e.preventDefault();
        
        // on error, return false
        return false;
    }
    // on success, return true
    return true;
}


function showError(element, elementError) {
    if(element.validity.valueMissing) {
        // If the field is empty,
        // display the following error message.
        elementError.textContent = 'You need to fill the input field.';
    }
    // Set the styling appropriately
    elementError.className = 'error active';
}   


$(function() {

    //check_validation();
    var url = window.location.pathname;
    var index = url.indexOf('index'); 
    var grid = url.indexOf('grid'); 
    var upload = url.indexOf('upload'); 
    
    if (index >= 0) {
        $("#home-nav").addClass("active");
    } else if (grid >= 0) {
        $("#grid-nav").addClass("active");
    } else if (upload >= 0) {
        $("#upload-nav").addClass("active");
    }
    
    var fileList = [];
    var files = [];
    const validFileTypes = ['image/gif', 'image/jpeg', 'image/png', 'application/pdf', 'application/msword',
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];

    for (const [key, value] of elementsMap) {
        buildEventListeners(key, value);
    }


    $('#example').DataTable({responsive: true});
    $('#modal_close').on('click', function() {
        $('#modal').modal('hide');
    })



    $('#upload').click(function(e) {
        //e.preventDefault();
        var attached_descriptions = [];
        
        for (const [key, value] of elementsMap) {
            if (!onFormSubmission(key, value)) {
                return;
            }
        }
       

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


        var action = 'upload'; 
        //var id = $('#recordid').val();
        var title = $('#title').val();
        var desc = $('#desc').val();
        var threedurl1 = $('#3durl1').val();
        var threedurl2 = $('#3durl2').val();
        var additionalinfourl = $('#additionalinfourl').val();
        var option1 = $('#option1').val();
        var option2 = $('#option2').val();

        var file_data = $('#formFileMultiple').prop('files');
        var form_data = new FormData();

        for (const el of file_data) {
            form_data.append('files[]', el);    
        }

        form_data.append('action', action);
        form_data.append('title', title);
        form_data.append('desc', desc);
        form_data.append('threedurl1', threedurl1);
        form_data.append('threedurl2', threedurl2);
        form_data.append('additionalinfourl', additionalinfourl);
        form_data.append('option1', option1);
        form_data.append('option2', option2);
    
        var num_of_files = file_data.length;
        for(let i = 0; i < num_of_files; i++) {
            var desc = $('#desc' + i).val();
            form_data.append('desc' + (i+1), desc);
        }
        
        $.ajax({
            url: './base_controller.php',
            //dataType: 'text',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,                         
            type: 'post',
            success: function(response){
                console.log(response)
            },
            error: function(e) {
                //$("#err").html(e).fadeIn();
                console.error(e);
            }   
        });


    });



    $(document).on('submit','#formid', function(event){
		event.preventDefault();
		$('#save').attr('disabled','disabled');
		var formData = $(this).serialize();
        console.log(formData);
		$.ajax({
			url:"./base_controller.php",
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
			url:'./base_controller.php',
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
				url:"./base_controller.php",
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
            var desc_input = "<div class='form-inline col-md-6' style='margin-bottom: 10px'>" +
                "<label class='form-label'>Please write a description for the above file</label>" +
                "<input type='text' class='form-control' id='desc" + i + "' name='desc" + i + "'>" + 
                "</div>";
            el = selectedFiles[i];
            html += (i + 1) + ". " + el.name + desc_input + "<br/>";
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