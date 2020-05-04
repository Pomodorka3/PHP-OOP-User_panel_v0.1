<?php
class Validation
{
    private $_passed = false,
            $_errors = array(),
            $_db = null;

    public function __construct(){
        $this->_db = DB::getInstance();
    }

    //Validates recieved parameters
    public function check($source, $items = array())
    {
        foreach ($items as $item => $rules) {
            foreach ($rules as $rule => $rule_val) {
                // echo "{$item} {$rule} must be {$rule_val}<br>";
                $value = trim($source[$item]);
                $item = escape($item);
                
                if ($rule === 'required' && empty($value)) {
                    $this->addError("{$item} is required");
                } elseif (!empty($value)) {
                    switch ($rule) {
                        case 'min':
                            if (strlen($value) < $rule_val) {
                                $this->addError("{$item} must be a minimum of {$rule_val}");
                            }
                            break;
                        case 'max':
                            if (strlen($value) > $rule_val) {
                                $this->addError("{$item} must be a maximum of {$rule_val}");
                            }
                            break;    
                        case 'matches':
                            if ($value != $source[$rule_val]) {
                                $this->addError("{$rule_val} must match {$item}");
                            }
                            break;
                        case 'unique':
                            $check = $this->_db->get($rule_val, array($item, '=', $value));
                            if ($check->count()) {
                                $this->addError("{$item} already exists");
                            }
                            break;
                        default:
                            # code...
                            break;
                    }
                }
            }
        }

        if (empty($this->_errors)) {
            $this->_passed = true;
        }
    }

    //Adds errors
    private function addError($error)
    {
        $this->_errors[] = $error;
    }

    //Gets errors
    public function errors()
    {
        return $this->_errors;
    }

    //Checks whether validation was successfully passed
    public function passed()
    {
        return $this->_passed;
    }
}