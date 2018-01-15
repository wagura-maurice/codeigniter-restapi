<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* CodeIgniter Rest Controller
* A fully RESTful server implementation for CodeIgniter using one library, one config file and one controller.
*
* @package         CodeIgniter
* @subpackage      Config
* @category        Config
* @author          Wagura Maurice
* @license         MIT
* @link            https://github.com/wagura-maurice/codeigniter-restserver
* @version         1.0.0
*/

$config = array(

	'users_put' => array(
		array('field' =>'email', 'label' => 'email', 'rules' => 'trim|required|valid_email'),
		array('field' =>'password', 'label' => 'password', 'rules' => 'trim|required|min_length[8]|max_length[16]'),
		array('field' =>'first_name', 'label' => 'first_name', 'rules' => 'trim|required|max_length[50]'),
		array('field' =>'last_name', 'label' => 'last_name', 'rules' => 'trim|required|max_length[50]'),
		array('field' =>'phone_number', 'label' => 'phone_number', 'rules' => 'trim|required|alpha_dash'),
	),
	'users_post' => array(
		array('field' =>'email', 'label' => 'email', 'rules' => 'trim|valid_email'),
		array('field' =>'password', 'label' => 'password', 'rules' => 'trim|min_length[8]|max_length[16]'),
		array('field' =>'first_name', 'label' => 'first_name', 'rules' => 'trim|max_length[50]'),
		array('field' =>'last_name', 'label' => 'last_name', 'rules' => 'trim|max_length[50]'),
		array('field' =>'phone_number', 'label' => 'phone_number', 'rules' => 'trim|alpha_dash'),
	),
);

?>