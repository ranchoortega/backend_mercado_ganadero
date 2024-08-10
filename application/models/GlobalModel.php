<?php
defined('BASEPATH') or exit('No direct script access allowed');

class GlobalModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
       

        $this->load->library('upload');
    }
    public function get_all_table($id, $table, $campo)
    {
        return $this->db->select('*')->get_where($table, array($campo => $id))->result();
    }
    public function select_tabla($tabla, $campo)
    {
        $this->db->order_by($campo, "ASC");
        $query = $this->db->get($tabla);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function save_tabla($tabla, $form)
    {
        $this->db->insert($tabla, $form);
        return $this->db->insert_id();
    }
    public function update_tabla($nombreCampo, $valorCampo, $tabla, $form)
    {
        $this->db->where($nombreCampo, $valorCampo);
        return $this->db->update($tabla, $form);
    }
    public function delete_tabla($nombreCampo, $valorCampo, $tabla)
    {
        $this->db->where($nombreCampo, $valorCampo);
        return $this->db->delete($tabla);
    }

    public function getQuery($consulta)
    {
        $query = $this->db->query($consulta);
        return $query->result();
    }
    public function checkUsernameExists($username) {
        $this->db->where('id_user', $username);
        $query = $this->db->get('usuarios');
        return $query->num_rows() > 0;
    }

    public function deleteImage($filename)
    {
        // Si el filename es una URL o contiene una ruta completa, extraer el nombre del archivo
        $fileName = basename(parse_url($filename, PHP_URL_PATH));
    
        // Verificar si el nombre del archivo es válido
       
    
        // Ruta del archivo en el servidor
        $filePath = './uploads/' . $fileName;
    
        // Inicializar la respuesta
       
    
        // Verificar si el archivo es realmente un archivo y no un directorio
        if (is_file($filePath)) {
            if (unlink($filePath)) {
                // Archivo eliminado exitosamente
                return true;
            } else {
                // Error al eliminar el archivo
                return false;
            }
        } else {
            // Archivo no encontrado o es un directorio
            return false;
        }
    
        // Enviar respuesta en formato JSON
        
    }
    

    
}