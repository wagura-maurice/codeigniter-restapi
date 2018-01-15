<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    /**
    * 
    */
    class Users_model extends MY_Model {
    	// Create the model observers here.
    	protected $_table        = 'users';
    	protected $primary_key   = 'id';
    	protected $return_type   = 'array';

        protected $after_get     = array('remove_sensitive_data');
        protected $before_create = array('prepaired_data');
        protected $before_update = array('updated_data');

        function __construct() {
            parent::__construct();
            $this->load->helper('My_api');
            $this->load->library('form_validation');
        }

        protected function remove_sensitive_data($user) {
            unset($user['password']);
            unset($user['last_ip_address']);
            unset($user['last_user_agent']);
            return $user;
        } 

        protected function prepaired_data($user) {
            $user['password']        = password_hash($user['password'], PASSWORD_DEFAULT);
            $user['last_ip_address'] = $this->input->ip_address();
            $user['last_user_agent'] = $this->input->user_agent();
            $user['created_at']      = date('Y-m-d H:i:s');
            return $user;
        }

        protected function updated_data($user) {
            $user['password']        = password_hash($user['password'], PASSWORD_DEFAULT);
            $user['last_ip_address'] = $this->input->ip_address();
            $user['last_user_agent'] = $this->input->user_agent();
            $user['updated_at']      = date('Y-m-d H:i:s');
            return $user;
        }
    }
?>