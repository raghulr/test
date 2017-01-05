<?php
class User extends AppModel{
	 var $name = 'User';
	 var $hasMany = array(
						 'Reservation'=>array(
						 'className'=>'Reservation',
						 'foreignKey'=>'userId'
						 )
					);
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
				'rule3' => array(
					'rule' => 'isUnique',
					//'on' => 'create',
					'message' => 'This email address already exists'
				) ,
				'rule2' => array(
					'rule' => 'email',
					'message' => 'Must be a valid email'
				) ,
				'rule1' => array(
					'rule' => 'notempty',
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
			) ,
			'password' => array(
				'rule2' => array(
					'rule' => array('minLength',6) ,
					'message' => 'Must be at least 6 characters'
				) ,
				'rule1' => array(
					'rule' => 'notempty',
					'message' => 'Please enter your password'
				)
			) ,
			'confirm_password' => array(
                'rule3' => array(
                    'rule' => array(
                        '_checkPassword',
                        'password',
                        'confirm_password'
                    ) ,
                    'message' => __l('New and confirm password field must match')
                ) ,
                'rule2' => array(
                    'rule' => array(
                        'minLength',
                        6
                    ) ,
                    'message' => __l('Must be at least 6 characters')
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ),
			  'old_password' => array(
                'rule3' => array(
                    'rule' => array(
                        '_checkOldPassword',
                        'old_password'
                    ) ,
                    'message' => __l('Your old password is incorrect, please try again')
                ) ,
                'rule2' => array(
                    'rule' => array(
                        'minLength',
                        6
                    ) ,
                    'message' => __l('Must be at least 6 characters')
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
			'firstName' => array(
				'rule4' => array(
					'rule' => array(
						'between',
						1,
						20
					) ,
					'message' => __l('Must be between of 1 to 20 characters')
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
					'message' => __l('Must be start with an alphabets')
				) ,
				'rule1' => array(
					'rule' => 'notempty',
					'message' => __l('Required')
				)
			) ,
			'lastName' => array(
				'rule4' => array(
					'rule' => array(
						'between',
						1,
						20
					) ,
					'message' => __l('Must be between of 1 to 20 characters')
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
					'message' => __l('Must be start with an alphabets')
				) ,
				'rule1' => array(
					'rule' => 'notempty',
					'message' => __l('Required')
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
		$this->validateCreditCard = array(
            'holder_fname' => array(
              'rule4' => array(
					'rule' => array(
						'between',
						1,
						20
					) ,
					'message' => __l('Must be between of 1 to 20 characters')
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
					'message' => __l('Must be start with an alphabets')
				) ,
				'rule1' => array(
					'rule' => 'notempty',
					'message' => __l('Required')
				)
            ) ,
            'holder_lname' => array( 
               'rule4' => array(
					'rule' => array(
						'between',
						1,
						20
					) ,
					'message' => __l('Must be between of 1 to 20 characters')
				)/* ,
				'rule3' => array(
					'rule' => 'alphaNumeric',
					'message' => __l('Must be a valid character')
				)*/ ,
				'rule2' => array(
					'rule' => array(
						'custom',
						'/^[a-zA-Z]/'
					) ,
					'message' => __l('Must be start with an alphabets')
				) ,
				'rule1' => array(
					'rule' => 'notempty',
					'message' => __l('Required')
				)
            ),/* ,
			'name'=>array(
				'rule4' => array(
					'rule' => array(
						'between',
						3,
						20
					) ,
					'message' => __l('Must be between of 3 to 20 characters')
				) ,
				'rule3' => array(
					'rule' => 'alphaNumeric',
					'message' => __l('Must be a valid character')
				) ,
				'rule2' => array(
					'rule' => array(
						'custom',
						'/^[a-zA-Z]/'
					) ,
					'message' => __l('Must be start with an alphabets')
				) ,
				'rule1' => array(
					'rule' => 'notempty',
					'message' => __l('Required')
				)
			),*/
			'card_type' => array(
				 'notempty' => array(
                               'rule' => 'notEmpty',
                               'message' => 'Required',
                               'required' => true,
                               'last' => true
                       ),
			),
            'creditCardNumber' => array(
				 'notempty' => array(
                               'rule' => 'notEmpty',
                               'message' => 'Required',
                               'required' => true,
                               'last' => true
                       ),
                       'maxLength' => array(
                               'rule' => array('maxLength', 20),
                               'message' => 'The credit card number must 20 characters or less.',
                               'last' => true
                       ),
                       'valid' => array(
                               'rule' => array('cc', 'fast', false, null),
                               'message' => 'The credit card number you supplied was invalid.'
                 )
            ) ,
            'cvv2Number' => array(
				'rule2' => array(
                    'rule' => 'numeric',
                    'message' => __l('Should be numeric') ,
                    'allowEmpty' => false
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
            'zip' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'address' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'city' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'state' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'country' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
			'subject' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ),
			'content' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            )
        );
	}
	 // check the new and confirm password
    function _checkPassword($field1 = array() , $field2 = null, $field3 = null){
        if ($this->data[$this->name][$field2] == $this->data[$this->name][$field3]) {
            return true;
			//echo 'hi';
        }
        return false;
    }	
	 function _checkOldPassword($field1 = array() , $field2 = null) 
    {
        $user = $this->find('first', array(
            'conditions' => array(
                 'pw_reset_string' => $this->data['User']['id']
            ) ,
            'recursive' => -1
        ));
        if (md5($this->data['User']['old_password']) == $user['User']['password']) {
            return true;
        }
        return false;
    }	
}