<?php
function smarty_function_js_init($params, $template)
{
     $f_name = (string)@$params['function'];
     if (empty($f_name))
     {
          return '';
     }
     return 
     '<script type="text/javascript">
          sys_page_init_function = "'.$f_name.'";
     </script>';
}
///////////////////////////////////////////////////////////////////////////
