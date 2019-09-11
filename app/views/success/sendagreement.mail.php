<?php

?><p>Coaching Hub</p>
<p>
<?=$compact['data']['email']?><br>
IP: <?=$_SERVER['REMOTE_ADDR'];?><br>

Date and time: <?=gmdate('Y-m-d H:i:s',time())?>
</p>