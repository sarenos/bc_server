<?php
/***********************************************************
* Project  :
* Name     : EmailFilesList
* Modified : $Id$
* Author   : forjest@gmail.com
************************************************************
*
*
*
*/
class EmailFilesList 
{

function __construct()
{
     $this-> db = produce_db();
}
///////////////////////////////////////////////////////////////////////////////

function get_list()
{
     $this-> db-> exec_query("
     SELECT *, CONCAT('".HTTP_STATIC_PATH."/files/', filename) AS url FROM crm_email_file
     ");

     $result = $this-> db-> get_all_data_indexed('condition');
     return $result;
}
////////////////////////////////////////////////////////////////////////////

function get_by_diag($diag)
{
     if (empty($this-> AllFiles))
     {
          $this-> AllFiles = $this-> get_list();
     }
     
     $result = array();

     foreach (explode(',', $diag) as $condition)
     {
          $condition = trim($condition);
          if (empty($this-> AllFiles[$condition]))
          {
               continue;
          }
          $result[] = $this-> AllFiles[$condition];
     }
     return $result;
}
////////////////////////////////////////////////////////////////////////////

}//class ends here
?>
