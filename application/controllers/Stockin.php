<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stockin extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('Stockin_model');
        $this->load->model('Item_model');
        $this->load->helper(array('form','url'));
        $this->load->library(array('form_validation'));
    }

    private function render($view, $data = []) {
        $data['contents'] = $this->load->view($view, $data, TRUE);
        $this->load->view('layouts/main', $data);
    }
    public function index(){
        $data['title'] = "Stock In";
        $this->render('stockin/index', $data);
    }


    public function get_stockin() {
        $draw   = intval($this->input->post("draw"));
        $start  = intval($this->input->post("start") ?? 0);
        $length = intval($this->input->post("length") ?? 10);
        $search = $this->input->post("search")['value'] ?? '';

        $this->db->from("stock_in");
        $recordsTotal = $this->db->count_all_results();

        $this->db->from("stock_in");
        if (!empty($search)) {
            $this->db->like("code_item", $search);
            $this->db->or_like("item_name", $search);
            $this->db->or_like("qty_in", $search);
            $this->db->or_like("created_by", $search);
        }
        $recordsFiltered = $this->db->count_all_results('', FALSE);

        $this->db->limit($length, $start);
        $query = $this->db->get();

        $data = [];
        foreach ($query->result() as $row) {
            $data[] = [
                $row->code_item,
                $row->item_name,
                $row->qty_in,
                $row->created_by,
                $row->created_at,
                '<a href="'.site_url('stockin/delete/'.$row->id).'" 
                    class="btn btn-danger btn-sm" 
                    onclick="return confirm(\'Hapus data ini?\')">Delete</a>'
            ];
        }

        echo json_encode([
            "draw" => $draw,
            "recordsTotal" => $recordsTotal,
            "recordsFiltered" => $recordsFiltered,
            "data" => $data
        ]);
    }

    public function create(){
            $data = array(
            'action'    => site_url('items/store'),
            'items'        => $this->Item_model->get_all(),
            'button'    => 'Create Stock In',
            'errors'    => []
        );
        $this->render('stockin/form', $data);
    }

    // simpan data stock in
    public function store(){
        $this->form_validation->set_rules('code_item','Code Item','required');
        $this->form_validation->set_rules('qty_in','Qty IN','required|greater_than[0]');

        if($this->form_validation->run() == FALSE){
            $this->create();
        } else {
            $item = $this->Item_model->get_by_code($this->input->post('code_item'));

            $data = [
                'code_item'  => $this->input->post('code_item'),
                'item_name'  => $item->item_name,
                'qty_in'     => $this->input->post('qty_in'),
                'created_by' => 'Admin'
            ];
            $this->Stockin_model->insert($data);

            // update stok di table items
            $this->db->set('stock', 'stock + '.$this->input->post('qty_in'), FALSE);
            $this->db->where('code_item', $this->input->post('code_item'));
            $this->db->update('items');
            $history = [
                'type'       => 'IN', // karena ini stock in
                'category'   => $item->category,
                'code_item'  => $item->code_item,
                'item_name'  => $item->item_name,
                'qty'        => $this->input->post('qty_in'),
                'created_by' => 'Admin',
                'created_at' => date('Y-m-d H:i:s')
            ];
            $this->db->insert('stock_history', $history);
            redirect('stockin');
        }
    }

    public function delete($id){
        $this->Stockin_model->delete($id);
        redirect('stockin');
    }
}
