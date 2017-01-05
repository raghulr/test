<?php
class NmiComponent extends Object
{
function api_response($data){
		$xml_data ='<auth>'.
			'<api-key>
				n6B8hf245CQ5GMy7wzb75f2H69Mb37JU
			</api-key>'.
			'<amount>
				5.00
			</amount>'.
			'<redirect-url>
				'.Router::url('alerts/api_token', true).'
			</redirect-url>'.
			'<add-customer>	
			</add-customer>'.
		  '</auth>';
		$url = "https://secure.nmi.com/api/v2/three-step"; 
		$ch=curl_init($url);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
			curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_data");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$output = curl_exec($ch);
			$xmlResponse =$output; 
			$xml_parser = xml_parser_create(); 
            xml_parser_set_option($xml_parser, XML_OPTION_CASE_FOLDING, 0); 
            xml_parser_set_option($xml_parser, XML_OPTION_SKIP_WHITE, 1); 
            xml_parse_into_struct($xml_parser, $xmlResponse, $vals, $index); 
            xml_parser_free($xml_parser);           
            $numTags = 6;  
            for ($x=0; $x<$numTags; $x++){ 
                $key = $vals[$x]['tag'];
				if($key=='result'){
				  		$result = $vals[$x]['value'];
				} 
				if($key=='form-url'){
					 	$formurl = $vals[$x]['value'];
				}
			}
			if($result==1&&$formurl!=''){
				return $this->api_tokenid($formurl,$data);
			}else{
				echo "Transaction not completed";
			}
		curl_close($ch);
	}
	function api_tokenid($formurl=null,$data=null){
		$postvalue = "billing-cc-number=".$data['creditCardNumber']."&billing-cc-exp=".$data['expDateMonth']['month'].$data['expDateYear']['year']."&billing-account-name=Visa&billing-account-number=".$data['creditCardNumber']."&billing-routing-number=123123123&billing-cvv=".$data['cvv2Number'];
		$curl_connection =curl_init($formurl);
		curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($curl_connection, CURLOPT_USERAGENT,
		  "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
		curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl_connection, CURLOPT_FOLLOWLOCATION, 1);
		 
		//set data to be posted
		curl_setopt($curl_connection, CURLOPT_POSTFIELDS, $postvalue);
		 
		//perform our request
		$result = curl_exec($curl_connection);
		 
		//show information regarding the request
		$arr=curl_getinfo($curl_connection);
		$url=$arr['url'];
		$tokenid=explode("=",$url);
		$token=$tokenid[1];
		//echo curl_errno($curl_connection) . '-' .
						curl_error($curl_connection);
		 
		//close the connection
		curl_close($curl_connection);
		return $this->customer_vault($token);

	}
	function customer_vault($token){
		$xml_data ='<complete-action>'.
				'<api-key>
					n6B8hf245CQ5GMy7wzb75f2H69Mb37JU
				</api-key>'.
				'<token-id>'
					.$token.
				'</token-id>'.
			   '</complete-action>';
				$url = "https://secure.nmi.com/api/v2/three-step"; 
				$ch=curl_init($url);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
				curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_data");
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				$output = curl_exec($ch);
				$xmlResponse =$output; 
				$xml_parser = xml_parser_create(); 
				xml_parser_set_option($xml_parser, XML_OPTION_CASE_FOLDING, 0); 
				xml_parser_set_option($xml_parser, XML_OPTION_SKIP_WHITE, 1); 
				xml_parse_into_struct($xml_parser, $xmlResponse, $vals, $index); 
				xml_parser_free($xml_parser);           
				$numTags = 22;  
				for ($x=0; $x<$numTags; $x++){ 
					$key = $vals[$x]['tag'];
					if($key=='result-text'){
							$result = $vals[$x]['value'];
					} 
					if($key=='customer-vault-id'){
							$vault_id = $vals[$x]['value'];
					}
				}

				if($result=='SUCCESS'){
					 return $this->customer_vaultid($vault_id);
				}else{
					echo "Transaction not completed";
				}
	}
	function customer_vaultid($vault_id){
		$xml_data ='<auth>'.
				'<api-key>
					n6B8hf245CQ5GMy7wzb75f2H69Mb37JU
				</api-key>'.
				'<amount>
					5.00
				</amount>'.
				'<customer-vault-id>'
					.$vault_id.
				'</customer-vault-id>'.
			   '</auth>';
				$url = "https://secure.nmi.com/api/v2/three-step"; 
				$ch=curl_init($url);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
				curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_data");
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				$output = curl_exec($ch);
				$xmlResponse =$output; 
				$xml_parser = xml_parser_create(); 
				xml_parser_set_option($xml_parser, XML_OPTION_CASE_FOLDING, 0); 
				xml_parser_set_option($xml_parser, XML_OPTION_SKIP_WHITE, 1); 
				xml_parse_into_struct($xml_parser, $xmlResponse, $vals, $index); 
				xml_parser_free($xml_parser);           
				$numTags = 22;  
				for ($x=0; $x<$numTags; $x++){ 
					$key = $vals[$x]['tag'];
					if($key=='result-text'){
							$result = $vals[$x]['value'];
					} 
					if($key=='customer-vault-id'){
							$vault_id = $vals[$x]['value'];
					}
					if($key=='transaction-id'){
							$transaction_id=$vals[$x]['value'];
					}
				}
				if($result=='SUCCESS'&&$vault_id!=''){
					$post_info['result'] = $result;
					$post_info['vault_id'] = $vault_id;
					$post_info['transaction_id']=$transaction_id;
					return $post_info;
				}else{
					echo "Transaction not completed";
				}
	}
	function dovoid($data){
		$xml_data ='<void>'.
				'<api-key>
					n6B8hf245CQ5GMy7wzb75f2H69Mb37JU
				</api-key>'.
				'<transaction-id>'
					.$data.
				'</transaction-id>'.
			   '</void>';
		$url = "https://secure.nmi.com/api/v2/three-step"; 
		$ch=curl_init($url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
		curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_data");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($ch);
		return $output;
	}
	function doDirectPayment($data){
	}
	function doCapture($data){
		$xml_data ='<capture>'.
				'<api-key>
					n6B8hf245CQ5GMy7wzb75f2H69Mb37JU
				</api-key>'.
				'<transaction-id>'
					.$data.
				'</transaction-id>'.
			   '</capture>';
		$url = "https://secure.nmi.com/api/v2/three-step"; 
		$ch=curl_init($url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
		curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_data");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($ch);
		$xmlResponse =$output; 
		$xml_parser = xml_parser_create(); 
		xml_parser_set_option($xml_parser, XML_OPTION_CASE_FOLDING, 0); 
		xml_parser_set_option($xml_parser, XML_OPTION_SKIP_WHITE, 1); 
		xml_parse_into_struct($xml_parser, $xmlResponse, $vals, $index); 
		xml_parser_free($xml_parser);           
		$numTags = 7;  
		for ($x=0; $x<$numTags; $x++){ 
			$key = $vals[$x]['tag'];
			if($key=='transaction-id'){
					$transaction_id=$vals[$x]['value'];
			}
		}
		return $transaction_id;
	}
	function doReferenceTransaction($postvalue){
		$xml_data ='<auth>'.
				'<api-key>
					n6B8hf245CQ5GMy7wzb75f2H69Mb37JU
				</api-key>'.
				'<amount>'
					.$postvalue['amount'].
				'</amount>'.
				'<customer-vault-id>'
					.$postvalue['vault_id'].
				'</customer-vault-id>'.
			   '</auth>';
		$url = "https://secure.nmi.com/api/v2/three-step"; 
		$ch=curl_init($url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
		curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_data");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($ch);
		$xmlResponse =$output; 
		$xml_parser = xml_parser_create(); 
		xml_parser_set_option($xml_parser, XML_OPTION_CASE_FOLDING, 0); 
		xml_parser_set_option($xml_parser, XML_OPTION_SKIP_WHITE, 1); 
		xml_parse_into_struct($xml_parser, $xmlResponse, $vals, $index); 
		xml_parser_free($xml_parser);           
		$numTags = 22;  
		for ($x=0; $x<$numTags; $x++){ 
			$key = $vals[$x]['tag'];
			if($key=='result-text'){
					$result = $vals[$x]['value'];
			} 
			if($key=='transaction-id'){
					$transaction_id=$vals[$x]['value'];
			}
		}
		if($result=='SUCCESS'&&$transaction_id!=''){
				$post_info['result'] = $result;
				$post_info['transaction_id']=$transaction_id;
				return $post_info;
		}else{
			echo "Transaction not completed";
		}
	}
}
?>