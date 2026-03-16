<?php
/**
 * Validation Class
 */

class Validation {
    protected $errors = [];
    protected $data = [];
    
    /**
     * Validate data
     */
    public function validate($data, $rules) {
        $this->data = $data;
        $this->errors = [];
        
        foreach ($rules as $field => $rule) {
            $rulesList = explode('|', $rule);
            
            foreach ($rulesList as $singleRule) {
                $this->applyRule($field, $singleRule);
            }
        }
        
        return empty($this->errors);
    }
    
    /**
     * Apply single validation rule
     */
    protected function applyRule($field, $rule) {
        $value = isset($this->data[$field]) ? $this->data[$field] : '';
        
        // Check for rule with parameter
        if (strpos($rule, ':') !== false) {
            list($ruleName, $parameter) = explode(':', $rule);
        } else {
            $ruleName = $rule;
            $parameter = null;
        }
        
        switch ($ruleName) {
            case 'required':
                if (empty($value)) {
                    $this->addError($field, "Field {$field} harus diisi");
                }
                break;
                
            case 'email':
                if (!empty($value) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addError($field, "Format email tidak valid");
                }
                break;
                
            case 'numeric':
                if (!empty($value) && !is_numeric($value)) {
                    $this->addError($field, "Field {$field} harus berupa angka");
                }
                break;
                
            case 'min':
                if (strlen($value) < $parameter) {
                    $this->addError($field, "Field {$field} minimal {$parameter} karakter");
                }
                break;
                
            case 'max':
                if (strlen($value) > $parameter) {
                    $this->addError($field, "Field {$field} maksimal {$parameter} karakter");
                }
                break;
                
            case 'matches':
                if ($value !== ($this->data[$parameter] ?? '')) {
                    $this->addError($field, "Field {$field} harus sama dengan {$parameter}");
                }
                break;
                
            case 'unique':
                // Implementasi unique validation dengan database
                break;
                
            case 'date':
                if (!empty($value) && !strtotime($value)) {
                    $this->addError($field, "Format tanggal tidak valid");
                }
                break;
                
            case 'alpha':
                if (!empty($value) && !ctype_alpha(str_replace(' ', '', $value))) {
                    $this->addError($field, "Field {$field} hanya boleh berisi huruf");
                }
                break;
                
            case 'alpha_numeric':
                if (!empty($value) && !ctype_alnum(str_replace(' ', '', $value))) {
                    $this->addError($field, "Field {$field} hanya boleh berisi huruf dan angka");
                }
                break;
        }
    }
    
    /**
     * Add error message
     */
    protected function addError($field, $message) {
        if (!isset($this->errors[$field])) {
            $this->errors[$field] = [];
        }
        
        $this->errors[$field][] = $message;
    }
    
    /**
     * Get all errors
     */
    public function errors() {
        return $this->errors;
    }
    
    /**
     * Get first error for field
     */
    public function first($field) {
        return isset($this->errors[$field][0]) ? $this->errors[$field][0] : '';
    }
    
    /**
     * Check if has errors
     */
    public function hasErrors() {
        return !empty($this->errors);
    }
    
    /**
     * Get all error messages as string
     */
    public function errorString() {
        $messages = [];
        
        foreach ($this->errors as $field => $fieldErrors) {
            foreach ($fieldErrors as $error) {
                $messages[] = $error;
            }
        }
        
        return implode('<br>', $messages);
    }
}
?>