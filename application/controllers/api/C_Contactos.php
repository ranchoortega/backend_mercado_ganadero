<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/Rest_controller.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: token");

class C_Contactos extends Rest_controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('GlobalModel', 'gm');
      
    }




    public function getLegajo()
    {
        if ($this->validarToken()) {
            if ($this->input->post()) {

                $id = trim($this->input->post('id'));
                $tipo = trim($this->input->post('tipo'));

                if($tipo == "ingresos"){
                    $r = $this->gm->get_all_table($tipo, 'global_ingresos', 'id_ingreso');
                }
                else{
                    $r = $this->gm->get_all_table($tipo, 'global_ingresos', 'id_ingreso');
                }

           
                if (!$r) {
                    $this->respuesta(404, ["mensaje" => "No categorias"]);
                    return false;
                }
                $this->respuesta(200, $r);
                return false;
            }
        }

    }

    public function setContacto()
    {
     
            if ($this->input->post()) {
                date_default_timezone_set('America/Mexico_City');
                $fechaActual = date('Y-m-d H:i:s');
                $id_contacto = $this->input->post("id_contacto");
                $name = $this->input->post("name");
                $phone = $this->input->post("phone");
                $comment = $this->input->post("comment");
         

                    $form = [
                        "id_contacto" => $id_contacto,
                        "name" => $name,
                        "phone" => $phone,
                        "comment" => $comment,
                        "fecha_alta" => $fechaActual
                    ];
                    $r = $this->gm->save_tabla("c_contactos", $form);
                    if (!$r) {
                        $this->respuesta(404, ["icon" => "warning", "mensaje" => "ERROR AL GUARDAR LA INFORMACION", "res" => false]);
                        return false;
                    }
                    $this->respuesta(200, ["icon" => "success", "mensaje" => "LA INFORMACIÓN SE GUARDÓ CORRECTAMENTE", "res" => $r]);
                

            }
        

    }
   







}