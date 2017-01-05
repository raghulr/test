<?php
class Subscription extends AppModel{
 var $name='Subscription';
 var $regx = "/^
					(?:                                 # Area Code
						(?:                            
							\(                          # Open Parentheses
							(?=\d{3}\))                 # Lookahead.  Only if we have 3 digits and a closing parentheses
						)?
						(\d{3})                         # 3 Digit area code
						(?:
							(?<=\(\d{3})                # Closing Parentheses.  Lookbehind.
							\)                          # Only if we have an open parentheses and 3 digits
						)?
						[\s.\/-]?                       # Optional Space Delimeter
					)?
					(\d{3})                             # 3 Digits
					[\s\.\/-]?                          # Optional Space Delimeter
					(\d{4})\s?                          # 4 Digits and an Optional following Space
					(?:                                 # Extension
						(?:                             # Lets look for some variation of 'extension'
							(?:
								(?:e|x|ex|ext)\.?       # First, abbreviations, with an optional following period
							|
								extension               # Now just the whole word
							)
							\s?                         # Optionsal Following Space
						)
						(?=\d+)                         # This is the Lookahead.  Only accept that previous section IF it's followed by some digits.
						(\d+)                           # Now grab the actual digits (the lookahead doesn't grab them)
					)?                                  # The Extension is Optional
					$/x";
function __construct($id = false, $table = null, $ds = null){
        parent::__construct($id, $table, $ds);
		 $this->validate = array(
			'email' => array(
				'rule2' => array(
					'rule' => 'email',
					'required'=>true,
					'message' => 'Must be a valid email'
				) ,
				'rule1' => array(
					'rule' => 'notempty',
					'required'=>true,
					'message' => 'Required'
				)
			) ,
			'passwd' => array(
				'rule2' => array(
					'rule' => array(
						'minLength',
						6
					) ,
					'message' => 'Must be at least 6 characters'
				) ,
				'rule1' => array(
					'rule' => 'notempty',
					'message' => 'Required'
				)
			),
			'confirm_password' => array(
                'rule3' => array(
                    'rule' => array(
                        '_checkPassword',
                        'passwd',
                        'confirm_password'
                    ),
                    'message' => 'New and confirm password field must match'
                ),
                'rule2' => array(
                    'rule' => array(
                        'minLength',
                        6
                    ) ,
                    'message' => 'Must be at least 6 characters'
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => 'Required'
                )
            ),
			'firstName' => array(
				'rule4' => array(
					'rule' => array(
						'between',
						3,
						20
					) ,
					'message' => 'Must be between of 3 to 20 characters'
				) /*,
				'rule3' => array(
					'rule' => 'alphaNumeric',
					'message' => __l('Must be a valid character')
				)*/ ,
				'rule2' => array(
					'rule' => array(
						'custom',
						'/^[a-zA-Z]/'
					) ,
					'message' => 'Must be start with an alphabets'
				) ,
				'rule1' => array(
					'rule' => 'notempty',
					'message' => 'Required'
				)
			) ,
			'lastName' => array(
				'rule4' => array(
					'rule' => array(
						'between',
						3,
						20
					) ,
					'message' => 'Must be between of 3 to 20 characters'
				)/* ,
				'rule3' => array(
					'rule' => 'alphaNumeric',
					'message' => __l('Must be a valid character')
				) */,
				'rule2' => array(
					'rule' => array(
						'custom',
						'/^[a-zA-Z]/'
					) ,
					'message' => 'Must be start with an alphabets'
				) ,
				'rule1' => array(
					'rule' => 'notempty',
					'message' => 'Required'
				)
			) ,
			'phone' => array(
			 'rule1' => array(
			     'rule' => array('phone',$this->regx, 'us') ,
				 'message' => 'Not a valid phone number' 
				 ),
			 'rule2' => array(
			 	'rule' => 'notEmpty',
				'message' => 'Required'
			 )  
			)
			
			
		);	
	}
		function _checkPassword($field1 = array() , $field2 = null, $field3 = null){
			if ($this->data[$this->name][$field2] == $this->data[$this->name][$field3]) {
				return true;
			//echo 'hi';
			}
			return false;
		}	
	}	
?>