<?php
use app\extensions\action\Functions;
$function = new Functions();

ini_set('memory_limit', '-1');
//print_r($agreement['mcaNumber']);exit;
$pdf =& $this->Pdf;
//$pdf->SetProtection($permissions=array('modify','extract','assemble'), $user_pass=$printdata['email'], $owner_pass=null, $mode=1, $pubkeys=null);

$this->Pdf->setCustomLayout(array(
    'header'=>function() use($pdf){
        list($r, $g, $b) = array(200,200,200);
        $pdf->SetFillColor($r, $g, $b); 
        $pdf->SetTextColor(0 , 0, 0);
        $pdf->Cell(0,15, "Coaching Agreement, Hitarth IT Services Pvt. Ltd.", 0,1,'C', 1);
        $pdf->Ln();
    },
    'footer'=>function() use($pdf){
        $footertext = sprintf('This is a digitally signed agreement. No need of physical signature or stamp paper.', date('Y')); 
        $pdf->SetY(-10); 
        $pdf->SetTextColor(0, 0, 0); 
        $pdf->SetFont(PDF_FONT_NAME_MAIN,'', 8); 
        $pdf->Cell(0,8, $footertext,'T',1,'C');
    }

));

$pdf->SetHeaderMargin(0);
$pdf->SetFooterMargin(20);
$pdf->SetAuthor('https://blockchainsage.net');
$pdf->SetCreator('blockchainsage@gmail.com');
$pdf->SetSubject('HITS - Agreement');
$pdf->SetKeywords('Hitarth IT Services, Coaching on Blockchain, Agreement');
$pdf->SetTitle('Hitarth IT Services Pvt. Ltd. - contact: +91 90810 58884');


$pdf->SetAutoPageBreak(true);
$pdf->AddPage();
$pdf->SetTextColor(0, 0, 0);
$pdf->SetXY(10,20,false);


$transactions = array();
$finalPlan = array();
foreach($agreement['payuMoney'] as $p){
 if($p['status']=="success"){
  if($p['amount']=="1110.00"){
  array_push($transactions,array('for'=>'Training and Literature','status'=>$p['status'],'amount'=>$p['amount'],'txnid'=>$p['txnid'],'date'=>$p['date'],'email'=>$p['email'],'productInfo'=>$p['productInfo']));
  }else{
  array_push($transactions,array('for'=>'Monthly products','status'=>$p['status'],'amount'=>$p['amount'],'txnid'=>$p['txnid'],'date'=>$p['date'],'email'=>$p['email'],'productInfo'=>$p['productInfo']));
  array_push($finalPlan,array('for'=>'Monthly products','status'=>$p['status'],'amount'=>$p['amount'],'txnid'=>$p['txnid'],'date'=>$p['date'],'email'=>$p['email'],'productInfo'=>$p['productInfo']));
   
  }
 }
}




$html = '
<table cellpadding=15 cellspacing=15 border=0 style="font-size:24px">
<tr>
<td colspan="2">
<img src="/app/webroot/img/Hitarth%20IT%20Services.png"/>
</td>
</tr>
<tr>
<td  colspan="2" style="font-size:30px;font-weight:bold;padding:5px;text-align:right">Date: '.gmdate("Y-M-d").'</td>
</tr>
<tr>
<td  colspan="2" style="text-align:center"><h2>Agreement</h2></td>
</tr>
<tr>
<td  colspan="2" style="text-align:center">&nbsp;</td>
</tr>
<tr>
<td  colspan="2" style="font-size:30px;padding:5px;text-align:left">This document is an agreement between:</td>
</tr>
<tr><td>&nbsp;</td></tr>
<tr>
<td style="width:30px">&nbsp;</td>
<td style="width:500px;font-size:30px;padding:5px;text-align:justify;">1. Hitarth IT Services Pvt. Ltd. (<strong>HITARTH</strong>) having registered office at <strong>B/804 JeevanDham Complex, Opp. BSNL Telephone Exchange, Satellite Road, Ahmedabad - 380015, Gujarat India</strong>, incorporated on <strong>18th October 2017</strong>, having company identification number <strong>CIN: U72200GJ2017PTC099545</strong> and PAN card No: <strong>AAECH3407R</strong>, contact phone: <strong>+91 98010 58884</strong> contact person: <strong>Nilam A Doctor</strong>, Director of <strong>HITARTH</strong>. </td>
</tr>
<tr><td>&nbsp;</td></tr>
<tr>
<td style="width:30px">&nbsp;</td>
<td style="width:500px;font-size:30px;padding:5px;text-align:justify;">
2. '.$agreement['firstName'].' '.$agreement['lastName'].' (<strong>CONSULTANT</strong>) gender: <strong>'.$agreement['gender'].'</strong>, date of birth: <strong>'.$agreement['dateofbirth'].'</strong> residing at <strong>'.$agreement['address'].' '.$agreement['street'].' '.$agreement['city'].' '.$agreement['pin'].' '.$agreement['state'].', India</strong> contact phone: <strong>'.$agreement['mobile'].'</strong>  and email: <strong>'.$agreement['email'].'</strong>  having the MCA No: <strong>'.$agreement['mcaNumber'].'</strong>  and password <strong>'.$agreement['mcaPassword'].'</strong>.	on date <strong>'.gmdate("Y-M-d",hexdec(substr($agreement['_id'], 0, 8))).'</strong>.
</td>
</tr>
<tr><td>&nbsp;</td></tr>
<tr><td colspan="2"><h3>Appointment:</h3></td></tr>
<tr><td colspan="2" style="font-size:30px;padding:5px;text-align:justify"><strong>Consultant</strong> is appointing <strong>Hitarth</strong> to develop his network marketing business and is giving all rights to maintain his/her account, arrange invoicing and home delivery logistics.</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td colspan="2"><h3>Purpose:</h3></td></tr>
<tr><td colspan="2" style="font-size:30px;padding:5px;text-align:justify"><strong>Hitarth</strong> and <strong>Consultant</strong> have agreed upon that, <strong>Hitarth</strong> will be providing software, billing and delivery of products listed on the software (<strong>SFF – Services</strong>) with logistics to the <strong>Consultant</strong>. The <strong>Consultant</strong> grants permission to <strong>Hitarth</strong> for regularly invoicing and delivery of products to the address provided by the <strong>Consultant</strong> from the Distribution point, to facilitate the <strong>Consultant</strong> to get full benefits of the company business plan.</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td colspan="2"><h3>Payment:</h3></td></tr>
<tr><td colspan="2" style="font-size:30px;padding:5px;text-align:justify"><strong>Consultant</strong> has made a payment for receiving services of <strong>Rs. '.$transactions[0]['amount'].'</strong> for <strong>'.$transactions[0]['for'].'</strong> through the software provided by <strong>Hitarth</strong>, using the payment gateway of PayUMoney on date: <strong>'.$transactions[0]['date'].'</strong> using his email <strong>'.$transactions[0]['email'].'</strong> through Net Banking /  Credit Card / Debit Card / UPI / EMI directly credited to <strong>Hitarth</strong> with transaction ID: <strong>'.$transactions[0]['txnid'].'</strong>.</td></tr>
<tr><td colspan="2" style="font-size:30px;padding:5px;text-align:justify"><strong>Consultant</strong> has also made a payment for receiving services of <strong>Rs. '.$transactions[1]['amount'].'</strong> for <strong>'.$transactions[1]['for'].'</strong> through the software provided by <strong>Hitarth</strong>, using the payment gateway of PayUMoney on date: <strong>'.$transactions[1]['date'].'</strong> using his email <strong>'.$transactions[1]['email'].'</strong> through Net Banking /  Credit Card / Debit Card / UPI / EMI directly credited to <strong>Hitarth</strong> with transaction ID: <strong>'.$transactions[1]['txnid'].'</strong>.</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td colspan="2"><h3>Procedure:</h3></td></tr>
<tr><td colspan="2" style="font-size:30px;padding:5px;text-align:justify">
<ol>
<li><strong>Consultant</strong> has paid 100% advance for availing the services from <strong>Hitarth</strong>.</li>
<li><strong>Hitarth</strong> will be creating invoice every month between date 1<sup>st</sup> to 15<sup>th</sup> of each month as per the plan selected by the <strong>Consultant</strong>. The invoice will be sent to their registered email / phone through SMS.</li>
<li>The <strong>Consultant</strong> will not change the password or email and mobile number. If he would like to change them, he will have to inform <strong>Hitarth</strong> for making the necessary changes. </li>
<li>The <strong>Consultant</strong> will provide the OTP received on his/her mobile from time to time, when required by <strong>Hitarth</strong>.</li>
<li>The <strong>Consultant</strong> will select the products he/she needs through <strong>SFF-Services</strong> app provided by <strong>Hitarth</strong> every month. <strong>Hitarth</strong> will deliver the products as per the order to the address provided by the <strong>Consultant</strong>.</li>
<li><strong>Hitarth</strong> will maintain all records of transaction done on the account of the <strong>Consultant</strong> and will submit monthly and yearly reports to the <strong>Consultant</strong>.</li>
<li>The service agreement is for ONLY one year from the receipt of the payment form the <strong>Consultant</strong>.</li>
</ol>
</td>
</tr>
<tr><td>&nbsp;</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td colspan="2" style="font-size:30px;padding:5px;text-align:justify"><strong>Consultant</strong> has selected to pay Rs. <strong>'.$finalPlan[0]["amount"].'</strong> through the payment gateway of PayUMoney. <strong>Hitarth</strong> will do a monthly distributor price (DP) invoicing of Rs. <strong>'.((integer)$finalPlan[0]["amount"])/12 .'</strong> and will monthly delivery the products as requested by the <strong>Consultant</strong> of Maximum Retail Price (MRP) Rs. <strong>'. ((integer)$finalPlan[0]["amount"])/12*1.5 .'</strong> and also commit a yearly cashback directly to the <strong>Consultants</strong> bank account of Rs. '. ((integer)$finalPlan[0]["amount"])*.1 . ' starting from date: <strong>'. $finalPlan[0]["date"] . '</strong> for only 12 months.</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td colspan="2"><h3>Terms of Service:</h3></td></tr>
<tr><td colspan="2" style="font-size:30px;padding:5px;text-align:justify">
<ol>
<li>This service agreement is subject Ahmedabad Jurisdiction only.</li>
<li>Home delivery will be done only once a month, with a minimum order of Rs. 2000 only</li>
<li>This service agreement cannot be terminated within the first 90 days of the start of the agreement.</li>
<li>Either party must provide a written notice to terminate the contract before 90 days of termination. </li>
<li>Consultant will have to furnish in writing with a reason for termination. Subject to approval by Hitarth.</li>
<li>On termination, Hitarth will pay the balance amount within 30 days of termination of this agreement.</li>
<li>Any payment made by Credit Card using the EMI option will not be able to terminate the agreement till the end of the agreement period and no money will be refunded in form of cash or any other mode of payment.</li>
</ol>
</td>
</tr>
<tr><td>&nbsp;</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td colspan="2" style="font-size:30px;padding:5px;">Signed: <strong>HITARTH</strong></td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td colspan="2"><img src="/app/webroot/img/Signed-Stamp.png" width="200"/></td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td colspan="2" style="font-size:30px;padding:5px;"><strong>Nilam A Doctor</strong></td></tr>
</table>';
$pdf->writeHTML($html, true, 0, true, 0);
?>