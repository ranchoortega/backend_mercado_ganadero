<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/Rest_controller.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: token");

class A_Pages extends Rest_controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('GlobalModel', 'gm');
        $this->load->model('AdministracioModel', 'im');
    }

    public function getPages()
    {

        $draw = $this->input->post('draw');
        $inicio = $this->input->post('start');
        $filas = $this->input->post('length');
        $total = $this->im->getPages(false, $inicio, $filas);
        $datos = $this->im->getPages(true, $inicio, $filas);

        $resultado = array(
            "draw" => $draw,
            "recordsTotal" => $total,
            "recordsFiltered" => $total,
            "data" => $datos
        );

        echo json_encode($resultado);


    }


    public function updateStatus($id, $valor)
    {

        $form = [
            "status" => $valor,

        ];

        $r = $this->gm->update_tabla("id_pages_status", $id, "pages_status", $form);
        if (!$r) {
            $this->respuesta(404, ["icon" => "warning", "mensaje" => "ERROR AL ACTUALIZAR LA INFORMACION", "res" => false]);
            return false;
        }
        $this->respuesta(200, ["icon" => "success", "mensaje" => "LA INFORMACIÓN SE ACTUALIZO CORRECTAMENTE", "res" => $id]);





    }






}