<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ClienteModel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    public function getAnimales($tipo, $limit, $offset)
    {

        $this->db->select("F.url,A.*,U.phone");
        $this->db->from('files F');
        $this->db->join('descripcion_animal A', 'F.id_descripcion  = A.id_descripcion');
        $this->db->join(' Usuarios U', ' = A.id_usuario = U.id_user');
        $this->db->where('A.tipo', $tipo);
        $this->db->group_by('F.id_descripcion'); // Agrupa por id_descripcion para evitar duplicados
        $this->db->order_by('A.id_usuario', 'ASC');

        $this->db->order_by('F.id_descripcion', 'DESC');
        $this->db->limit($limit);




        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }

    }

    public function getAnimalesRecomendados() {
        $this->db->select("A.*, F.url");
        $this->db->from('descripcion_animal A'); 
        $this->db->join('files F', 'F.id_descripcion = A.id_descripcion', 'left'); 
    
        $this->db->where('A.id_usuario', 1); 
        $this->db->limit(9, 0); 
    
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->result(); 
        } else {
            return false; 
        }
    }
    
    
    
    public function getAnimalesAgregados($limit = 18) {
        $this->db->select("A.*, F.url"); 
        $this->db->from('descripcion_animal A'); 
        $this->db->join('files F', 'F.id_descripcion = A.id_descripcion', 'left'); 
        
        $this->db->order_by('A.fecha_alta', 'DESC'); 
        $this->db->limit($limit); 
    
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->result(); 
        } else {
            return false; 
        }
    }
    

    public function getAnimalesNew($tipo)
    {

        $this->db->select("F.url,A.*,U.phone");
        $this->db->from('files F');
        $this->db->join('descripcion_animal A', 'F.id_descripcion = A.id_descripcion');
        $this->db->join(' Usuarios U', ' = A.id_usuario = U.id_user');
        $this->db->where('A.tipo', $tipo);
        $this->db->group_by('F.id_descripcion'); // Agrupa por id_descripcion para evitar duplicados

        $this->db->order_by('F.id_descripcion', 'DESC');




        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }

    }
    public function getNumero($tipo)
    {
       
        // Selecciona solo el conteo de los registros
        $this->db->select("COUNT(*) as total");
        $this->db->from('descripcion_animal A');
        $this->db->where('A.tipo', $tipo);

        // Ejecuta la consulta
        $query = $this->db->get();

        // Verifica si hay resultados
        if ($query->num_rows() > 0) {
            // Devuelve el número total de registros
            return $query->row()->total; // Accede al campo 'total' del resultado
        } else {
            return 0; // Devuelve 0 si no hay resultados
        }
    }

    public function getEstadoMunicipio($estado)
    {
     
        $this->db->select("M.municipio, EM.id");
        $this->db->from('estados_municipios EM');
        $this->db->join('municipios M', 'EM.municipios_id = M.id');
        $this->db->where('EM.estados_id', $estado);



        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }

    }




}