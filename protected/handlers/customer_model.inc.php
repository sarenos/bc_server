<?php

class CustomerModel extends MainModel
{
     ///////////////////////////////////////////////////////////////////////////////
    
     function __construct()
     {
          parent::__construct();
     }
     ///////////////////////////////////////////////////////////////////////////////

     function run()
     {
/*          if (!$this-> CustomerAuth-> is_logged())
          {
               $this-> redirect_to_login();
               return false;
          }
*/
          parent::run();

          return true;
     }
     ////////////////////////////////////////////////////////////////////////////
}//class ends here
?>
