<?php
/***********************************************************
* Project  :
* Name     : ManagerEmailsFollowUp
* Modified : $Id$
* Author   : forjest@gmail.com
************************************************************
*
*
*
*/
define('FOLLOW_UP_MANAGER_MAX_RUNS', 200);
require_once LAYERS_DIR.'/Mail/templated.inc.php';
require_once LAYERS_DIR.'/Clients/clients_list.inc.php';

class ManagerEmailsFollowUp 
{

function __construct()
{
     $this-> db = produce_db();
     $this-> Mailer = new MailTemplated();
     $this-> Lister = new ClientsList();
}
///////////////////////////////////////////////////////////////////////////////

function iteration()
{
     $this-> db-> exec_query("
     SELECT * FROM crm_client
     WHERE d_info_sent BETWEEN '2000-01-01' AND NOW() - INTERVAL ".FOLLOW_UP_EMAIL_DAYS." DAY
     LIMIT 1");
     if (!$this-> db-> num_rows)
     {
          return false;
     }
     
     $Client = $this-> db-> get_data();
     if (empty($Client['email']))
     {
          
          return true;
     }
     
     $this-> Mailer-> set_to($Client['email']);
     $this-> Mailer-> set_data(array('Client'=> $Client));
     $this-> Mailer-> run();
     
     $this-> Lister-> update_sent_date(array($Client['id']));
     return true;
}
////////////////////////////////////////////////////////////////////////////

function init_mailer()
{
     $this-> Mailer-> set_template('predef:client_follow_up');
     $this-> Mailer-> set_from(EMAIL_SYSTEM_FROM);
}
////////////////////////////////////////////////////////////////////////////

function run()
{
     $this-> init_mailer();
     for ($i=0; $i < FOLLOW_UP_MANAGER_MAX_RUNS; $i++)
     {
          if (!$this-> iteration())
          {
               break;
          }
     }
}
////////////////////////////////////////////////////////////////////////////
}//class ends here
?>
