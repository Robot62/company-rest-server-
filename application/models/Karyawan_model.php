<?php
class Karyawan_model extends CI_Model
{
    public function getKaryawan($id = null)
    {
        if ($id === null) {
            return $this->db->get('karyawan')->result_array();
        } else {
            return $this->db->get_where('karyawan', ['id' => $id])->result_array();
        }
    }

    public function deleteKaryawan($id)
    {
        $this->db->delete('karyawan', ['id' => $id]);
        return $this->db->affected_rows();
    }
    public function createKaryawan($data)
    {
        
        $this->db->insert('karyawan', $data);
        return $this->db->affected_rows();
    }
    public function updateKaryawan($data, $id)
    {
        $this->db->update('karyawan', $data, ['id' => $id]);
        return $this->db->affected_rows();
    }
}