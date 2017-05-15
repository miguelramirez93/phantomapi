<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . '/libraries/REST_Controller.php';

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class Personarest extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['personas_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['personas_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['personas_delete']['limit'] = 50;
        $this->methods['personas_put']['limit'] = 100; // 100 requests per hour per user/key
    }

    public function personas_get()
    {
      $id = null;
      if (isset($_GET['id'])) {
        $id = $_GET['id'];
      }
      $this->load->model('Persona');
      $this->response($this->Persona->get_persona($id));
    }

    public function personas_post()
    {
      $json = file_get_contents('php://input');
      $data = json_decode($json);
        $this->load->model('Persona');
        $this->set_response($this->Persona->add_persona($data), REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
    }

    public function personas_delete()
    {
        $id = (int) $this->get('id');

        // Validate the id.
        if ($id <= 0)
        {
            // Set the response and exit
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        // $this->some_model->delete_something($id);
        $this->load->model('Persona');
        $this->set_response($this->Persona->delete_persona($id)); // NO_CONTENT (204) being the HTTP response code
    }

    public function personas_put(){
      $id = (int) $this->get('id');
      $json = file_get_contents('php://input');
      $data = json_decode($json);


      // Validate the id.
      if ($id <= 0)
      {
          // Set the response and exit
          $this->response(false); // BAD_REQUEST (400) being the HTTP response code
      }
      $this->load->model('Persona');
      $this->set_response($this->Persona->put_persona($data,$id));
    }
}
