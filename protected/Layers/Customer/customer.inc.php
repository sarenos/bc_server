<?php 
/************************************************************** 
* Project  :  
* Name     : GMCustomer 
* Version  : 1.0 
* Date     : 2011.09.30 
* Modified : $Id$ 
* Author   : forjest@gmail.com 
*************************************************************** 
* 
* 
* 
*/ 
require_once LAYERS_DIR.'/Walkers/set_input_data.inc.php';
require_once LAYERS_DIR.'/Entity/entity_with_db.inc.php'; 

class DCCustomer extends EntityWithDB 
{ 
///////////////////////////////////////////////////////////////////////////// 

function &get_all_fields_instances() 
{ 
	$result['user_id']						= new FieldInt();

     $result['user_name']                         = new FieldString();
     $result['user_name']-> set_max_length(50);
	
	$result['company']						= new FieldString();
	$result['company']-> set_max_length(50);

	$result['first_name']					= new FieldString();
	$result['first_name']-> set_max_length(50);
     
     $result['password_hash']                     = new FieldString();
     $result['password_hash']-> set_max_length(50);
     
     $result['web_crop_last_url']                 = new FieldString();
     $result['web_crop_last_url']-> set_max_length(50);

	$result['web_crop_last_image']			= new FieldString();
	$result['web_crop_last_image']-> set_max_length(50);
     
     $result['web_crop_offset_X']                 = new FieldInt();
     $result['web_crop_offset_Y']                 = new FieldInt();
     $result['web_crop_width']                    = new FieldInt();
     $result['web_crop_height']                   = new FieldInt();
     
     $result['twitter_oauth_token']               = new FieldString();
     $result['twitter_oauth_token']-> set_max_length(50);
     $result['twitter_oauth_token_secret']        = new FieldString();
     $result['twitter_oauth_token_secret']-> set_max_length(50);
     
     $result['twitter_last_html_preview_url']     = new FieldString();
     $result['twitter_last_html_preview_url']-> set_max_length(50);

	$result['twitter_screen_name']			= new FieldString();
	$result['twitter_screen_name']-> set_max_length(50);

	$result['countdown_preview_html_name']		= new FieldString();
	$result['countdown_preview_html_name']-> set_max_length(50);

	$result['hash']						= new FieldString();
	$result['hash']-> set_max_length(50);

	$result['text_width']					= new FieldInt();
	$result['text_height']					= new FieldInt();
	$result['text_left']					= new FieldInt();
	$result['text_top']						= new FieldInt();

	$result['fb_instance_id']				= new FieldInt();

     return $result; 
} 
///////////////////////////////////////////////////////////////////////////// 

function set_user_id($userId)
{
	$this-> Fields['user_id']-> set($userId);
}
///////////////////////////////////////////////////////////////////////////// 

function get_user_id_value()
{
	return $this-> Fields['user_id']-> get();
}
///////////////////////////////////////////////////////////////////////////// 

function is_admin()
{
	return $this-> Fields['user_id']-> get() == 1;
}
///////////////////////////////////////////////////////////////////////////// 

function set_password_hash($passwordHash)
{
	$this-> Fields['password_hash']-> set($passwordHash);
}
///////////////////////////////////////////////////////////////////////////// 

function get_password_hash_value()
{
	return $this-> Fields['password_hash']-> get();
}
///////////////////////////////////////////////////////////////////////////// 

function set_hash($hash)
{
	$this-> Fields['hash']-> set($hash);
}
///////////////////////////////////////////////////////////////////////////// 

function get_hash_value()
{
	return $this-> Fields['hash']-> get();
}
///////////////////////////////////////////////////////////////////////////// 

function set_countdown_preview_html_name($htmlName)
{
	$this-> Fields['countdown_preview_html_name']-> set($htmlName);
}
////////////////////////////////////////////////////////////////////////////

function get_countdown_preview_html_name_value()
{
	return $this-> Fields['countdown_preview_html_name']-> get();
}
///////////////////////////////////////////////////////////////////////////// 

function set_twitter_screen_name($screenName)
{
	$this-> Fields['twitter_screen_name']-> set($screenName);
}
///////////////////////////////////////////////////////////////////////////// 

function get_twitter_screen_name_value()
{
	return $this-> Fields['twitter_screen_name']-> get();
}
///////////////////////////////////////////////////////////////////////////// 

function set_web_crop_last_url($last_url)
{
     $this-> Fields['web_crop_last_url']-> set($last_url);
}
///////////////////////////////////////////////////////////////////////////// 

function get_web_crop_last_url_value()
{
     return $this-> Fields['web_crop_last_url']-> get();
}
///////////////////////////////////////////////////////////////////////////// 

function set_twitter_oauth_token($twitter_oauth_token)
{
     $this-> Fields['twitter_oauth_token']-> set($twitter_oauth_token);
}
/////////////////////////////////////////////////////////////////////////////

function get_twitter_oauth_token_value()
{
     return $this-> Fields['twitter_oauth_token']-> get();
}
/////////////////////////////////////////////////////////////////////////////

function set_twitter_oauth_token_secret($twitter_oauth_token_secret)
{
     $this-> Fields['twitter_oauth_token_secret']-> set($twitter_oauth_token_secret);
}
/////////////////////////////////////////////////////////////////////////////

function set_twitter_last_html_preview_url($url)
{
     $this-> Fields['twitter_last_html_preview_url']-> set($url);
}
/////////////////////////////////////////////////////////////////////////////

function get_twitter_last_html_preview_url_value()
{
     return $this-> Fields['twitter_last_html_preview_url']-> get();
}
/////////////////////////////////////////////////////////////////////////////

function get_twitter_oauth_token_secret_value()
{
     return $this-> r_twitter_oauth_token_secret;
}
/////////////////////////////////////////////////////////////////////////////

function set_user_name($user_name)
{
     $this-> Fields['user_name']-> set($user_name);
}
///////////////////////////////////////////////////////////////////////////// 

function get_user_name_value()
{
     return $this-> r_user_name;
}
///////////////////////////////////////////////////////////////////////////// 

function set_company($company)
{
	$this-> Fields['company']-> set($company);
}
///////////////////////////////////////////////////////////////////////////// 

function get_company_value()
{
	return $this-> Fields['company']-> get();
}
///////////////////////////////////////////////////////////////////////////// 

function set_first_name($firstName)
{
	$this-> Fields['first_name']-> set($firstName);
}
///////////////////////////////////////////////////////////////////////////// 

function get_first_name_value()
{
	return $this-> Fields['first_name']-> get();
}
///////////////////////////////////////////////////////////////////////////// 

function set_web_crop_offset_X($X)
{
     $this-> Fields['web_crop_offset_X']-> set($X);
}
/////////////////////////////////////////////////////////////////////////////

function get_web_crop_offset_X_value()
{
     return $this-> r_web_crop_offset_X;
}
/////////////////////////////////////////////////////////////////////////////

function set_web_crop_offset_Y($Y)
{
     $this-> Fields['web_crop_offset_Y']-> set($Y);
}
/////////////////////////////////////////////////////////////////////////////

function get_web_crop_offset_Y_value()
{
     return $this-> r_web_crop_offset_Y;
}
/////////////////////////////////////////////////////////////////////////////

function set_web_crop_width($width)
{
     $this-> Fields['web_crop_width']-> set($width);
}
/////////////////////////////////////////////////////////////////////////////

function get_web_crop_width_value()
{
     return $this-> r_web_crop_width;
}
/////////////////////////////////////////////////////////////////////////////

function set_web_crop_height($height)
{
     $this-> Fields['web_crop_height']-> set($height);
}
/////////////////////////////////////////////////////////////////////////////

function get_web_crop_height_value()
{
     return $this-> r_web_crop_height;
}
/////////////////////////////////////////////////////////////////////////////

function set_web_crop_last_image($image)
{
	$this-> Fields['web_crop_last_image']-> set($image);
}
/////////////////////////////////////////////////////////////////////////////

function get_web_crop_last_image_value()
{
	return $this-> Fields['web_crop_last_image']-> get();
}
/////////////////////////////////////////////////////////////////////////////

function set_text_width($width)
{
	$this-> Fields['text_width']-> set($width);
}
/////////////////////////////////////////////////////////////////////////////

function get_text_width_value()
{
	return $this-> Fields['text_width']-> get();
}
/////////////////////////////////////////////////////////////////////////////

function set_text_height($height)
{
	$this-> Fields['text_height']-> set($height);
}
/////////////////////////////////////////////////////////////////////////////

function get_text_height_value()
{
	return $this-> Fields['text_height']-> get();
}
/////////////////////////////////////////////////////////////////////////////

function set_text_left($left)
{
	$this-> Fields['text_left']-> set($left);
}
/////////////////////////////////////////////////////////////////////////////

function get_text_left_value()
{
	return $this-> Fields['text_left']-> get();
}
/////////////////////////////////////////////////////////////////////////////

function set_text_top($top)
{
	$this-> Fields['text_top']-> set($top);
}
/////////////////////////////////////////////////////////////////////////////

function get_text_top_value()
{
	return $this-> Fields['text_top']-> get();
}
/////////////////////////////////////////////////////////////////////////////

function set_fb_instance_id($fb_instance_id)
{
	$this-> Fields['fb_instance_id']-> set($fb_instance_id);
}
////////////////////////////////////////////////////////////////////////////

function get_fb_instance_id_value()
{
	return $this-> Fields['fb_instance_id']-> get();
}
////////////////////////////////////////////////////////////////////////////
}//class ends here 
?>