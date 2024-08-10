<?php
defined('BASEPATH') or exit('No direct script access allowed');
class UsuariosModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    

    public function get_all_usuarios_by_administracion($nocontar, $inicio, $filas, $administracion)
    {
        $this->db->select("U.id_usuario,CONCAT(U.nombre,' ',U.apellido_paterno,' ',U.apellido_materno) AS nombre,UNI.nombre_unidad,U.correo,U.telefono,GU.nombre_area,U.cargo, U.usuario, U.password");
        $this->db->from('usuarios U');
        $this->db->join('unidades_responsables UNI', 'U.id_unidad_responsable = UNI.id_unidad_responsable');
        $this->db->join('global_unidades GU', 'U.usuario_obras = GU.id_area', 'left');
        $this->db->where('U.id_administracion', $administracion);
        $this->db->where('U.estatus_eliminado', 0);
        $this->db->where('U.tipo','unidad');
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



    public function get_all_usuarios_by_administracion_sin_tkn($nocontar, $inicio, $filas, $administracion)
    {
        $this->db->select("U.id_usuario,U.nombre,U.apellido_paterno,U.apellido_materno,UNI.nombre_unidad,U.correo,U.telefono,GU.nombre_area,U.cargo");
        $this->db->from('usuarios U');
        $this->db->join('unidades_responsables UNI', 'U.id_unidad_responsable = UNI.id_unidad_responsable', 'left');
        $this->db->join('global_unidades GU', 'U.usuario_obras = GU.id_area', 'left');
        $this->db->where('U.id_administracion', $administracion);
        $this->db->where('U.tipo','unidad');
        $this->db->group_by('U.nombre', 'U.apellido_paterno', 'U.apellido_materno');
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

    public function getAllMunicipiosAsignados($idConsultor)
    {
        $this->db->select('A.id_administracion,A.fecha_inicio,A.fecha_termino,M.NombreMunicipio');
        $this->db->from('administraciones A');
        $this->db->join('municipios M', 'A.id_municipio = M.id_municipio');
        $this->db->where('A.responsable', $idConsultor);
        $query = $this->db->get();
        return $query->result();
    }

    public function getUsersByAdministracion($idAdministracion)
    {
        $this->db->select('*');
        $this->db->from('usuarios U');
        $this->db->join('unidades_responsables UR', 'UR.id_unidad_responsable = U.id_unidad_responsable');
        $this->db->join('administraciones A', 'A.id_administracion = U.id_administracion');
        $this->db->join('municipios M', 'M.id_municipio = A.id_municipio');
        $this->db->where('U.id_administracion', $idAdministracion);
        $this->db->where('U.tipo','unidad');
        $this->db->order_by("U.nombre", "asc");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function getOneUserByAdministracion($idAdministracion,$idUsuario)
    {
        $this->db->select('*');
        $this->db->from('usuarios U');
        $this->db->join('unidades_responsables UR', 'UR.id_unidad_responsable = U.id_unidad_responsable');
        $this->db->join('administraciones A', 'A.id_administracion = U.id_administracion');
        $this->db->join('municipios M', 'M.id_municipio = A.id_municipio');
        $this->db->where('U.id_administracion', $idAdministracion);
        $this->db->where('U.id_usuario',$idUsuario);
        $this->db->where('U.tipo','unidad');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function getUsersByRol($rol)
    {
        $this->db->select('*');
        $this->db->from('usuarios U');
        $this->db->join('administraciones A', 'A.id_administracion = U.id_administracion');
        $this->db->join('municipios M', 'M.id_municipio = A.id_municipio');
        $this->db->where('U.rol', $rol);
        $this->db->order_by("U.nombre", "asc");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function getUsersByGlobal($id, $administracion)
    {
        $this->db->select('*');
        $this->db->from('usuarios U');
        $this->db->join('unidades_responsables UR', 'UR.id_unidad_responsable = U.id_unidad_responsable');
        $this->db->join('administraciones A', 'A.id_administracion = U.id_administracion');
        $this->db->join('municipios M', 'M.id_municipio = A.id_municipio');
        $this->db->join('global_unidades G', 'G.id_area = U.usuario_obras');
        $this->db->where('U.id_administracion', $administracion);
        $this->db->where('U.usuario_obras', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function get_all_usuarios_inventario_by_administracion($nocontar, $inicio, $filas, $administracion)
    {
        $this->db->select("U.id_usuario,U.nombre,U.apellido_paterno,U.apellido_materno,UNI.nombre_unidad,U.correo,U.telefono,GU.nombre_area,U.id_unidad_responsable,U.id_administracion,U.usuario_obras");
        $this->db->from('usuarios U');
        $this->db->join('unidades_responsables UNI', 'U.id_unidad_responsable = UNI.id_unidad_responsable');
        $this->db->join('global_unidades GU', 'U.usuario_obras = GU.id_area', 'left');
        $this->db->where('U.id_administracion', $administracion);
        $this->db->where('U.tipo','unidad');
        $this->db->group_by('U.nombre', 'U.apellido_paterno', 'U.apellido_materno');
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

    public function get_all()
    {
        $q = $this->db->get('usuarios');
        return $q;
    }

    public function get_by_id($id)
    {
        return $this->db->get_where("usuarios", ['id_usuario' => $id])->row();
    }

    public function get_by_administracion($administracion)
    {
        $q = $this->db->get_where("usuarios", ['id_administracion' => $administracion]);
        return $q;
    }

    public function get_by_rol($rol)
    {
        $q = $this->db->get_where("usuarios", ['rol' => $rol]);
        return $q;
    }

    public function save($data)
    {
        $this->db->insert('usuarios', $data);
        return $this->db->insert_id();
    }

    public function savePadron($data)
    {
        $this->db->insert('padron_electoral', $data);
        return $this->db->insert_id();
    }

    public function edit($id, $data)
    {
        $this->db->where('id_usuario', $id);
        return $this->db->update('usuarios', $data);
    }

    public function delete($id)
    {
        $this->db->where('id_usuario', $id);
        return $this->db->delete('usuarios');
    }

    public function get_by_credenciales($usuario, $password)
    {
        return $this->db->select('id_user, name')->get_where('usuarios', array('user' => $usuario, 'password' => $password))->row();
    }

    

    public function verificar_token($token)
    {
        $tkn = $this->db->select('token')->get_where('usuarios', array('token' => $token))->row();
        if ($tkn) {
            if ($tkn->token == $token) {
                return true;
            }
            return false;
        }
        return false;
    }

    public function get_info_usuario($idUsuario)
    {
        $this->db->select('*');
        $this->db->from('usuarios U');
        $this->db->join('unidades_responsables UR', 'UR.id_unidad_responsable = U.id_unidad_responsable');
        $this->db->where('U.id_usuario', $idUsuario);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function get_all_usuarios_by_rol($nocontar, $inicio, $filas, $rol)
    {
        $this->db->select('U.id_usuario, CONCAT(U.nombre, " ", U.apellido_paterno, " ", U.apellido_materno) as nombre, U.usuario, U.password, U.escolaridad, U.experiencia, U.rol, A.nombre_area');
        $this->db->from('usuarios U');
        $this->db->join('global_unidades A', 'A.id_area = U.usuario_obras');
        $this->db->where('U.rol', $rol);
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

    public function get_all_usuarios_by_administracion_userpass($nocontar, $inicio, $filas, $administracion)
    {
        $this->db->select("*");
        $this->db->from('usuarios U');
        $this->db->join('unidades_responsables UNI', 'U.id_unidad_responsable = UNI.id_unidad_responsable');
        $this->db->join('global_jerarquia GLOJ','U.id_jerarquia = GLOJ.id_jerarquia');
        $this->db->where('U.id_administracion', $administracion);
        $this->db->where('U.tipo','unidad');
        $this->db->where('U.estatus_eliminado', 0);
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

    public function get_one_user_by_idadministracion_by_idjerarquia_by_idunidadglobal($idadministracion,$idjerarquia,$unidadglobal){
        $this->db->select('CONCAT(US.nombre, " ", US.apellido_paterno, " ", US.apellido_materno) AS responsable,UN.nombre_unidad AS nombre_unidad');
        $this->db->from('usuarios US');
        $this->db->join('unidades_responsables UN','US.id_unidad_responsable = UN.id_unidad_responsable');
        $this->db->where('US.id_administracion',$idadministracion);
        $this->db->where('US.id_jerarquia',$idjerarquia);
        $this->db->where('US.usuario_obras',$unidadglobal);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return ["responsable"=>"","nombre_unidad"=>""];
        }
    }

    public function get_all_users_by_idadministracion_jerarquia($idadministracion,$idjerarquia){
        $this->db->select('id_usuario,id_unidad_responsable,CONCAT(nombre, " ", apellido_paterno, " ", apellido_materno) AS nombrefuncionario');
        $this->db->from('usuarios');
        $this->db->where('id_administracion',$idadministracion);
        $this->db->where('id_jerarquia',$idjerarquia);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function getUsuariosByAdministracion($idadministracion){
        $this->db->select('*');
        $this->db->from('usuarios');
        $this->db->where('id_administracion',$idadministracion);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    
    public function get_all_funcionarios()
    {
        $this->db->select('
            t_funcionarios_info.claveelector,
            t_funcionarios_info.idfuncionario,
            t_funcionarios_info.curp,
            t_funcionarios_info.calleservidor,
            t_funcionarios_info.numeroexteriorservidor,
            t_funcionarios_info.numerointeriorservidor,
            t_funcionarios_info.cpservidor,
            t_funcionarios_info.coloniaservidor,
            t_funcionarios_info.municipioserviodr,
            t_funcionarios_info.estadoservidor,
            t_funcionarios_info.fechanacimiento,
            t_funcionarios_info.idfuncionario,
            t_funcionarios_info.idadministracion,
            usuarios.nombre AS nombre,
            usuarios.apellido_paterno AS apellido_paterno,
            usuarios.apellido_materno AS apellido_materno
        ');
        $this->db->from('t_funcionarios_info');
        $this->db->join('usuarios', 't_funcionarios_info.idfuncionario = usuarios.id_usuario');
        $query = $this->db->get();
        return $query->result();
    }

    public function actualizarCurpSiVacia($idUsuario, $curp) {
        $this->db->where('id_usuario', $idUsuario);
        $this->db->where('curp', '');
        $usuario = $this->db->get('usuarios')->row();
        if ($usuario) {
            $dataUsuario = ['curp' => $curp];
            $this->db->where('id_usuario', $idUsuario);
            $this->db->update('usuarios', $dataUsuario);
            return "Se actualizó la CURP '{$curp}' en la tabla usuarios para el id_usuario {$idUsuario}.";
        } else {
            return "No se encontró un usuario con id_usuario {$idUsuario} y curp vacía en la tabla usuarios.";
        }
    }
}