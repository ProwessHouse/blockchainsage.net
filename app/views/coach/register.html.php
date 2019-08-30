<?php

?>
<h1>Register           <small><a class="btn btn-primary" href="/coach/signin">SignIn</a></small></h1>
<span class="error"><?=$Message?></span>
<form action="/coach/register" method="post" enctype="multipart/form-data" name="register" id="register">
	First Name:
	<input type="text" class="form-control" id="FirstName" name="FirstName">
	Last Name:
	<input type="text" class="form-control" id="LastName" name="LastName">
	Email:
	<input type="text" class="form-control" id="Email" name="Email">
	Mobile:
	<input type="text" class="form-control" id="Mobile" name="Mobile">
	Password:
	<input type="password" class="form-control" id="Password" name="Password">
	<small id="passwordHelp" class="form-text text-muted">Strong Password.</small>
	<meter max="4" id="password-strength-meter"></meter>
	<p id="password-strength-text"></p>
	<input type="submit" value="Save" class="form-control btn btn-primary" >
</form>
<script src="https://cdnjs.cloudflare.com/ajax/libs/zxcvbn/4.2.0/zxcvbn.js"></script>
<script>
var strength = {
        0: "Worst ☹",
        1: "Bad ☹",
        2: "Weak ☹",
        3: "Good ☺",
        4: "Strong ☻"
}

var password = document.getElementById('Password');
var meter = document.getElementById('password-strength-meter');
var text = document.getElementById('password-strength-text');

password.addEventListener('input', function()
{
    var val = password.value;
    var result = zxcvbn(val);
    // Update the password strength meter
				meter.value = result.score;
   
    // Update the text indicator
    if(val !== "") {
        text.innerHTML = "Strength: " + "<strong>" + strength[result.score] + "</strong>" + "<span class='feedback'>" + result.feedback.warning + " " + result.feedback.suggestions + "</span>"; 
    }
    else {
        text.innerHTML = "";
    }
});</script>
