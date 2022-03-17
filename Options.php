<?php

class Options {
  var $anzahlZeichen;
  var $mitZahlen;
  var $mitSonderzeichen;

  const OKAY = '1';
  const NOTOKAY = '0';
  const TRUE = '1';
  const FALSE = '0';
  const ZAHLENSTRING = '1234567890';
  const SONDERZEICHENSTRING = '!$%&.-+';
  const PERMITTEDCHARS = 'aAbBcCdDeEfFgGhHiIjJkKlLmMnNoOpPqQrRsStTuUvVwWxXyYzZ';
  const CHARACTER_MIN = 4;
  const CHARACTER_MAX = 32;
  const NOTFOUND = 0;

  /**
   * Constructor of the class
   */
  function __construct($anzahlZeichen, $mitZahlen, $mitSonderzeichen) {
    $this->anzahlZeichen = $anzahlZeichen;
    $this->mitZahlen = $mitZahlen;
    $this->mitSonderzeichen = $mitSonderzeichen;
  }

  /**
   * Method to generate a random password depending on the selected options.
   */
  function generatePassword($options) {
    $permitted_chars = self::PERMITTEDCHARS;

    if ($options->mitZahlen == self::TRUE) {
      $permitted_chars = $permitted_chars . self::ZAHLENSTRING;
      str_shuffle($permitted_chars);
    }

    if ($options->mitSonderzeichen == self::TRUE) {
      $permitted_chars = $permitted_chars . self::SONDERZEICHENSTRING;
      str_shuffle($permitted_chars);
    }

    return substr(str_shuffle($permitted_chars), 0, $options->anzahlZeichen);
  }

  /**
   * Method that checks whether the password meets the specifications. This also includes that the password must not have 
   * any special characters at the beginning or end. Furthermore, if there is a 0 and an upper O a new password will be generated.
   */
  function isPasswortOkay($password) {

    $result = self::OKAY;

    // Check if the password starts with a special character
    if ($result == self::OKAY) {
      $array = str_split(self::SONDERZEICHENSTRING);

      foreach ($array as $char) {
         if ($password[0] == $char) {
           return self::NOTOKAY;
           
          }
       }
    }

    // Check if the password ends with a special character
    if ($result == self::OKAY) {
      $lastChr = $password[strlen($password)-1];
      $array = str_split(self::SONDERZEICHENSTRING);

      foreach ($array as $char) {
        if ($lastChr == $char) {
          return self::NOTOKAY;
         }
      }
    }

    // If a password with special characters is selected, it should also be ensured that the password contains one (if the length allows it)! 
    // We have letters, numbers and special characters - so the password must be AT LEAST 3 characters long. But since we say that no special 
    // characters are allowed at the beginning or end, the PW must be at least 4 characters long (so that there can still be numbers and letters 
    // in the middle)!
    if ($result == self::OKAY) {
      if ($this->mitSonderzeichen == self::TRUE && $this->anzahlZeichen >= 4) {

        $sizeOfPassword = strlen($password);
        $sizeOfFoundString = strlen(strpbrk($password, self::SONDERZEICHENSTRING));

        var_dump('Size of Password: ' . $sizeOfPassword . ' Size of FoundString: ' . $sizeOfFoundString);

        // if the length is 0 no special character was found in the string!
        if ($sizeOfFoundString === self::NOTFOUND) {
          return self::NOTOKAY;
        }
      } 
      
      if ($this->mitZahlen == self::TRUE && $this->anzahlZeichen >= 3) {

        $sizeOfPassword = strlen($password);
        $sizeOfFoundString = strlen(strpbrk($password, self::ZAHLENSTRING));

        // if the length is 0 no number was found in the string!
        if ($sizeOfFoundString === self::NOTFOUND) {
          return self::NOTOKAY;
        }
      }

      if ($result == self::OKAY) {
        // Check if the password contains a 0 (zero) AND an O (upper o) (generate a new one to avoid misinterpretation)
        if (strlen(strpbrk($password, 0)) > 0 && strlen(strpbrk($password, 'O')) > 0) {
          return self::NOTOKAY;
        }
      }

      return self::OKAY;
    }
  }
}
?>