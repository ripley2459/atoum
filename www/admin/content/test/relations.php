<?php

https://www.devopsschool.com/blog/how-to-do-auto-load-and-refresh-div-every-seconds-with-jquery-and-ajax-with-php-script/

	if(isset($_POST["post_name"]))
	{
		$new_relation = new relation(-1);

		$connect = mysqli_connect("localhost", "root", "", "auto_refresh");
		$post_name = mysqli_real_escape_string($connect, $_POST["post_name"]);
		$sql = "INSERT INTO tbl_post (post_name) VALUES ('".$post_name."')";
		mysqli_query($connect, $sql);
	}

?>

<div class="container box">
	<form name="add_post" method="post">
		<h3 align="center">Post Page</h3>
		<div class="form-group">
			<textarea name="post_name" id="post_name" class="form-control" rows="3"></textarea>
		</div>
		<div class="form-group" align="right">
			<input type="button" name="post_button" id="post_button"  value="Post" class="btn btn-info" />
		</div>
	</form>

	<br />

	<div id="load_posts">
		<!-- Refresh this Div content every second!-->
		<!-- For Refresh Div content every second we use setInterval() !-->
	</div>
</div>

<script>
$(document).ready(function(){
 $('#post_button').click(function(){
  var post_name = $('#post_name').val();
  //trim() is used to remover spaces
  if($.trim(post_name) != '')
  {
   $.ajax({
    url:"post.php",
    method:"POST",
    data:{post_name:post_name},
    dataType:"text",
    success:function(data)
    {
     $('#post_name').val("");
    }
   });
  }
 });
 
 setInterval(function(){//setInterval() method execute on every interval until called clearInterval()
  $('#load_posts').load("display.php").fadeIn("slow");
  //load() method fetch data from fetch.php page
 }, 1000);
 
});
</script>