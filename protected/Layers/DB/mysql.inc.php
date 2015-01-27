<?php
require_once LAYERS_DIR.'/Reporting/time_profiler.inc.php';
global $g_one_db;
$g_one_db = 0;
function produce_db($debug_mode = 'cfg', $new = false)
{
     global $Config, $g_one_db; 
     if (!empty($g_one_db) && !$new)
     {
          return $g_one_db;
     }
     if ($debug_mode == 'cfg')
     {
          $mode = $Config['db_debug_mode'];
     } 
     else
     {
          $mode = $debug_mode == 'on';
     } 
     if (!isset($Config['db_name']))
     {
          $db = new db();
     }
     else
     {
          $db = new db($Config['db_name'], $Config['db_host'], $Config['db_user'], $Config['db_pass'], $Config['db_persistent'], true);
     }
     $db->debug = $mode;
     if (!$new)
     {
          $g_one_db = $db;
     }
     return $db;
}

function kill_db()
{
     global $g_one_db;
     if (!empty($g_one_db))
     {
          $g_one_db-> close();
          $g_one_db = 0;
     }
}
///////////////////////////////////////////////////////////////////////////

class db
{
var $db_name;
var $b_newlink;
var $link;
var $host;
var $user;
var $password;

var $id_sql;
var $num_rows;
var $affected_rows;
var $num_fields;
var $result;
var $id_last;

var $error;
var $errorno;

var $debug;

var $fetch_mode; 
var $QueryTimer;
// --------------------------------------------------------------------
// Конструктор класса

// --------------------------------------------------------------------
function db($db_name = "", $host = "localhost", $user = "",
            $password = "", $is_persistent = false, $b_newlink = false)
{
     $this-> QueryTimer = new TimeProfiler();
     $this->db_name = $db_name;
     $this->host = $host;
     $this->user = $user;
     $this->password = $password;
     $this->b_newlink = $b_newlink;
     $this->fetch_mode = MYSQL_ASSOC;
     $this->is_persistent = $is_persistent;
     $this->connect();

     return true;
} 
// ------------------          END          --------------------------
// --------------------------------------------------------------------
// 

// --------------------------------------------------------------------
function connect()
{
     $connect_function = 'mysql_connect';
     if ($this-> is_persistent)
     {
          $connect_function = 'mysql_pconnect';
     }
     if (!($this->link = @$connect_function($this->host, $this->user,
                    $this->password, $this-> b_newlink)))
     {
          print " Error mysql connect !";
          exit();
     } 

     if (!mysql_select_db($this->db_name, $this->link))
     {
          die ("Can't select DB " . $this->db_name);
     }
     $this-> exec_query("SET NAMES utf8");
} 

function close()
{
     mysql_close($this->link);
     $this->link = null;
} 
// ------------------          END          --------------------------
// --------------------------------------------------------------------
// Функция выполняет sql запрос к базе данный
// передаваемый параметр строка запроса
// --------------------------------------------------------------------

function clear_old_result()
{
     @mysql_free_result($this->id_sql);
     $this->num_rows = false;
     $this->affected_rows = false;
     $this->id_last = false;
}
/////////////////////////////////////////////////////////////////////////////

function get_last_query()
{
     return $this-> last_query;
}
///////////////////////////////////////////////////////////////////////////

function get_error_message()
{
     return $this-> error;
}
///////////////////////////////////////////////////////////////////////////

function exec_query($query)
{
     $this-> QueryTimer-> start();
     $this-> clear_old_result();
     $this-> id_sql = @mysql_query($query, $this->link);
     $this-> error = @mysql_error($this->link);
     $this-> error_no = @mysql_errno($this->link);
     $this-> last_query = $query;

     if (!($this->error_no))
     {
          if (!is_bool($this->id_sql))
          {
               $this->num_rows = @mysql_num_rows($this->id_sql);
          }
          $this->affected_rows = @mysql_affected_rows($this->link);
          $this->id_last = @mysql_insert_id($this->link);
     } 
     $this-> QueryTimer-> stop();
     if ($this->debug)
     {
          print "Query text (".sprintf("%.4f sec", $this-> QueryTimer-> get_last())."): ";
          print $query . "<br/>";
          if ($this->error_no)
          {
               print "<b>Error in query : ";
               print $this->error . "</b><br/>";
          } 
          else
          {
               print "Query : OK<br/>";
          } 
     }
     if ($this->error_no)
     {
         throw new Exception('Error in query: ' . $this->error, 2);
     }

     return !$this->error_no;
} 
// ------------------          END          --------------------------
// --------------------------------------------------------------------
// Возвращает следующие значение из сделанного запроса

// --------------------------------------------------------------------
function get_data()
{
     $sql = $this->id_sql;

     $result = @mysql_fetch_array($sql, $this->fetch_mode);
     $this->error = @mysql_error($this->link);
     $this->error_no = @mysql_errno($this->link);

     $this->result = $result;

     if ($this->debug)
     {
          if ($this->error_no)
          {
               print "<b>Error in get_data :";
               print $this->error . "</b><br>";
          } 
     } 
     return $result;
} 
////////////////////////////////////////////////////////////////////////////
 
function escape_str($str)
{
     return mysql_escape_string($str);
} 
////////////////////////////////////////////////////////////////////////////

function freeze_debug()
{
     $this->store_debug = $this->debug;
     $this->debug = false;
} 
////////////////////////////////////////////////////////////////////////////

function debugon()
{
     $this->store_debug = $this->debug;
     $this->debug = true;
} 
////////////////////////////////////////////////////////////////////////////

function restore_debug()
{
     $this->debug = $this-> store_debug;
} 
////////////////////////////////////////////////////////////////////////////

function get_int_ids($list)
{
     $result = array();
     foreach ($list as $id)
     {
          if ((int)$id)
          {
               $result[] = (int)$id;
          } 
     } 
     return $result;
} 
////////////////////////////////////////////////////////////////////////////

function get_in_list($list)
{
     return implode(', ', $list);
}
///////////////////////////////////////////////////////////////////////////

function get_all_data()
{
     $result = array();
     while ($row = $this-> get_data())
     {
          $result[] = $row;
     }
     return $result;
}
////////////////////////////////////////////////////////////////////////////

function get_all_data_indexed($key = '')
{
     $result = array();
     while ($row = $this-> get_data())
     {
          $result[$row[$key]] = $row;
     }
     return $result;
}
///////////////////////////////////////////////////////////////////////////

function get_one()
{
     if (!$this-> num_rows)
     {
          return null;
     }
     $result = $this-> get_data();
     return reset($result);
}
/////////////////////////////////////////////////////////////////////////////

} //class ends here

?>