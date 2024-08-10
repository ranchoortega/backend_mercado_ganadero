<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class AdministracioModel extends CI_Model {
    
    public function __construct(){
		parent::__construct();
		$this->load->database();
	}

    public function getContactos($nocontar, $inicio, $filas)
    {
        $this->db->select("*");
        $this->db->from('c_contactos');
     
        if ($nocontar) {
            if ($filas > 0) {
                $this->db->limit($filas, $inicio);
            }
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                return $query->result();
            } else {
                return false;
            }
        } else {
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                return $query->num_rows();
            } else {
                return false;
            }
        }
    }
    public function getProveedores($nocontar, $inicio, $filas)
    {
        $this->db->distinct(); 
        $this->db->select("U.name,  U.id_user");
        $this->db->from('descripcion_animal A');
        $this->db->join('usuarios U','U.id_user = A.id_usuario');

        if ($nocontar) {
            if ($filas > 0) {
                $this->db->limit($filas, $inicio);
            }
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                return $query->result();
            } else {
                return false;
            }
        } else {
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                return $query->num_rows();
            } else {
                return false;
            }
        }
    }

    public function getDescripciones($nocontar, $inicio, $filas, $id)
    {
  
        $this->db->select("*");
        $this->db->from('descripcion_animal A');
        $this->db->where('A.id_usuario',$id);


        if ($nocontar) {
            if ($filas > 0) {
                $this->db->limit($filas, $inicio);
            }
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                return $query->result();
            } else {
                return false;
            }
        } else {
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                return $query->num_rows();
            } else {
                return false;
            }
        }
    }
    public function getAnimales($nocontar, $inicio, $filas, $id)
    {
  
        $this->db->select("*");
        $this->db->from('files F');
        $this->db->where('F.id_descripcion',$id);


        if ($nocontar) {
            if ($filas > 0) {
                $this->db->limit($filas, $inicio);
            }
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                return $query->result();
            } else {
                return false;
            }
        } else {
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                return $query->num_rows();
            } else {
                return false;
            }
        }
    }
}