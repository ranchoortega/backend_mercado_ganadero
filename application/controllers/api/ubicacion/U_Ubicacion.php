<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/Rest_controller.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: token");

class U_Ubicacion extends Rest_controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('GlobalModel', 'gm');
        $this->load->model('ClienteModel', 'cm');

    }


    public function getEstados()
    {

        $r = $this->gm->select_tabla("estados", "id");
        if (!$r) {
            $this->respuesta(404, ["mensaje" => "No  documentos"]);
            return false;
        }
        $this->respuesta(200, $r);
        return false;

    }


    public function getMunicipiosEstados()
    {
        $estado = $this->input->get("estado");
        if ($estado) {
            $r = $this->cm->getEstadoMunicipio($estado);
            if (!$r) {
                $this->respuesta(404, ["mensaje" => "No  documentos"]);
                return false;
            }
            $this->respuesta(200, $r);
            return false;
        }

    }














}