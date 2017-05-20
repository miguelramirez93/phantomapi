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
class Elementorest extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['elementos_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['elementos_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['elementos_delete']['limit'] = 50;
        $this->methods['elementos_put']['limit'] = 100; // 100 requests per hour per user/key
    }

    public function elementos_get()
    {
      $id = NULL;
      if (isset($_GET['id'])) {
        $id = $_GET['id'];
      }
      $this->load->model('Elemento');
      $this->response($this->Elemento->get_elemento($id));
    }

    public function elementos_post()
    {

      $json = file_get_contents('php://input');
      $data = json_decode($json);
      $this->load->model('Elemento');
      $elemento = $data->elemento;
      $categorias = $data->categorias;
      $this->set_response($this->Elemento->add_elemento($elemento,$categorias)); // CREATED (201) being the HTTP response code


  }

    public function elementos_delete()
    {
        $id = (int) $this->get('id');

        // Validate the id.
        if ($id <= 0)
        {
            // Set the response and exit
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        // $this->some_model->delete_something($id);
        $this->load->model('Elemento');
        $this->set_response($this->Elemento->delete_elemento($id)); // NO_CONTENT (204) being the HTTP response code
    }

    public function elementos_put(){
      $id = (int) $this->get('id');
      $json = file_get_contents('php://input');
      $data = json_decode($json);


      // Validate the id.
      if ($id <= 0)
      {
          // Set the response and exit
          $this->response(false); // BAD_REQUEST (400) being the HTTP response code
      }
      $this->load->model('Elemento');
      $this->set_response($this->Elemento->put_elemento($data,$id));
    }
}
