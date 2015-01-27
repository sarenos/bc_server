<?php
/**************************************************************
* Project  : Movable-Ink Gen
* Name     : User
* Date     : 2012.02.08
* Modified : $Id$
* Author   : forjest@gmail.com
***************************************************************
*
*/
require_once LAYERS_DIR.'/Entity/entity_with_db.inc.php';

class User extends EntityWithDB
{
/////////////////////////////////////////////////////////////////////////////

function &get_all_fields_instances()
{
     $result['id']             = new FieldInt();
     $result['dt_created']     = new FieldDateTime();
     $result['email']          = new FieldString();
     $result['email']-> set_max_length(50);

     $result['password_hash']  = new FieldUniquePassword();
     $result['company']        = new FieldString();
     $result['company']-> set_max_length(150);
	$result['first_name']	 = new FieldString();
	$result['first_name']-> set_max_length(50);

	$result['fb_access_token'] = new FieldString();
	$result['fb_access_token']-> set_max_length(255);

	$result['fb_profile_link'] = new FieldString();
	$result['fb_profile_link']-> set_max_length(255);

	$result['tw_oauth_token'] = new FieldString();
	$result['tw_oauth_token']-> set_max_length(255);

	$result['tw_oauth_token_secret'] = new FieldString();
	$result['tw_oauth_token_secret']-> set_max_length(255);

	$result['tw_user_id'] = new FieldInt();

	$result['tw_screen_name'] = new FieldString();
	$result['tw_screen_name']-> set_max_length(255);

//	$result['is_admin']		 = new FieldYNBool();

     return $result;
}
/////////////////////////////////////////////////////////////////////////////

function create_child_objects()
{
     $this-> create_standart_db_handler('dc_user');
     $this-> create_tuple();
}
/////////////////////////////////////////////////////////////////////////////

function add()
{
     $this-> Fields['dt_created']-> now();
     $this-> DBHandler-> insert();
}
///////////////////////////////////////////////////////////////////////////

function is_admin()
{
	return $this-> Fields['is_admin']-> get();
}
///////////////////////////////////////////////////////////////////////////

function set_email($email)
{
	$this-> Fields['email']-> set($email);
}
///////////////////////////////////////////////////////////////////////////

function get_email()
{
	return $this-> Fields['email']-> get();
}
///////////////////////////////////////////////////////////////////////////

function set_password_hash($passwordHash)
{
	$this-> Fields['password_hash']-> set($passwordHash);
}
///////////////////////////////////////////////////////////////////////////

function set_company($company)
{
	$this-> Fields['company']-> set($company);
}
///////////////////////////////////////////////////////////////////////////

function get_company_value()
{
	return $this-> Fields['company']-> get();
}
///////////////////////////////////////////////////////////////////////////

function get_password_hash()
{
	return $this-> Fields['password_hash']-> get();
}
///////////////////////////////////////////////////////////////////////////

function set_first_name($firstName)
{
	$this-> Fields['first_name']-> set($firstName);
}
///////////////////////////////////////////////////////////////////////////

function get_first_name_value()
{
	return $this-> Fields['first_name']-> get();
}
///////////////////////////////////////////////////////////////////////////

function load_by_email()
{
	$this-> load_by_field('email');
}
///////////////////////////////////////////////////////////////////////////

function set_fb_access_token($access_token)
{
	$this-> Fields['fb_access_token']-> set($access_token);
}
///////////////////////////////////////////////////////////////////////////

function get_fb_access_token_value()
{
	return $this-> Fields['fb_access_token']-> get();
}
///////////////////////////////////////////////////////////////////////////

function set_fb_profile_link($link)
{
	$this-> Fields['fb_profile_link']-> set($link);
}
///////////////////////////////////////////////////////////////////////////

function get_fb_profile_link_value()
{
	return $this-> Fields['fb_profile_link']-> get();
}
///////////////////////////////////////////////////////////////////////////

function set_tw_oauth_token($accessToken)
{
	$this-> Fields['tw_oauth_token']-> set($accessToken);
}
///////////////////////////////////////////////////////////////////////////

function get_tw_oauth_token_value()
{
	return $this-> Fields['tw_oauth_token']-> get();
}
///////////////////////////////////////////////////////////////////////////

function set_tw_oauth_token_secret($accessTokenSecret)
{
	$this-> Fields['tw_oauth_token_secret']-> set($accessTokenSecret);
}
///////////////////////////////////////////////////////////////////////////

function get_tw_oauth_token_secret_value()
{
	return $this-> Fields['tw_oauth_token_secret']-> get();
}
///////////////////////////////////////////////////////////////////////////

function set_tw_screen_name($screenName)
{
	$this-> Fields['tw_screen_name']-> set($screenName);
}
///////////////////////////////////////////////////////////////////////////

function get_tw_screen_name_value()
{
	return $this-> Fields['tw_screen_name']-> get();
}
///////////////////////////////////////////////////////////////////////////

function set_tw_user_id($userId)
{
	$this-> Fields['tw_user_id']-> set($userId);
}
///////////////////////////////////////////////////////////////////////////

function get_tw_user_id_value()
{
	return $this-> Fields['tw_user_id']-> get();
}
///////////////////////////////////////////////////////////////////////////

}//class ends here
?>