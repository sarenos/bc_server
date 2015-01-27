<?php
class ErrorCode
{
  private $_errorsDescriprions;
  
  public function __construct()
  {
      $this->_errorsDescriprions = array(
          '000000' => 'payment is successful',
          'CSRERR' => 'error, contact the support',
          'REQERR' => 'error, invalid required params',
          'DUPERR' => 'error, duplicate payment'       
      );
  }
  
  public function getDescription($key)
  {
      return (string)@$this->_errorsDescriprions[$key];
  }
}
?>
