<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ClienteModel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    public function getAnimales($tipo)
    {

        $this->db->select("F.url,A.*");
        $this->db->from('files F');
        $this->db->join('descripcion_animal A', 'F.id_descripcion = A.id_descripcion');
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



}