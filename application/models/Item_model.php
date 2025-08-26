<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Item_model extends CI_Model {

    private $table = "items";
    private $column_order = array(null, 'no','code_item','category','item_name','stock','created_by','created_at');
    private $column_search = array('no','code_item','category','item_name','stock','created_by','created_at');
    private $order = array('id' => 'DESC');

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query() {
        $this->db->from($this->table);

        $i = 0;
        foreach ($this->column_search as $item) {
            if($_POST['search']['value']) {
                if($i===0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if(count($this->column_search) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }

        if(isset($_POST['order'])) {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if(isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function get_datatables() {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered() {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all() {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function get_all() {
        return $this->db->order_by('id','DESC')->get($this->table)->result();
    }

    public function get_by_id($id) {
        return $this->db->where('id', $id)->get($this->table)->row();
    }

    public function insert($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data) {
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    public function delete($id) {
        return $this->db->where('id', $id)->delete($this->table);
    }
    public function get_by_code($code_item) {
        return $this->db->get_where('items', ['code_item' => $code_item])->row();
    }
    public function update_stock($code_item, $qty_in) {
        $this->db->set('stock', 'stock + '.$qty_in, FALSE);
        $this->db->where('code_item', $code_item);
        return $this->db->update('items');
    }

    public function generate_no() {
        $today = date('Ymd');
        $prefix = "DEV/".$today."/";
        $this->db->like('no', $prefix, 'after');
        $this->db->order_by('id','DESC');
        $last = $this->db->get($this->table)->row();

        if ($last) {
            $last_no = explode("/", $last->no);
            $seq = intval(end($last_no)) + 1;
        } else {
            $seq = 1;
        }

        return $prefix . str_pad($seq, 4, "0", STR_PAD_LEFT);
    }


}
