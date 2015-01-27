<?php
/**************************************************************
* Project  : Movable-Ink Gen
* Name     : TimeProfiler
* Version  : 1.0
* Date     : 2008.05.14
* Modified : $Id: time_profiler.inc.php,v 0601e61b2f77 2012/01/11 19:19:18 ForJest $
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/

class TimeProfiler
{
protected $time_start = 0;
protected $time_finish= 0;
protected $last_elapsed = 0;
protected $total_elapsed = 0;
/////////////////////////////////////////////////////////////////////////////

function get_last()
{
     return $this-> last_elapsed;
}
function get_total()
{
     return $this-> total_elapsed;
}
///////////////////////////////////////////////////////////////////////////

function start()
{
     $this-> time_start = microtime(true);
}
///////////////////////////////////////////////////////////////////////////

function stop()
{
     $this-> time_finish = microtime(true);
     $this-> last_elapsed = $this-> time_finish - $this-> time_start;
     $this-> total_elapsed += $this-> last_elapsed;
     return $this-> last_elapsed;
}
///////////////////////////////////////////////////////////////////////////

function reset_stats()
{
     $this-> last_elapsed  = 0;
     $this-> total_elapsed = 0;
}
///////////////////////////////////////////////////////////////////////////
}//class ends here
?>