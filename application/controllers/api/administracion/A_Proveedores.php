<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/Rest_controller.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: token");

class A_Proveedores extends Rest_controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('GlobalModel', 'gm');
        $this->load->model('AdministracioModel', 'im');
    
    }

   
    public function getProveedores()
	{
		
                $draw = $this->input->post('draw');
                $inicio = $this->input->post('start');
                $filas = $this->input->post('length');
                $total = $this->im->getProveedores(false, $inicio, $filas);
                $datos = $this->im->getProveedores(true, $inicio, $filas);

                $resultado = array(
                    "draw" => $draw,
                    "recordsTotal" => $total,
                    "recordsFiltered" => $total,
                    "data" => $datos
                );

                echo json_encode($resultado);
       
		
	}

    public function getDescripcion()
	{
		
                $draw = $this->input->post('draw');
                $inicio = $this->input->post('start');
                $filas = $this->input->post('length');
                $id = $this->input->post('id');
                $total = $this->im->getDescripciones(false, $inicio, $filas,$id);
                $datos = $this->im->getDescripciones(true, $inicio, $filas, $id);

                $resultado = array(
                    "draw" => $draw,
                    "recordsTotal" => $total,
                    "recordsFiltered" => $total,
                    "data" => $datos
                );

                echo json_encode($resultado);
       
		
	}
    public function getAnimales()
	{
		
                $draw = $this->input->post('draw');
                $inicio = $this->input->post('start');
                $filas = $this->input->post('length');
                $id = $this->input->post('id');
                $total = $this->im->getAnimales(false, $inicio, $filas,$id);
                $datos = $this->im->getAnimales(true, $inicio, $filas, $id);

                $resultado = array(
                    "draw" => $draw,
                    "recordsTotal" => $total,
                    "recordsFiltered" => $total,
                    "data" => $datos
                );

                echo json_encode($resultado);
       
		
	}


    public function deleteProveedores($id)
    {
        if($this->validarToken()){
            if ($id) {

                $r = $this->gm->delete_tabla('id_user',$id, 'usuarios' );
                if(!$r){
                    $this->respuesta(404, ["icon" => "warning", "mensaje" => "Error al eliminar el proveedor", "res" => false]);

                    return false;
                }
                $this->respuesta(200, ["icon" => "success", "mensaje" => "Proveedor eliminado correcta mente", "res" => true]);
                    
            }
        }

    }
    public function deleteAnimales()
    {
        if($this->validarToken()){

            $id = $this->input->post('id');
            $url = $this->input->post('url');

          
                $imagen = $this->gm->deleteImage($url );
                if($imagen){
                    $r = $this->gm->delete_tabla('id_files',$id, 'files' );
                    if(!$r){
                        $this->respuesta(404, ["icon" => "warning", "mensaje" => "Error al eliminar la imagen", "res" => false]);
    
                        return false;
                    }
                    $this->respuesta(200, ["icon" => "success", "mensaje" => "Imagen eliminada correcta mente", "res" => true]);
                        

                }
                else{
                    $this->respuesta(404, ["icon" => "warning", "mensaje" => "Error al eliminar la imagen", "res" => false]);
                    
                }

               
            }
        

    }

    public function deleteDescripcions($id)
    {
        if($this->validarToken()){
            if ($id) {

                $r = $this->gm->delete_tabla('id_descripcion',$id, 'descripcion_animal' );
                if(!$r){
                    $this->respuesta(404, ["icon" => "warning", "mensaje" => "Error al eliminar la descripcion", "res" => false]);

                    return false;
                }
                $this->respuesta(200, ["icon" => "success", "mensaje" => "Descripcion eliminado correcta mente", "res" => true]);
                    
            }
        }

    }

  





}