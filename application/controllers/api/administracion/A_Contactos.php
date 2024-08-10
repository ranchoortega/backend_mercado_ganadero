<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/Rest_controller.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: token");

class A_Contactos extends Rest_controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('GlobalModel', 'gm');
        $this->load->model('AdministracioModel', 'im');
    }

    public function deleteContacto($id)
    {
        if($this->validarToken()){
            if ($id) {

                $r = $this->gm->delete_tabla('id_contacto',$id, 'c_contactos' );
                if(!$r){
                    $this->respuesta(404, ["icon" => "warning", "mensaje" => "Error al eliminar el contacto", "res" => false]);

                    return false;
                }
                $this->respuesta(200, ["icon" => "success", "mensaje" => "Contacto eliminado correcta mente", "res" => true]);
                    
            }
        }

    }
    public function getContactos()
	{
		
                $draw = $this->input->post('draw');
                $inicio = $this->input->post('start');
                $filas = $this->input->post('length');
                $total = $this->im->getContactos(false, $inicio, $filas);
                $datos = $this->im->getContactos(true, $inicio, $filas);

                $resultado = array(
                    "draw" => $draw,
                    "recordsTotal" => $total,
                    "recordsFiltered" => $total,
                    "data" => $datos
                );

                echo json_encode($resultado);
       
		
	}

  





}