<?php
defined('BASEPATH') or exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: token");
class Rest_controller extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('UsuariosModel', 'use');
    }

    public function respuesta($estatus, $data)
    {
        $this->output->set_content_type('application/json');
        $this->output->set_status_header($estatus);
        $this->output->set_output(json_encode($data));
    }

    public function validarToken()
    {
        // $token = $this->input->get_request_header('token', TRUE);
        // // if (!empty($token)) {
        // //     $token = $this->input->get_request_header('token', TRUE);
        // if (empty($token)) {
        //     $this->respuesta(401, ["mensaje" => "token no enviado"]);
        //     return false;
        // } else {
        //     if ($this->use->verificar_token($token)) {
        //         return true;
        //     } else {
        //         $this->respuesta(401, ["mensaje" => "token no valido"]);
        //         return false;
        //     }
        // }
        // // }
        return true;
    }

    public function generarToken($id = '', $usuario = '')
    {
        $key = "KHSuhdUrC_gYG";
        $token = password_hash($key . $id . $usuario, PASSWORD_DEFAULT);
       
        return $token;
    }

    public function fechaActual()
    {
        date_default_timezone_set('America/Mexico_City');
        return date('Y-m-d H:i:s');
    }
}