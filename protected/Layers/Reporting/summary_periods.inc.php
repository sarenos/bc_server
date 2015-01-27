<?php
/**************************************************************
* Project  : Movable-Ink Gen
* Name     : SummaryPeriods
* Version  : 1.0
* Date     : 2012-02-08
* Modified : $Id: summary_periods.inc.php,v 0601e61b2f77 2012/01/11 19:19:18 ForJest $
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/
class SummaryPeriods
{
/////////////////////////////////////////////////////////////////////////////

function SummaryPeriods()
{
     $this-> fill_all_periods();
}
/////////////////////////////////////////////////////////////////////////////

function get_modified_date($time_span)
{
     return strftime('%Y-%m-%d', strtotime($time_span));
}
///////////////////////////////////////////////////////////////////////////

function get_cur_hour()
{
     return strftime('%Y-%m-%d %H:59:59');
}
///////////////////////////////////////////////////////////////////////////

function get_modified_date_time($time_span)
{
     return strftime('%Y-%m-%d 00:00:00', strtotime($time_span));
}
///////////////////////////////////////////////////////////////////////////

function fill_all_periods()
{
     $old = setlocale(LC_ALL, 'ru_RU.UTF-8');
     $LangMonths = new LangMonths();
     
     $this-> named_periods = array(
        'today'=> array(
             'sy_name'=> 'today',
             'caption'=> ltrim(strftime('%d ' . $LangMonths->get_genitive(ltrim(strftime('%m'), '0')) . ' %Y'), '0'),
             'from'=> date('Y-m-d 00:00:00'),
             'to'=> date('Y-m-d 23:59:59'),
             ),
        
        'yesterday' => array(
             'sy_name'=> 'yesterday',
             'caption'=> ltrim(strftime('%d %B %Y', strtotime($this-> get_modified_date_time('-1 day'))), '0'),
             'from'=> $this-> get_modified_date_time('-1 day'),
             'to'=> $this-> get_modified_date_time('0 day'),
             ),
        'last_7_days' => array(
             'sy_name'=> 'last_week',
             'caption'=> 'Last 7 days',
             'from'=> $this-> get_modified_date_time('-7 day'),
             'to'=> $this-> get_cur_hour(),
             ),

        'this_month' => array(
             'sy_name'=> 'this_month',
             'caption'=> ucfirst(str_replace('я', 'ь', strftime('%B %Y', strtotime(date('Y-m-01 00:00:00'))))),
             'from'=> date('Y-m-01 00:00:00'),
             'to'=> $this-> get_cur_hour(),
             ),
        
        'last_month' => array(
             'sy_name'=> 'last_month',
             'caption'=> 'Last month',
             'from'=> strftime('%Y-%m-01 00:00:00', strtotime('-1 month')),
             'to'=> strftime('%Y-%m-01 00:00:00'),
             ),

        'last_year' => array(
             'sy_name'=> 'last_year',
             'caption'=> 'year',
             'from'=> $this-> get_modified_date_time('-1 year'),
             'to'=> $this-> get_cur_hour(),
             ),
        'all' => array(
             'sy_name'=> 'all',
             'caption'=> 'all',
             'from'=> '1998-01-01',
             'to'=> $this-> get_cur_hour(),
             ),
        );
        setlocale(LC_ALL, $old);
}
////////////////////////////////////////////////////////////////////////////

function is_registered_period($name)
{
     return isset($this-> named_periods[$name]);
}
///////////////////////////////////////////////////////////////////////////

function get_by_name($name)
{
     return $this-> named_periods[$name];
}
///////////////////////////////////////////////////////////////////////////

function get_all()
{
     return $this-> named_periods;
}
///////////////////////////////////////////////////////////////////////////

function get_list($names_list)
{
     $result = array();
     foreach ($names_list as $name)
     {
          if (!$this-> named_periods[$name])
          {
               continue;
          }
          $result[$name] = $this-> named_periods[$name];
     }
     return $result;
}
////////////////////////////////////////////////////////////////////////////

function get_form_list()
{
     $result = array();
     $keys = array('day', 'week', 'month', 'year', 'ever');
     foreach ($keys as $key)
     {
          $result[$key] = $this-> named_periods[$key];
     }
     return $result;
}
///////////////////////////////////////////////////////////////////////////

function get_today()
{
     return $this-> named_periods['today'];
}
///////////////////////////////////////////////////////////////////////////

function get_last_days_list($from, $cnt)
{
     $result = array();
     for ($i=$from; $i < ($from+$cnt); $i++)
     {
          $row = array(
          'sy_name'=> $this-> get_modified_date("-$i day"),
          'caption'=> $this-> get_modified_date("-$i day"),
          'from'=> $this-> get_modified_date("-$i day"),
          'to'=> $this-> get_modified_date("-$i day"),
          );
          $result["day_minus_$i"] = $row;
     }
     return $result;
}
///////////////////////////////////////////////////////////////////////////

function get_last_7_days_list()
{
     return $this-> get_last_days_list(1, 7);
}
///////////////////////////////////////////////////////////////////////////

function get_today_and_7_days_list()
{
     return array_merge(
          array('today'=> $this-> get_today()),
          $this-> get_last_7_days_list()
     );
}
///////////////////////////////////////////////////////////////////////////

function get_admin_users_summary()
{
     return $this-> get_today_and_7_days_list();
}
///////////////////////////////////////////////////////////////////////////
}//class ends here
?>