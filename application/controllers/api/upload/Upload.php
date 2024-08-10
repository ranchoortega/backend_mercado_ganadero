<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Upload extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('GlobalModel', 'gm');

        $this->load->library('upload');
    }

    public function saveImage()
    {

        $id_descripcion = $this->input->post("id_descripcion");

        // Configuración de la carga de archivos
        $config['upload_path'] = './uploads/'; // Asegúrate de que esta ruta sea accesible y tenga permisos de escritura
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['encrypt_name'] = TRUE; // Esto encripta el nombre del archivo original

        $this->upload->initialize($config);

        if (!$this->upload->do_upload('file')) {
            $error = $this->upload->display_errors();
            $response = array('status' => 'error', 'message' => $error);
            echo json_encode($response);
            return;
        }

        $fileData = $this->upload->data();
        $fileName = $fileData['file_name'];
        $filePath = base_url('uploads/' . $fileName);

        // Aquí puedes manejar otros datos como name, phone y comment si es necesario

        // Devolver la URL del archivo cargado
        $response = $this->setImg($filePath, $id_descripcion);


        echo json_encode($response);
    }
    public function deleteImage($filename)
    {
        $filePath = './uploads/' . $filename; // Ruta del archivo en el servidor

        if (file_exists($filePath)) {
            if (unlink($filePath)) {
                // Archivo eliminado exitosamente
                $response = array('status' => 'success', 'message' => 'Archivo eliminado correctamente.');
            } else {
                // Error al eliminar el archivo
                $response = array('status' => 'error', 'message' => 'No se pudo eliminar el archivo.');
            }
        } else {
            // Archivo no encontrado
            $response = array('status' => 'error', 'message' => 'Archivo no encontrado.');
        }

        echo json_encode($response);
    }

    public function setImg($url, $id_descripcion)
    {


        $form = [
            "id_descripcion" => $id_descripcion,
            "url" => $url,

        ];
        $r = $this->gm->save_tabla("files", $form);

        if (!$r) {
            return array("icon" => "warning", 'mensaje' => 'ERROR AL GUARDAR LA INFORMACION',"res" => false);
        }

        return array('icon' => 'success', 'mensaje' => 'LA INFORMACION SE GUARDÓ CORRECTAMENTE', "res" => $r);


    }

}
