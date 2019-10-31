<div class="block block-strong">
<h4>Personality Tests</h4>
<h5>Introduction</h5>
<p>This is a personality test, it will help you understand why you act the way that you do and how your personality is structured. Please follow the instructions below, scoring and results are on the next page</p>
<h5>Instructions</h5>
<p>For each statement 1 to 50 mark how you agree with the scale of 1 to 5, where 1=disagree, 2=silghtly disagree, 3=neutral, 4=slightly agree, 5=agree</p>
<form method="post" enctype="multipart/form-data" action="#" name="personality" id="personality">
<?php foreach ($questions as $q){?>
	<div class="block"><?=$q['Number']?>. I <?php echo strtolower($q['Question']);?></div>
<div class="block block-strong">
<div class="row">
	<div class="col-25 align-left">Disagree-1 </div>
  <div class="col-50"><input type="range" min="0" max="5" step="1" value="0" name="selected<?=$q['Number']?>" id="selected<?=$q['Number']?>" class="col-60"></div>
		<div class="col-25" style="text-align:right">5-Agree</div>
</div>
</div>
<!--					<a class="item-link smart-select smart-select-init" data-open-in="sheet">
						<select name="selected<?=$q['Number']?>" id="selected<?=$q['Number']?>" >
						<option value="0">-- Select from 1 to 5 --</option>
							<option value="1">1-Disagree</option>
							<option value="2">2-Slightly Disagree</option>
							<option value="3">3-Neutral</option>
							<option value="4">4-Slightly Agree</option>
							<option value="5">5-Agree</option>
						</select>
						<div class="item-content">
								<div class="item-inner">
										<div class="item"><?=$q['Number']?>. I <?php echo strtolower($q['Question']);?></div>
								</div>
						</div>
					</a> -->
	<?php }?>
<div class="block-title">Your Details</div>
<div class="list no-hairlines-md">
  <ul>
    <li class="item-content item-input">
      <div class="item-inner">
        <div class="item-title item-label">Name</div>
        <div class="item-input-wrap">
        <input type="text" placeholder="Your name" name="Name" id="Name" required validate data-vaildate-on-blur="true">
          <span class="input-clear-button"></span>
        </div>
      </div>
    </li>
    <li class="item-content item-input">
      <div class="item-inner">
        <div class="item-title item-label">Mobile</div>
        <div class="item-input-wrap">
          <input type="text" placeholder="9876543210" name="Mobile" id="Mobile" required validate pattern="[0-9]*" data-error-message="Only numbers please!"  max="9999999999" min="1111111111">
          <span class="input-clear-button"></span>
        </div>
      </div>
    </li>
    <li class="item-content item-input">
      <div class="item-inner">
        <div class="item-title item-label">E-mail</div>
        <div class="item-input-wrap">
          <input type="email" placeholder="Your e-mail" name="email" id="email" required validate>
          <span class="input-clear-button"></span>
        </div>
      </div>
    </li>
  </ul>
</div>
<input type="submit" class="button button-fill" value="Submit" id="SubmitTest" onclick="return checkdata();">

</form>
</div>
<script>
</script>