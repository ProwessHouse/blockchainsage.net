<?php

?>
<h1>SignIn           <small><a class="btn btn-primary" href="/coach/register">Register</a></small></h1>
<span class="error"><?=$Message?></span>
<form action="/coach/signin" method="post" enctype="multipart/form-data" name="signin" id="signin">
	Email:
	<input type="text" class="form-control" id="Email" name="Email">
	Password:
	<input type="password" class="form-control" id="Password" name="Password"><br>
	<input type="submit" value="Save" class="form-control btn btn-primary" >
</form>
