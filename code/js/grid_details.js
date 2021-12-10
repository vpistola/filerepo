$(function() {

    $('#example').DataTable({responsive: true});
    var fileList = [];
    var files = [];
    const validFileTypes = ['image/gif', 'image/jpeg', 'image/png', 'application/pdf', 'application/msword',
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];

    $('#add').click(function(){
		$('#modal').modal('show');
		$('#formid')[0].reset();		
		$('.modal-title').html("<i class='fa fa-plus'></i> Προσθήκη Αρχείου");
	});	


    $('#save').click(function(e) {
        e.preventDefault();
        var action = 'save';
        var id = $('#recordid').val();
        var title = $('#title').val();
        var desc = $('#desc').val();
        var threedurl1 = $('#3durl1').val();
        var threedurl2 = $('#3durl2').val();
        var additionalinfourl = $('#additionalinfourl').val();
        var option1 = $('#option1').val();
        var option2 = $('#option2').val();

        data = { 
            action: action, 
            id: id,
            title: title, 
            desc: desc,
            threedurl1: threedurl1, 
            threedurl2: threedurl2, 
            additionalinfourl: additionalinfourl,
            option1: option1, 
            option2: option2
        };

        //console.log(data);

        $.ajax({
            type: "POST",
            url: "./grid_controller.php",
            data: data,
            success: function ( response ) {
                //console.log(response);
                toastr.success(
                    'The insertion was successful..',
                    '',
                    {
                        closeButton: true,
                        timeOut: 1000,
                        fadeOut: 1000,
                        onHidden: function () {
                            window.location.reload();
                        }
                    }
                );
            },
            error: function (response) {
                toastr.error('There was an error in the insertion..');
                console.error(response);
            }
        });

    });



    $(document).on('submit','#formid', function(event){
		event.preventDefault();
		$('#save').attr('disabled','disabled');
		var formData = $(this).serialize();
        console.log(formData);
		$.ajax({
			url:"./grid_controller.php",
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



    $(document).on('click', '.item_update', function(){
		var lineid = $(this).attr("id");
        var action = "fetch_single_line_item";
        $('.modal-title').html("<i class='fa fa-plus'></i> Update Crop Type");
		$.ajax({
			url:'./grid_controller.php',
			method:"POST",
			data:{lineid:lineid, action:action},
			success:function(data){
				console.log(data);
                dt = JSON.parse(data);
                //console.log(dt);
				$('#modal').modal('show');
                $('#lineid').val(dt.Id);
                $('#descr').val(dt.Description);		
				$('#action').val('update_line_item');
				$('#save').val('Update');
			},
            error: function (request, error) {
                console.log(arguments);
                console.log(" Can't do because: " + error);
            }
		})
	});


    $(document).on('click', '.item_delete', function(){
        var id = $(this).attr("id");

        var data = {
            id: id,
            action: "delete_file"
        };

		if(confirm("Are you sure you want to delete this record?")) {
			$.ajax({
				url:"./grid_controller.php",
				method:"POST",
				data: data,
				success:function(data) {
                    //console.log(data);
                    window.location.reload();
				}
			});
		} else {
			return false;
		}

	});	



    
    // $('#upload_from_grid').click(function() {
    //     event.preventDefault();
    //     const selectedFiles = document.getElementById('multiple_file_input').files;
    //     //console.log(selectedFiles);
    //     for (var i = 0; i < selectedFiles.length; i++) {
    //         const file = selectedFiles[i];
    //         const fileType = file['type'];
    //         if (validFileTypes.includes(fileType)) {
    //             fileList.push(selectedFiles[i].name);
    //             files.push(selectedFiles[i]);
    //         } else {
    //             alert("Only .gif, .jpeg, .png, .pdf, .doc and .docx file extensions are permitted..");
    //         }
    //     }

    //     var json_data = JSON.stringify(fileList.join(";"));

    //     var action = 'upload'; 
    //     var recordid = $('#recordid').val();
    //     var formFileMultiple = json_data;
    
    //     var fdata = {
    //         action: action,
    //         recordid: recordid,
    //         formFileMultiple: fileList
    //     };
    
    //     console.log(fdata);
    //     $.ajax({
    //         type: "POST",
    //         enctype: 'multipart/form-data',
    //         url: "./grid_actions.php",
    //         data: fdata,
    //         success: function ( response ) {
    //             //$('#msg').html(response);
    //             console.log(response);
    //             //window.location.reload();
    //         },
    //         error: function (response) {
    //             //$('#msg').html(response);
    //             console.error(response);
    //         }
    //     });

    // });
  


    $('#upld').click(function(e) {
        e.preventDefault();
        
        var id = $('#recordid').val();
        var file_data = $('#multiple_file_input').prop('files');
        var form_data = new FormData();

        for (const el of file_data) {
            form_data.append('files[]', el);    
        }

        form_data.append('recordid', id);
        
        $.ajax({
            url: './grid_upload_controller.php',
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


});