<?php

class Validation
{
    private $_passed = false,
            $_errors = array(),
            $_db = null;
    
    public function __construct()
    {
        //$this->_db = DB::getInstance();
    }
    
    public function check($source, $items = array())
    {
        foreach($items as $item => $rules)
        {
            $item = escape($item);
            foreach($rules as $rule => $rule_value)
            {
               $value = trim($source[$item]);
               if($rule === 'name')
               {
                   $name = $rule_value;
               }
               if($rule === 'required' && empty($value))
               {
                   $name = lcfirst($name);
                   $this->addError("Поле {$name} обязательно для заполнения по правилу {$rule_value}");
               }
               else if(!empty($value))
               {
                   switch ($rule)
                   {
                       case 'mail_filter':
                           if(!filter_var($value, FILTER_VALIDATE_EMAIL))
                           {
                               $this->addError("{$name} в неправильном формате");
                           }
                           break;
                       case 'min':
                           if(strlen($value) < $rule_value)
                           {
                               $this->addError("{$name} должен иметь минимум {$rule_value} знаков");
                           }
                           break;
                       case 'max':
                           if(strlen($value) > $rule_value)
                           {
                               $this->addError("{$name} может иметь максимум {$rule_value} знаков"); 
                           }
                           break;
                       case 'letters_numbers':
                           if (!preg_match('/[A-Z]/', $value) || !preg_match('/[0-9]/', $value) || !preg_match('/[a-z]/', $value))
                            {
                                $this->addError("{$name} должен содержать хотя бы одну цифру и хотя бы одну заглавную и строчную буквы");
                            }
                            break;
                       case 'matches':
                           if($value != $source[$rule_value])
                           {
                               $this->addError("'{$name}' должен быть таким же, как {$rule_value}"); 
                           }
                           break;
                       /*case 'unique':
                           try{
                                $check = $this->_db->get($rule_value,array(array($item, '=', $value)));
                           } catch (Exception $ex) {
                                echo $ex->getMessage();
                           }
                           
                           if($check->count())
                           {
                               $this->addError("{$name} postoji u bazi podataka");
                           }
                           break; */
                   }
               }
               
            }
        }
        
        if(empty($this->_errors))
        {
            $this->_passed = true;
        }
        
        return $this;
    }
    
    private function addError($error)
    {
        $this->_errors[] = $error;
    }
           
    public function errors()
    {
        return $this->_errors;
    }
    
    public function passed()
    {
        return $this->_passed;
    }
}

