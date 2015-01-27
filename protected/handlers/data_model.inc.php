<?php
/**************************************************************
* Project  : 
* Name     : DataModel
* Version  : 1.0
* Date     : 2008.02.02
* Modified : $Id$
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/
require_once LAYERS_DIR.'/Paging/paged_model.inc.php';

class DataModel extends PagedModel
{
protected $HeapDataProvider = null;
protected $HeapDataArray    = array();
protected $need_redirect    = false;
/////////////////////////////////////////////////////////////////////////////

function need_redirect()
{
     return $this-> need_redirect;
}
/////////////////////////////////////////////////////////////////////////////

function get_redirect_url()
{
     if (!empty($this-> redirect_url))
     {
          return $this-> redirect_url;
     }
     return $_SERVER['REQUEST_URI'];
}
///////////////////////////////////////////////////////////////////////////

function set_heap_data_provider($Provider)
{
     $this-> HeapDataProvider = $Provider;
}
///////////////////////////////////////////////////////////////////////////

function set_heap_data($HeapData)
{
     $this-> HeapDataArray = $HeapData;
}
///////////////////////////////////////////////////////////////////////////

function get_heap_data()
{
     if (is_object($this-> HeapDataProvider))
     {
          return $this-> HeapDataProvider-> get();
     }
     return $this-> HeapDataArray;
}
////////////////////////////////////////////////////////////////////////////
}//class ends here
?>