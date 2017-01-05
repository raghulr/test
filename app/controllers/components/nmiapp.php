<?php
class NmiappComponent extends Object{
    function setLogin() {
    		 $this->login['username'] = 'nobledemo';
    		 $this->login['password'] = 'nobledemo1';
//       $this->login['username'] = 'jKleinTS';
//       $this->login['password'] = 'jKleinTS15';

    }
    function doVaultPost($post_info){
        $this->setLogin();
        $firstName=$post_info['firstName'];
        $lastName=$post_info['lastName'];
        $customer_vault = $post_info['customer_vault'];
        $creditCardType = $post_info['creditCardType'];
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
        $query .= "cvv=" . $cvv2Number."&";
       
       if($creditCardType == 'Amex' || $creditCardType == 'American Express'){
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
           if($creditCardType == 'Amex' || $creditCardType == 'American Express'):
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
    
    function deleteVault($customer_vault_id){
        $this->setLogin();
        $customer_vault_id = urlencode($customer_vault_id);

        $query  = "";
        $query .= "username=" . urlencode($this->login['username']) . "&";
        $query .= "password=" . urlencode($this->login['password']) . "&";

        // Sales Information

        $query .= "customer_vault=delete_customer&";
        $query .= "customer_vault_id=".$customer_vault_id;
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
    function _getCardDetails($customer_vault_id=null)
    {
        $username = 'nobledemo';
        // $password = 'hoosier231';
        $password = 'nobledemo1';
        $constraints = "&customer_vault_id=".$customer_vault_id."&report_type=customer_vault";
        // transactionFields has all of the fields we want to validate
        // in the transaction tag in the XML output
        $postStr='username='.$username.'&password='.$password. $constraints;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://secure.networkmerchants.com/api/query.php");
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postStr);
        curl_setopt($ch, CURLOPT_POST, 1);

        $data = curl_exec($ch);
        $testXmlSimple= new SimpleXMLElement($data);
        return json_encode($testXmlSimple);
    }
}
?>