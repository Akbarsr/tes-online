<?php
class Stockout_model extends CI_Model {

    public function get_all() {
        return $this->db->get('stock_out')->result();
    }

    public function insert($data) {
        return $this->db->insert('stock_out', $data);
    }

    public function delete($id) {
        return $this->db->delete('stock_out', ['id' => $id]);
    }
}
