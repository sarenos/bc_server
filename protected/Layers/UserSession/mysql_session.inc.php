<?php

class MySQLSession
{
     private $_db;
     private $_Config;
     private $_sessions_table_name;
     
     public function __construct()
     {
          $this-> init_crypt();
          $this-> db = produce_db();
     }
     
     public function open()
     {
     }
     
     public function close()
     {
     }
     
     public function read($id)
     {
          $this-> db-> exec_query(
               "SELECT * FROM gm_sessions WHERE id = '".$this-> db-> escape_str($id)."'"
          );
          if (! ($result = $this-> db-> get_data()))
          {
               return ' ';
          }
          return $this-> decrypt($result['data']);
     }

     public function write($id, $data)
     {
          $this-> db-> freeze_debug();
          return $this-> db-> exec_query(
               "REPLACE INTO gm_sessions VALUES (
                  '".$this-> db-> escape_str($id)."',
                  NOW(),
                  '".$this-> db-> escape_str($this-> encrypt($data))."')"
          );
     }
     
     public function destroy($id)
     {
          return $this-> db-> exec_query(
               "DELETE FROM gm_sessions WHERE id = '".$this-> db-> escape_str($id)."'"
          );
     }
     
     public function gc($max)
     {
          return $this-> db-> exec_query("DELETE FROM gm_sessions WHERE access < NOW() - INTERVAL $max SECOND");
     }
     
     public function bind_handlers()
     {
          session_set_save_handler(
                  array($this, "open"),
                  array($this, "close"),
                  array($this, "read"),
                  array($this, "write"),
                  array($this, "destroy"),
                  array($this, "gc")
                  );
     }
     
     function alt_mcrypt_create_iv ($size)
     {
         $iv = '';
         for($i = 0; $i < $size; $i++) {
              $iv .= chr($i);
         }
         return $iv;
     }

     private function init_crypt()
     {
          $this-> crypt_key = 'a59957ce0e5';
          $this-> crypt_algorithm = MCRYPT_BLOWFISH;
          $this-> crypt_mode = MCRYPT_MODE_CFB;
          
          $this-> crypt_iv = $this-> alt_mcrypt_create_iv(mcrypt_get_iv_size(
                          $this-> crypt_algorithm,
                          $this-> crypt_mode
                          ));

     }
        
     private function encrypt($data)
     {
          $result = mcrypt_encrypt(
                  $this-> crypt_algorithm,
                  $this-> crypt_key,
                  $data,
                  $this-> crypt_mode,
                  $this-> crypt_iv
                  );
          
          return $result;
     }
     
     private function decrypt($data)
     {
          $decrypted_result = mcrypt_decrypt(
                  $this-> crypt_algorithm,
                  $this-> crypt_key,
                  $data,
                  $this-> crypt_mode,
                  $this-> crypt_iv);
          
          $result = stripslashes($decrypted_result);
 
          return $result;
          
     }
}

?>
