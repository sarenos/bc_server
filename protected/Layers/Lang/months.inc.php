<?php
/**************************************************************
* Project  : 
* Name     : LangMonths
* Version  : 1.0
* Date     : 2010.06.28
* Modified : $Id$
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/

class LangMonths
{
/////////////////////////////////////////////////////////////////////////////

function __construct()
{
     $this-> Months = array(
          1=> 'январь', 'февраль', 'март', 'апрель', 'май', 'июнь', 'июль',
          'август', 'сентябрь', 'октябрь', 'ноябрь', 'декабрь');
     
     $this-> GenitiveMonths = array(
          1=> 'января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля',
          'августа', 'сентября', 'октября', 'ноября', 'декабря');
}
///////////////////////////////////////////////////////////////////////////

function get_by_date($date)
{
     if (!($stamp = strtotime($date)))
     {
          return '';
     }
     return $this-> get(date('n', $stamp));
}
///////////////////////////////////////////////////////////////////////////

function get_by_date_genitive($date)
{
     if (!($stramp = strtotime($date)))
     {
          return '';
     }
     return $this-> get(date('n', $stramp));
}
///////////////////////////////////////////////////////////////////////////

function get_by_date_genitive_full($date)
{
     if (!($stramp = strtotime($date)))
     {
          return '';
     }
     $day = date('j', $stramp);
     $month = date('n', $stramp);
     $year = date('Y', $stramp);
     return $day . ' ' . $this->get_genitive($month) . ' ' . $year;
}
///////////////////////////////////////////////////////////////////////////

function get($month_num)
{
     return $this-> Months[$month_num];
}
///////////////////////////////////////////////////////////////////////////

function get_genitive($month_num)
{
     return $this-> GenitiveMonths[$month_num];
}
///////////////////////////////////////////////////////////////////////////

}