<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stockout extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('Stockout_model');
        $this->load->model('Item_model');
        $this->load->helper(array('form','url'));
        $this->load->library(array('form_validation','session'));
    }

    private function render($view, $data = []) {
        $data['contents'] = $this->load->view($view, $data, TRUE);
        $this->load->view('layouts/main', $data);
    }

    public function index(){
        $data['title'] = "Stock Out";
        $this->render('stockout/index', $data);
    }

    public function get_stockout() {
        $draw   = intval($this->input->post("draw"));
        $start  = intval($this->input->post("start") ?? 0);
        $length = intval($this->input->post("length") ?? 10);
        $search = $this->input->post("search")['value'] ?? '';

        $this->db->from("stock_out");
        $recordsTotal = $this->db->count_all_results();

        $this->db->from("stock_out");
        if (!empty($search)) {
            $this->db->like("code_item", $search);
            $this->db->or_like("item_name", $search);
            $this->db->or_like("qty_out", $search);
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
                $row->qty_out,
                $row->created_by,
                $row->created_at,
                '<a href="'.site_url('stockout/delete/'.$row->id).'" 
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
            'action'    => site_url('stockout/store'),
            'items'     => $this->Item_model->get_all(),
            'button'    => 'Create Stock Out',
            'errors'    => []
        );
        $this->render('stockout/form', $data);
    }

    public function store(){
        $this->form_validation->set_rules('code_item','Code Item','required');
        $this->form_validation->set_rules('qty_out','Qty OUT','required|greater_than[0]');

        if($this->form_validation->run() == FALSE){
            $this->create();
        } else {
            $code_item = $this->input->post('code_item');
            $qty_out   = $this->input->post('qty_out');

            $item = $this->Item_model->get_by_code($code_item);

            if(!$item){
                $this->session->set_flashdata('error', 'Item tidak ditemukan!');
                redirect('stockout/create');
                return;
            }

            if($item->stock < $qty_out){
                $this->session->set_flashdata('error', 'Stok tidak mencukupi! Stok saat ini: '.$item->stock);
                redirect('stockout/create');
                return;
            }

            $data = [
                'code_item'  => $item->code_item,
                'item_name'  => $item->item_name,
                'qty_out'    => $qty_out,
                'created_by' => 'Admin'
            ];
            $this->Stockout_model->insert($data);

            $this->db->set('stock', 'stock - '.$qty_out, FALSE);
            $this->db->where('code_item', $code_item);
            $this->db->update('items');

            // tambah log ke stock_history
            $history = [
                'type'       => 'OUT',
                'category'   => $item->category,
                'code_item'  => $item->code_item,
                'item_name'  => $item->item_name,
                'qty'        => $qty_out,
                'created_by' => 'Admin',
                'created_at' => date('Y-m-d H:i:s')
            ];
            $this->db->insert('stock_history', $history);

            $this->session->set_flashdata('success', 'Stok berhasil dikurangi!');
            redirect('stockout');
        }
    }

    public function delete($id){
        $this->Stockout_model->delete($id);
        redirect('stockout');
    }
}
