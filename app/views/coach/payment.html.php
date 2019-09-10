  <script>
    function submitPayuForm() {
     console.log(hash);
      if(hash == '') {
        return;
      }
      var payuForm = document.forms.payuForm;
      payuForm.submit();
    }
  </script>
				<div  style="text-align:center;margin:0px;padding:0px">
     <div style="text-align:center;margin:0px;padding:0px">
    	<h4 style="margin:0px;padding:0px">Pay for Coaching Hub on BlockChain</h4>
     <h5 style="margin:0px;padding:0px">through</h5>
    </div>
    	<img src="img/payumoney.png" alt="PayUMoney" text="PayUMoney"/>
    </div>
    <div style="text-align:center">
    	<h4>Transaction of Rs. <?=number_format(substr($amount,1))?></h4>
    </div>
    <form action="<?php echo $action; ?>" method="post" name="payuForm" class="list" id="payuForm">
      <input type="hidden" name="key" value="<?php echo $key?>" />
      <input type="hidden" name="hash" value="<?php echo $hash ?>"/>
      <input type="hidden" name="txnid" value="<?php echo $txnid ?>" />
      <input type="hidden" id="udf5" name="udf5" value="<?=$udf5?>" />
      <input type="hidden" id="udf1" name="udf1" value="<?=$udf1?>" />
      <input type="hidden" id="surl" name="surl" value="https://blockchainsage.net/success" />
      <input type="hidden" id="furl" name="furl" value="https://blockchainsage.net/success" />
      <input type="hidden" id="service_provider" name="service_provider" value="payu_paisa" />
					<ul>
						<li>
      <div class="item-content item-input">
        <div class="item-inner">
          <div class="item-title item-label">Transaction ID</div>
          <div class="item-input-wrap">
												<input type="text" id="txnid" name="txnid"  placeholder="Transaction ID" value="<?=$txnid?>" readonly="readonly"/>
          </div>
        </div>
      </div>
    </li>
				<li>
      <div class="item-content item-input">
        <div class="item-inner">
          <div class="item-title item-label">Amount</div>
          <div class="item-input-wrap">
												<input type="text"  id="amount" name="amount" placeholder="Amount" value="<?=$amount?>"  readonly="readonly"/>
          </div>
        </div>
      </div>
    </li>
				<li>
      <div class="item-content item-input">
        <div class="item-inner">
          <div class="item-title item-label">CoachID</div>
          <div class="item-input-wrap">
												<input type="text"  id="productinfo" name="productinfo" placeholder="Product Info" value="<?=$productinfo?>"  readonly="readonly"/>
          </div>
        </div>
      </div>
    </li>
				<li>
      <div class="item-content item-input">
        <div class="item-inner">
          <div class="item-title item-label">Name</div>
          <div class="item-input-wrap">
												<input type="text" id="firstname" name="firstname" placeholder="First Name" value="<?=$firstname?>"  readonly="readonly"/>
          </div>
        </div>
      </div>
    </li>
				<li>
      <div class="item-content item-input">
        <div class="item-inner">
          <div class="item-title item-label">Email</div>
          <div class="item-input-wrap">
												<input type="text" id="email" name="email" placeholder="Email ID" value="<?=$email?>"  readonly="readonly"/>
          </div>
        </div>
      </div>
    </li>
				<li>
      <div class="item-content item-input">
        <div class="item-inner">
          <div class="item-title item-label">Mobile</div>
          <div class="item-input-wrap">
												<input type="text" id="mobile" name="mobile" placeholder="Mobile/Cell Number" value="<?=$mobile?>"  readonly="readonly"/>
          </div>
        </div>
      </div>
    </li>
				</ul>
    <div>
				    <button class="col button button-fill color-green" onclick="submitPayuForm()">Pay Rs. <?=$amount?></button>
				</div>
    </form>
