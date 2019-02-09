<?php

$debug = $_REQUEST['debug'];
$outputFolder = "/web/jerryreed/jerryreed.net/";
$tempOutputFolder = "/tmp/jerryreed/";
$url = $_POST['url'];
if($url){
    
    if(strpos($url, "spark.adobe.com") !== false){
        
        //clean folders first
        $exec = shell_exec("rm -rf $tempOutputFolder");
        if($debug){
            dd($exec);
        }
        $exec = shell_exec("rm -rf $outputFolder");
        if($debug){
            dd($exec);
        }
        $exec = shell_exec("/usr/local/bin/httrack --clean -q -O $tempOutputFolder $url");
        if($debug){
            dd($exec);
        }
        //now copy files to folder
        $parsed = parse_url($url);
        if($debug){
            var_dump($parsed);
        }
        $path = $parsed['path'];
        $fullPath = $tempOutputFolder.'spark.adobe.com'.$path;
        if($debug){
            echo "<br> rsync -av $fullPath $outputFolder <br>";
        }

        $exec = shell_exec("rsync -av $fullPath $outputFolder");
        if($debug){
            dd($exec);
        }

        $exec = shell_exec("sed -i 's/http:/https:/g' $outputFolder/index.html");
        
        echo "<br>SUCCESSFULLY COPIED ADOBE SPARK DATA<br>";
        exit;

    }

}

function dd($data){
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
}


?>
<script src='https://code.jquery.com/jquery-3.3.1.min.js'></script>
<script>
$( document ).ready(function() {
  $('#myform').submit(function(){
      console.log("Fired");
    $('#submit').prop('disabled', true);
    $('#modalprogress').modal();
    updateProgressbar();
  });
  console.log("Ready");
});
function updateProgressbar(){
    var current_progress = 0;
    var interval = setInterval(function() {
      current_progress += 10;
      $("#progressbar")
      .css("width", current_progress + "%")
      .attr("aria-valuenow", current_progress)
      .text(current_progress + "% Complete");
      if (current_progress >= 100)
          clearInterval(interval);
  }, 2300);
}
</script>    


<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
            <form action="" method="post" id="myform">
                <h1>Welcome Jerry Reed</h1>
                <div class="form-group">
					<label for="exampleInputEmail1">
                        <h2>Enter in url to download</h2>
					</label>
					<input type="url" name="url" class="form-control" id="url" />
				</div>
                <input id="submit" type="submit" value="submit" class="btn btn-primary">
            </form>
			
		</div>
	</div>
</div>

<div aria-hidden="true" aria-labelledby="myModalLabel" class="modal fade" id="modalprogress" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<div class="modal-header">
					PLEASE WAIT WHILE WE DOWNLOAD ALL FILES
				</div>
				<div class="progress">
					<div aria-valuemax="100" aria-valuemin="0" aria-valuenow="1" class="progress-bar progress-bar-striped progress-bar-animated" id="progressbar" role="progressbar" style="width: 1%"></div>
				</div>
			</div>
		</div>
	</div>
</div>
            
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.bundle.min.js"></script>
