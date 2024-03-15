<?php
$eml = $_SESSION["eml"];
include 'pages/view/config/dbconfig.php';
$sql = "SELECT * FROM user_details WHERE eml = '$eml'";
$result = mysqli_query($conn, $sql);
$user_details = mysqli_fetch_assoc($result);
$profile_pic = $user_details["profile_pic"];
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
?>
<!DOCTYPE html>
<html>
	<head>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>        
		<link rel="stylesheet" href="https://unpkg.com/dropzone/dist/dropzone.css" />
		<link href="assets/css/cropper.css" rel="stylesheet"/>
		<script src="https://unpkg.com/dropzone"></script>
		<script src="https://unpkg.com/cropperjs"></script>
		
		<style>

		.image_area {
		  position: relative;
		  max-width: 50%;
		  
		}

		img {
		  	display: block;
		  	max-width: 100%;
		}
		
		.img-circle{
		    
		  border-radius: 50%;
		}

		.preview {
  			overflow: hidden;
  			width: 160px; 
  			height: 160px;
  			margin: 10px;
  			border: 1px solid red;
		}

		.modal-lg{
  			max-width: 1000px !important;
		}

		.overlay {
		  position: absolute;
		  bottom: 10px;
		  left: 0;
		  right: 0;
		  background-color: rgba(255, 255, 255, 0.5);
		  overflow: hidden;
		  height: 0;
		  transition: .5s ease;
		  width: 100%;
		}

		.image_area:hover .overlay {
		  height: 50%;
		  cursor: pointer;
		  
		}
		
		.cropper-container{
		    width:100%;
		}

		.text {
		  position: absolute;
		  top: 50%;
		  left: 50%;
		  -webkit-transform: translate(-50%, -50%);
		  -ms-transform: translate(-50%, -50%);
		  transform: translate(-50%, -50%);
		  text-align: center;
		}
		
		.img-container{
		    overflow: hidden;
		}
		
		</style>

	    <div class="page-header">
          <h3 class="page-title">
            <span class="page-title-icon bg-primary text-white me-2">
              <i class="mdi mdi-account-multiple-plus"></i>
            </span> Profile Picture
          </h3>
          <nav aria-label="breadcrumb">
            <!-- <ul class="breadcrumb">
              <li class="breadcrumb-item active" aria-current="page">
                <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
              </li>
            </ul> -->
            <button onclick="location.href = '../RHU/';" class="btn btn-info btn-rounded btn-icon">
              <i class="mdi mdi-close"></i>
            </button>
          </nav>
        </div>

			<div class="row">
				<div class="col-md-4">
					<div class="image_area">
						<form method="post">
							<label for="upload_image">
								<img id="prof_pic" src="assets/images/pp/<?php echo $profile_pic;?>" id="uploaded_image" class="img-responsive img-circle" />
								<div class="overlay">
								    <h6 class="font-weight-light text-center text" ><i class="mdi mdi-pencil"></i> Edit Profile Image</h6>
								</div>
			    				<input type="file" name="image" class="image" id="upload_image" style="display:none">
			    			</label>
			    		</form>
			    	</div>
			    </div>
    		<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
			  	<div class="modal-dialog modal-lg" role="document">
			    	<div class="modal-content">
			      		<div class="modal-header">
			        		<div class="display-5 text-center"><i class="mdi mdi-crop-free"></i> Crop Photo</div>
			          	
			        		</button>
			      		</div>
			      		<div class="modal-body">
			        		<div class="img-container">
			            		<div class="row">
			                		<div class="col-md-8">
			                    		<img src="" id="sample_image" />
			                		</div>
			                		<div class="col-md-4">
			                    		<div class="preview" ></div>
			                		</div>
			            		</div>
			        		</div>
			      		</div>
			      		<div class="modal-footer">
			        		<button type="button" class="btn btn-info" id="crop">Crop</button>
			      		</div>
			    	</div>
			  	</div>
			</div>			
		</div>
		
		
<script>

$(document).ready(function(){


	
	var $modal = $('#modal');
	var image = document.getElementById('sample_image');
	var cropper;

	$('#upload_image').change(function(event){
    	var files = event.target.files;
    	var done = function (url) {
      		image.src = url;
      		$modal.modal('show');
    	};


    	if (files && files.length > 0)
    	{
      	
        		reader = new FileReader();
		        reader.onload = function (event) {
		          	done(reader.result);
		        };
        		reader.readAsDataURL(files[0]);

    	}
	});

	$modal.on('shown.bs.modal', function() {
    	cropper = new Cropper(image, {
    		aspectRatio: 1,
    		viewMode: 3,
    		preview: '.preview'
    	});
	}).on('hidden.bs.modal', function() {
   		cropper.destroy();
   		cropper = null;
	});

	$("#crop").click(function(){
    	canvas = cropper.getCroppedCanvas({
      		width: 400,
      		height: 400,
    	});

    	canvas.toBlob(function(blob) {

        	var reader = new FileReader();
         	reader.readAsDataURL(blob); 
         	reader.onloadend = function() {
            	var base64data = reader.result;  
            
            	$.ajax({
            		url: "upload.php",
                	method: "POST",                	
                	data: {image: base64data},
                	success: function(data){
                    	console.log(data);
                    	$modal.modal('hide');
                    	$('#uploaded_image').attr('src', data);
                    // 	alert("success upload image");
                        window.top.location.href='../RHU/?p=uploadpp';
                	}
              	});
         	}
    	});
    });
	
});


</script>

<!--Php cropper js example, Php crop image before upload, crop image using cropper.js Php, Php crop image before upload cropper.js, cropper js Php example, Php image upload cropper, how to use image cropper in Php!-->