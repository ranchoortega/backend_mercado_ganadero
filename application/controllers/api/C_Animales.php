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
        $this->load->model('ClienteModel', 'cm');

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
            $desparasitado = $this->input->post("desparasitado");
            $anuncio = $this->input->post("anuncio");
            $peso = $this->input->post("peso");
            $tipo = $this->input->post("tipo");
            


            $form = [
                "id_usuario" => $id_usuario,
                "raza" => $raza,
                "edad" => $edad,
                "genero" => $genero,
                "descripcion" => $descripcion,
                "precio" => $precio,
                "desparasitado" => $desparasitado,
                "anuncio" => $anuncio,
                "peso" => $peso,
                "tipo" => $tipo,
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

    public function getAnimales() {
        $tipo = $this->input->get("tipo");
        $page = $this->input->get("page");
    
        // Validar si $page está definida y es numérica
        $page = isset($page) && is_numeric($page) ? (int)$page : 0;
    
        // Establecer el límite y el offset
        $limit = 9;
        $offset = $page * $limit;  // Multiplicar el número de página por el límite para obtener el offset
    
        // Aplicar el límite y el offset en la consulta
        $this->db->limit($limit, $offset);
        $r = $this->cm->getAnimales($tipo, $limit, $offset);
    
        if (!$r) {
            $this->respuesta(404, ["mensaje" => "No hay documentos"]);
            return false;
        }
    
        $this->respuesta(200, $r);
        return false;
    }
    

    
    public function getNumber(){
        $tipo = $this->input->get("tipo");

        if($tipo){
            
            $r = $this->cm->getNumero($tipo);
            if (!$r) {
                $this->respuesta(404, ["mensaje" => "No  documentos"]);
                return false;
            }
            $this->respuesta(200, $r);
            return false;
        
        }

    }
  

    










}