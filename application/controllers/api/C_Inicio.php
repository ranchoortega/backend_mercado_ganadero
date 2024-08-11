<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/Rest_controller.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: token");

class C_Inicio extends Rest_controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('GlobalModel', 'gm');
        $this->load->model('AdministracioModel', 'im');
    }


    public function getPaginas()
    {
       



            $r = $this->gm->select_tabla('pages_status', 'id_pages_status');
            if (!$r) {
                $this->respuesta(404, ["mensaje" => "No  documentos"]);
                return false;
            }
            $this->respuesta(200, $r);
            return false;
        


    }






}