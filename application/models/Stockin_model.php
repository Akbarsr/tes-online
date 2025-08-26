<?php
class Stockin_model extends CI_Model {

    public function get_all() {
        return $this->db->get('stock_in')->result();
    }

    public function insert($data) {
        return $this->db->insert('stock_in', $data);
    }

    public function delete($id) {
        return $this->db->delete('stock_in', ['id' => $id]);
    }
}
