<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . 'libraries/REST_Controller.php';

/**
 * This is an example of a few basic User interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class Users extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['Users_get']['limit'] = 500; // 500 requests per hour per User/key
        $this->methods['Users_post']['limit'] = 100; // 100 requests per hour per User/key
        $this->methods['Users_delete']['limit'] = 50; // 50 requests per hour per User/key
    }

    public function index_get() {

        // Users from a data store e.g. database
        $Users = $this->uri->segment(3) ? $this->Users_model->get_by(['id' => $this->uri->segment(3), 'status' => 'active']) : $this->Users_model->get_many_by(['status' => 'active']);

        // Check if the Users data store contains Users (in case the database result returns NULL)
        if ($Users) {
            // Set the response and exit
            $this->response(['success' => TRUE, 'data' => $Users], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            // Set the response and exit
            $this->response(['success' => FALSE, 'message' => 'User / users NOT found'], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }

    }

    public function index_put() {

        $data = remove_unknown_fields($this->put(), $this->form_validation->get_field_names('users_put'));
            $this->form_validation->set_data($data);

            if ($this->form_validation->run('users_put') != FALSE) {

                // $this->safeEmail(NULL, $data['email']);
                // die();
                
                // check if email already exists in db before inserting data
                if (!$this->safeEmail(NULL, $data['email']) && !$this->safePhone($User['id'], $data['phone'])) {
                    $this->set_response(['success' => FALSE, 'message'=> 'The Provided Email Address is Invalid or already in use, Please try again'], REST_Controller::HTTP_CONFLICT);
                } else {
                    // inserting form data to db
                    $insert = $this->Users_model->insert($data);

                    if (!$insert) {
                        $this->set_response(['success' => FALSE, 'message' => 'An Unexpected Error Occurred While Saving User'], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
                    } else {
                        $this->set_response(['success' => TRUE, 'message' => 'User Saved Successfully'],  REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
                    }
                }

            } else {
                $this->set_response(['success'=> FALSE, 'message'=> $this->form_validation->get_errors_as_array()], REST_Controller::HTTP_BAD_REQUEST);
            }

    }

    public function index_post() {
        
        $User = $this->Users_model->get_by(['id' => $this->uri->segment(3), 'status' => 'active']);

        if ($User) {

            $data = remove_unknown_fields($this->post(), $this->form_validation->get_field_names('users_post'));
            $this->form_validation->set_data($data);

            if ($this->form_validation->run('users_post') != FALSE) {
                
                // check if email already exists in db before inserting data
                if (!$this->safeEmail($User['id'], $data['email']) && !$this->safePhone($User['id'], $data['phone'])) {
                    $this->set_response(['success' => FALSE, 'message'=> 'The Provided Email Address is Invalid or already in use, Please try again'], REST_Controller::HTTP_CONFLICT);
                } else {
                    // inserting form data to db
                    $updated = $this->Users_model->update($User['id'], $data);

                    if (!$updated) {
                        $this->set_response(['success' => FALSE, 'message' => 'An Unexpected Error Occurred While Updating User'], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
                    } else {
                        $this->set_response(['success' => TRUE, 'message' => 'User Updated Successfully'],  REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
                    }
                }

            } else {
                $this->set_response(['success'=> FALSE, 'message'=> $this->form_validation->get_errors_as_array()], REST_Controller::HTTP_BAD_REQUEST);
            }

        } else {
            $this->set_response(['success' => FALSE, 'message' => 'User NOT found'], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }

    }

    public function index_delete() {

        $User = $this->Users_model->get_by(['id'=> $this->uri->segment(3), 'status'=> 'active']);

        if ($User) {
            // inserting form data to db
            $deleted = $this->Users_model->delete($User['id']);

            if (!$deleted) {
                $this->set_response(['status' => FALSE,'message'=> 'An Unexpected Error Occurred While Deleting User'], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
            } else {
                $this->set_response(['status' => TRUE, 'message'=> 'User Deleted Successfully'],  REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
            }
        } else {
            $this->set_response(['status' => FALSE, 'message' => 'User NOT found'], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    public function safeEmail($user_id = NULL, $email) {

        if ($user_id) {
           return (($this->Users_model->get_by(['email' => $email, 'status' => 'active'])['id']) === $user_id || ($this->Users_model->get_by(['email' => $email, 'status' => 'active'])['id']) === NULL) ? TRUE : FALSE;
        } else {
            return ($this->Users_model->get_by(['email'=> $email, 'status' => 'active'])['id']) ? FALSE : TRUE;
        }
    }

    public function safePhone($user_id = NULL, $phone) {

        if ($user_id) {
           return (($this->Users_model->get_by(['phone_number' => $phone, 'status' => 'active'])['id']) === $user_id || ($this->Users_model->get_by(['phone_number' => $phone, 'status' => 'active'])['id']) === NULL) ? TRUE : FALSE;
        } else {
            return ($this->Users_model->get_by(['phone_number'=> $phone, 'status' => 'active'])['id']) ? FALSE : TRUE;
        }
    }


}
