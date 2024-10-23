<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/Rest_controller.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: token");
class Login extends Rest_controller
{

     public function __construct()
    {
        parent::__construct();
        $this->load->model('UsuariosModel', 'use');
        $this->load->model('GlobalModel', 'gm');
    }
 
    public function IniciarSesion()
    {
        if($this->input->post()){
            $usuario = $this->input->post('usuario');
            $password = $this->input->post('pass');
            if(!empty($usuario) && !empty($password)){
                $d = $this->use->get_by_credenciales($usuario,$password);
                if(!$d){
                    $this->respuesta(401,["mensaje"=>"Usuario y/o contraseña invalida"]);
                    return false;
                }
                
                if(!empty($d->token)){
                $r = [
                    "id_usuario"=>$d->id_user,
                    "token"=>$d->token
                ];
                $this->respuesta(200,$r);
                return false;
                }else{
                    if ($usuario == "a" && $password == 2) {
                        $token = $this->generarToken($d->id_user,$d->name);
                        $r = [
                            "id_usuario"=>$d->id_user,
                            "token"=>$token
                        ];
                        $this->respuesta(200,$r);
                        return false;
                    }else{
                        $token = $this->generarToken($d->id_user,$d->name);
                        $r = [
                            "id_usuario"=>$d->id_user
                        ];
                        $this->respuesta(200,$r);
                        return false;
                    }

                   
                }
                return false;
            }
            $this->respuesta(401,["mensaje"=>"Ingrese usuario y/o contraseña"]);
        }
    }
    
    public function setUsers()
{
    if ($this->input->post()) {
        date_default_timezone_set('America/Mexico_City');
        $fechaActual = date('Y-m-d');
        $user = $this->input->post("user");
        $password = $this->input->post("password");
        $name = $this->input->post("name");
        $phone = $this->input->post("phone");
        $location = $this->input->post("location");
        $id_estadoMunicipio = $this->input->post("idEstado");
   
        
        // Verifica si el usuario ya existe
        $userExists = $this->gm->checkUsernameExists($user);

        if ($userExists) {
            // Si el usuario existe, muestra un mensaje de error
            $this->respuesta(404, ["icon" => "warning", "mensaje" => "El USUARIO EXISTE", "res" => false]);
        } else {
            // Si el usuario no existe, guarda la información
            $form = [
                "user" => $user,
                "password" => $password,
                "name" => $name,
                "phone" => $phone,
                "location" => $location,
                "id_estadoMunicipio" => $id_estadoMunicipio,
                "fecha_alta" => $fechaActual
            ];
            $r = $this->gm->save_tabla("usuarios", $form);
            if (!$r) {
                $this->respuesta(404, ["icon" => "warning", "mensaje" => "ERROR AL GUARDAR LA INFORMACION", "res" => false]);
            } else {
                $this->respuesta(200, ["icon" => "success", "mensaje" => "LA INFORMACIÓN SE GUARDÓ CORRECTAMENTE", "res" => $r]);
            }
        }
    }
}

   

    
}