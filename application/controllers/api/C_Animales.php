<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/Rest_controller.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: token");

class C_Animales extends Rest_controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('GlobalModel', 'gm');

    }




    public function setDescripcio()
    {
        if ($this->input->post()) {
            date_default_timezone_set('America/Mexico_City');
            $fechaActual = date('Y-m-d H:i:s');
            $id_usuario = $this->input->post("id_usuario");
            $raza = $this->input->post("raza");
            $edad = $this->input->post("edad");
            $genero = $this->input->post("genero");
            $descripcion = $this->input->post("descripcion");
            $precio = $this->input->post("precio");
            


            $form = [
                "id_usuario" => $id_usuario,
                "raza" => $raza,
                "edad" => $edad,
                "genero" => $genero,
                "descripcion" => $descripcion,
                "precio" => $precio,
                "fecha_alta" => $fechaActual
            ];
            $r = $this->gm->save_tabla("descripcion_animal", $form);
          



            if (!$r) {
                $this->respuesta(404, ["icon" => "warning", "mensaje" => "ERROR AL GUARDAR LA INFORMACION", "res" => false]);
                return false;
            }
            $this->respuesta(200, ["icon" => "success", "mensaje" => "LA INFORMACIÓN SE GUARDÓ CORRECTAMENTE", "res" => $r]);

        }


    }










}