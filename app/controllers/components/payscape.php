<?php
class PayscapeComponent extends Object
{
	function doDirectPayment($post_info) {
		$paymentType = urlencode($post_info['paymentType']);
        $creditCardType = urlencode($post_info['creditCardType']);
        $creditCardNumber = urlencode($post_info['creditCardNumber']);
        $expDateMonth = urlencode($post_info['expDateMonth']['month']);
        // Month must be padded with leading zero
        $padDateMonth = str_pad($expDateMonth, 2, '0', STR_PAD_LEFT);
        $expDateYear = urlencode($post_info['expDateYear']['year']);
        $cvv2Number = urlencode($post_info['cvv2Number']);
        $amount = urlencode($post_info['amount']);
        $currencyCode = Configure::read('paypal.currency_code'); //only USD allowed
        $nvpstr = "username=demo&password=password&type=".$paymentType."&ccnumber=".$creditCardNumber."&ccexp=".$padDateMonth.$expDateYear."&cvv=".$cvv2Number."&amount=".$amount;	
		$payment_result = $this->_postPayment($nvpstr);	
		return $payment_result;
		
	}
	function doCapture($post_info){
		$paymentType = urlencode($post_info['paymentType']);
		$transactionid = urlencode($post_info['transactionid']);
		$amount = urlencode($post_info['amount']);
        $nvpstr = "username=demo&password=password&type=".$paymentType."&transactionid=".$transactionid."&amount=".$amount;
		$payment_result = $this->_postPayment($nvpstr);
		return $payment_result;
	}
	function doVoid($post_info){
		$paymentType = urlencode($post_info['paymentType']);
		$transactionid = urlencode($post_info['transactionid']);
        $nvpstr = "username=demo&password=password&type=".$paymentType."&transactionid=".$transactionid;
		$payment_result = $this->_postPayment($nvpstr);
		return $payment_result;
	}
	function _postPayment($postvalue){
		$url = "https://secure.payscapegateway.com/api/transact.php"; 		
		$ch=curl_init();
		curl_setopt($ch, CURLOPT_USERAGENT,"Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.1) Gecko/2008070208 Firefox/3.0.1");
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_POST,1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$postvalue);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		$payment_result=curl_exec($ch);
		$responses = $payment_result;
		$response=explode('&',$responses);
		$i=0;
		$payment_result = array();
		while($i<count($response)){
			$responses=explode('=',$response[$i]);
			$payment_result[$responses[0]]=$responses[1];
			$i++;
		}
		return $payment_result;
	}
}
?>