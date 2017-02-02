<?php

    function input_check($value, $num) {
        // check for blank
        if (is_blank($value)) {
            return fieldName($num) . " cannot be blank.";
        }
        
        // check for valid charactors
        if ($num < 2) {
            if (!preg_match('/\A[A-Za-z\s\-,\.\']+\Z/', $value)) {
                return fieldName($num) . " only allows letters, spaces, symbols: - , . '";
            }
        } else if ($num == 2) {
            if (!preg_match('/\A[A-Za-z0-9_@\.]+\Z/', $value)) {
                return "Email only allows letters, numbers, symbols: _ @ .";
            }
        } else {
            if (!preg_match('/\A[A-Za-z0-9_]+\Z/', $value)) {
                return "Username only allows letters, numbers, symbols: _";
            }
        }
        
        // check for length
        if (!has_correct_length($value, $num)) {
            // Username
            if ($num == 3) {
                return fieldName($num) . " must be between 8 and 255 characters.";
            }
            // the rest
            return fieldName($num) . " must be between 2 and 255 characters.";
        }
        
        // Email check
        if($num == 2 && !has_valid_email_format($value)) {
            return "Email must be a valid format.";
        }
        return "null";
        
    }
  // is_blank('abcd')
  function is_blank($value='') {
      return $value == '';
  }


  // has_LE_255_length('abcd', 1) => num = 3 => username
  function has_correct_length($value, $num) {
      $len = strlen($value);
      if ($len <= 255) {
          if ($num == 3) {
              return $len >= 8;
          }
          else {
              return $len >= 2;
          }
      }
      return false;
  }

    // greater than or equal to the limit
  function has_GE_length($len, $lim) {
      return ($len >= $lim);
  }

    // has_valid_email_format('test@test.com')
    function has_valid_email_format($value) {
        if (strpos($value, '@') !== false) {
            return true;
        }
        return false;
    }
    
  function fieldName($num) {
      if ($num == 0) {
          return "First name";
      } else if ($num == 1) {
          return "Last name";
      } else if ($num == 2) {
          return "Email";
      } else {
          return "Username";
      }
  }
?>
