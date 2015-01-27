<?php
/**************************************************************
* Project  : Movable-Ink Gen
* Name     : HTTPBrowser
* Version  : 1.0
* Date     : 2005.12.30
* Modified : $Id: browser.inc.php,v 0601e61b2f77 2012/01/11 19:19:18 ForJest $
* Author   : forjest@gmail.com
***************************************************************
*
*
*
*/
define('HTTP_BROWSER_DEFAULT_TIMEOUT', 30);
define('HTTP_BROWSER_DEFAULT_USER_AGENT', "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)");
define('HTTP_BROWSER_DEFAULT_DATA_DIR', ABS_PATH.'/data/cookies');

class HTTPBrowser
{
/////////////////////////////////////////////////////////////////////////////

function HTTPBrowser()
{
     $this-> set_user_agent(HTTP_BROWSER_DEFAULT_USER_AGENT);
     $this-> set_timeout(HTTP_BROWSER_DEFAULT_TIMEOUT);
     $this-> set_data_dir(HTTP_BROWSER_DEFAULT_DATA_DIR);
     $this-> reset_headers();
     $this-> with_cookies();
     $this-> with_redirects();
     $this-> no_ssl_verify();
     $this-> blank();

     $this-> page_size = 0;
     $this-> set_proxy_userpwd('');
}
///////////////////////////////////////////////////////////////////////////

function blank()
{
     $this-> set_referer('');
     $this-> regenerate_uniq();
     $this-> set_post(array());
}
///////////////////////////////////////////////////////////////////////////

function set_user_agent($user_agent)
{
     $this-> user_agent = $user_agent;
}
function get_user_agent()
{
     return $this-> user_agent;
}
//////////////////////////////////////////////////////////////////////////

function set_timeout($timeout)
{
     $this-> timeout = $timeout;
}
function get_timeout()
{
     return $this-> timeout;
}
//////////////////////////////////////////////////////////////////////////

function set_referer($referer)
{
     $this-> referer = $referer;
}
function get_referer()
{
     return $this-> referer;
}
//////////////////////////////////////////////////////////////////////////

function set_url($url)
{
     $this-> url = $url;
}
function get_url()
{
     return $this-> url;
}
//////////////////////////////////////////////////////////////////////////

function set_proxy($proxy)
{
     $this-> proxy = $proxy;
}
//////////////////////////////////////////////////////////////////////////

function set_proxy_userpwd($usrpwd)
{
     $this-> proxy_usrpwd = $usrpwd;
}
//////////////////////////////////////////////////////////////////////////

function set_data_dir($data_dir)
{
     $this-> data_dir = $data_dir;
}
//////////////////////////////////////////////////////////////////////////

function get_data_dir()
{
     return $this-> data_dir;
}
//////////////////////////////////////////////////////////////////////////

function get_error_message()
{
     return $this-> error_message;
}
function has_error()
{
     return (bool)$this-> error_no;
}
function get_error_no()
{
     return $this-> error_no;
}
///////////////////////////////////////////////////////////////////////////

function set_uniq($uniq)
{
     $this-> uniq = $uniq;
}
function get_uniq()
{
     return $this-> uniq;
}
function regenerate_uniq()
{
     $this-> set_uniq(time().'-'.md5(uniqid(rand(), true)));
}
//////////////////////////////////////////////////////////////////////////

function set_post($PostVars)
{
     $this-> post_data = '';
     foreach($PostVars as $key=> $val)
     {
          $this-> post_data .= urlencode($key).'='.urlencode($val).'&';
     }
     $this-> post_data = trim($this-> post_data, '&');
}
////////////////////////////////////////////////////////////////////////////

function with_cookies()
{
     $this-> cookies_enabled = true;
}

function no_cookies()
{
     $this-> cookies_enabled = false;
}
///////////////////////////////////////////////////////////////////////////

function with_redirects()
{
     $this-> redirects_enabled = 1;
}
///////////////////////////////////////////////////////////////////////////

function no_redirects()
{
     $this-> redirects_enabled = 0;
}
///////////////////////////////////////////////////////////////////////////

function with_ssl_verify()
{
     $this-> ssl_verify_enable = true;
}
///////////////////////////////////////////////////////////////////////////

function no_ssl_verify()
{
     $this-> ssl_verify_enable = false;
}
///////////////////////////////////////////////////////////////////////////

function get_page()
{
     return $this-> page;
}
///////////////////////////////////////////////////////////////////////////

function get_page_size()
{
     return strlen($this-> get_page());
}
///////////////////////////////////////////////////////////////////////////

function reset_headers()
{
     $this-> headers = array();
}

function add_header($header)
{
     $this-> headers[] = $header;
}

function set_headers($headers)
{
     $this-> headers = $headers;
}

function get_headers()
{
     return $this-> headers;
}
///////////////////////////////////////////////////////////////////////////

function set_proxy_config($proxy)
{
     $this-> proxy = $proxy;
}
//////////////////////////////////////////////////////////////////////////

function get_status_code()
{
     return $this-> status_code;
}
///////////////////////////////////////////////////////////////////////////

function is_redirect()
{
     return in_array($this-> status_code, array(301, 302, 303, 307));
}

function get_redirect_url()
{
     return $this-> redirect_url;
}
///////////////////////////////////////////////////////////////////////////

function parse_result($response)
{
     $this-> response_headers = '';
     $this-> redirect_url = '';
     $this-> status_code = 0;
     @list($this-> response_headers, $this-> page) = explode("\r\n\r\n", $response, 2);
     if (preg_match('/HTTP\/(\d+\.\d+)\s+(.*?)\s/i', $this-> response_headers, $M))
     {
         $this-> status_code = (int)$M[2];
     }
     if (preg_match('/Location:\s*(.*)/i', $this-> response_headers, $M))
     {
          $this-> redirect_url = trim($M[1]);
     }
     if ($this-> is_redirect() && $this-> redirects_enabled)
     {
          $this-> parse_result($this-> page);
     }
}
///////////////////////////////////////////////////////////////////////////

function delete_my_cookie()
{
     $this-> delete_cookie($this-> uniq);
}
///////////////////////////////////////////////////////////////////////////

function delete_cookie($uniq)
{
     $filename = $this-> get_data_dir().'/'.$uniq.'.txt';
     if (file_exists($filename))
     {
          unlink($filename);
     }
}
///////////////////////////////////////////////////////////////////////////

function get_cookie_contents()
{
     return (string)@file_get_contents($this-> get_data_dir().'/'.($this-> uniq).'.txt');
}
///////////////////////////////////////////////////////////////////////////

function request()
{
     $this-> handle = curl_init();
     curl_setopt($this-> handle, CURLOPT_URL, $this-> url);
     curl_setopt($this-> handle, CURLOPT_REFERER, $this-> referer);
     curl_setopt($this-> handle, CURLOPT_USERAGENT, $this-> user_agent);
     curl_setopt($this-> handle, CURLOPT_FAILONERROR, 0);
     curl_setopt($this-> handle, CURLOPT_FOLLOWLOCATION, $this-> redirects_enabled);
     curl_setopt($this-> handle, CURLOPT_RETURNTRANSFER, 1); 
     curl_setopt($this-> handle, CURLOPT_TIMEOUT, $this-> timeout);
     curl_setopt($this-> handle, CURLOPT_SSL_VERIFYPEER, $this-> ssl_verify_enable);

     if ($this-> cookies_enabled)
     {
          curl_setopt($this-> handle, CURLOPT_COOKIEFILE, $this-> data_dir.'/'.$this-> uniq.".txt");
          curl_setopt($this-> handle, CURLOPT_COOKIEJAR,  $this-> data_dir.'/'.$this-> uniq.".txt");
     }
     curl_setopt($this-> handle, CURLOPT_HEADER,  1);
     curl_setopt($this-> handle, CURLOPT_HTTPHEADER, $this-> headers);

     if (!empty($this-> post_data))
     {
          curl_setopt($this-> handle, CURLOPT_POST, 1);
          curl_setopt($this-> handle, CURLOPT_POSTFIELDS, $this-> post_data);
     }
     if (!empty($this-> proxy))
     {
          curl_setopt($this-> handle, CURLOPT_PROXY, $this-> proxy);
     }
     if (!empty($this-> proxy_usrpwd))
     {
          curl_setopt($this-> handle, CURLOPT_PROXYUSERPWD, $this-> proxy_usrpwd);
     }
     $this-> parse_result(curl_exec($this-> handle));
     
     $this-> error_no = curl_errno($this-> handle);
     $this-> error_message = curl_error($this-> handle);
     if ($this-> status_code >= 400)
     {
          $this-> error_no = "status:".$this-> status_code;
          $this-> error_message = "Server returned: ".$this-> status_code;
          $this-> page = '';
     }
     $this-> page_size = curl_getinfo($this-> handle, CURLINFO_SIZE_DOWNLOAD);
     curl_close($this-> handle);

     if (!$this-> error_no)
     {
          $this-> set_referer($this-> get_url());
     }
     return !$this-> error_no;
}
///////////////////////////////////////////////////////////////////////////
}//class ends here
?>