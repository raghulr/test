<?php
class NmiqueryComponent extends Object{
	function setLogin() {
		$this->login['username'] = 'nobledemo';
		$this->login['password'] = 'nobledemo1';
//        $this->login['username'] = 'jKleinTS';
//		$this->login['password'] = 'hoosier231';
	}
	function doVaultPost($post_info){
		$this->setLogin();
		$firstName=$post_info['firstName'];
		$lastName=$post_info['lastName'];
        $customer_vault = $post_info['customer_vault'];
        $creditCardType = urlencode($post_info['creditCardType']);
        $ccnumber = urlencode($post_info['creditCardNumber']);
        $expDateMonth = urlencode($post_info['expDateMonth']['month']);
		$expDateYear=urlencode($post_info['expDateYear']['year']);		
		$ccexp=$expDateMonth.$expDateYear;
		$cvv2Number = urlencode($post_info['cvv2Number']);
		$customer_vault_id = '';
        
		// Month must be padded with leading zero
        
        //$amount = urlencode($post_info['amount']);
		$query  = "";
		$query .= "username=" . urlencode($this->login['username']) . "&";
		$query .= "password=" . urlencode($this->login['password']) . "&";
		
		// Sales Information
		$query .= "customer_vault=add_customer&";
		$query .= "customer_vault_id=".$customer_vault_id."&";
		$query .= "firstname=" . $firstName . "&";
		$query .= "lastname=" . $lastName . "&";
		$query .= "ccnumber=" . $ccnumber . "&";
		$query .= "ccexp=" . $ccexp . "&";
		$query .= "cvv=" . $cvv2Number. "&";
        //Amex card checking
        $cc_length = strlen((string)$ccnumber);
        $prefix_amex= substr($ccnumber, 0, 2);
        
        if($prefix_amex == 34 || $prefix_amex == 37 && ($cc_length == 15)){
            $query .= "type=sale&";
            $query .= "amount=1.00";
        }
        else{
            $query .= "type=validate";
        } 	
                
		return $this->_doPost($query);
	}
	function doDirectPayment($post_info){
		$payment_responses = $this->doVaultPost($post_info);
		if(!empty($payment_responses) && $payment_responses['response'] == 1):
                //Amex card checking     
            $cc_length = strlen((string)$post_info['creditCardNumber']);
            $prefix_amex= substr($post_info['creditCardNumber'], 0, 2);
            if($prefix_amex == 34 || $prefix_amex == 37 && ($cc_length == 15)):
                $void_responses = $this->doVoidTransaction($payment_responses);
            endif;    
			$payment_responses = $this->doReferenceTransaction($payment_responses);
			return $payment_responses;
		else:
			//pr($payment_responses);	
			$message=!empty($payment_responses)?$payment_responses:'';
			return $message;
		endif;	
	
	}
	function doReferenceTransaction($post_info){
		$this->setLogin();
		$customer_vault_id = urlencode($post_info['customer_vault_id']);
		$amount = 5;
        
		$query  = "";
		$query .= "username=" . urlencode($this->login['username']) . "&";
		$query .= "password=" . urlencode($this->login['password']) . "&";
		
		// Sales Information
		$query .= "customer_vault_id=".$customer_vault_id."&";
		$query .= "amount=" . urlencode(number_format($amount,2,".",""))."&";
		$query .= "type=sale";
        
		return $this->_doPost($query);
	}
    function doVoidTransaction($post_info){
        $this->setLogin();
        $transaction_id = urlencode($post_info['transactionid']);
        
        $query  = "";
        $query .= "username=" . urlencode($this->login['username']) . "&";
        $query .= "password=" . urlencode($this->login['password']) . "&";
        
        // Void Information
        $query .= "type=void&";
        $query .= "transactionid=".$transaction_id;
        
        return $this->_doPost($query);
    }
	function _doPost($query) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://secure.nmi.com/api/transact.php");
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
		curl_setopt($ch, CURLOPT_TIMEOUT, 15);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
		curl_setopt($ch, CURLOPT_POST, 1);

		if (!($data = curl_exec($ch))) {
			return ERROR;
		}
		curl_close($ch);
		unset($ch);
		$data = explode("&",$data);
		for($i=0;$i<count($data);$i++) {
			$rdata = explode("=",$data[$i]);
			$this->responses[$rdata[0]] = $rdata[1];
		}
		//pr($this->responses);
		//exit;
		return $this->responses;
	}
}
?>