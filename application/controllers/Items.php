<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Items extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('Item_model');
        $this->load->helper(array('form','url'));
        $this->load->library(array('form_validation'));
    }
    private function render($view, $data = []) {
        $data['contents'] = $this->load->view($view, $data, TRUE);
        $this->load->view('layouts/main', $data);
    }
    public function index(){
        $data['title'] = "Daftar Barang";
        $this->render('items/index', $data);
    }

    public function get_items() {
        $draw   = intval($this->input->post("draw"));
        $start  = intval($this->input->post("start") ?? 0);
        $length = intval($this->input->post("length") ?? 10);
        $search = $this->input->post("search")['value'] ?? '';

        // Ambil total data
        $this->db->from("items");
        $recordsTotal = $this->db->count_all_results();

        // Query dengan search
        $this->db->from("items");
        if (!empty($search)) {
            $this->db->like("no", $search);
            $this->db->or_like("code_item", $search);
            $this->db->or_like("category", $search);
            $this->db->or_like("item_name", $search);
        }
        $recordsFiltered = $this->db->count_all_results('', FALSE);

        $this->db->limit($length, $start);
        $query = $this->db->get();
        $data = [];
        foreach ($query->result() as $row) {
            $created_at = !empty($row->created_at) 
        ? date("d M Y/H:i:s", strtotime($row->created_at)) 
        : '';
            $data[] = [
                $row->no,
                $row->code_item,
                $row->category,
                $row->item_name,
                $row->stock,
                $row->created_by,
                $created_at,
                '<a href="'.site_url('items/edit/'.$row->id).'" class="btn btn-warning btn-sm">Edit</a>
                 <a href="'.site_url('items/delete/'.$row->id).'" class="btn btn-danger btn-sm" onclick="return confirm(\'Hapus data ini?\')">Delete</a>'
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
            'no'        => $this->Item_model->generate_no(),
            'code_item' => '',
            'category'  => '',
            'item_name' => '',
            'stock'     => '',
            'button'    => 'Create Barang',
            'errors'    => []
        );
        $this->render('items/form', $data);
    }

    public function store(){
        $this->form_validation->set_rules('category','Category','required');
        $this->form_validation->set_rules('item_name','Item Name','required');
        $this->form_validation->set_rules('stock','Stock','required|numeric|greater_than_equal_to[0]');

        if($this->form_validation->run() == FALSE){
            $data = array(
                'action'    => site_url('items/store'),
                'no'        => $this->input->post('no'),
                'code_item' => $this->input->post('code_item'),
                'category'  => set_value('category'),
                'item_name' => set_value('item_name'),
                'stock'     => set_value('stock'),
                'button'    => 'Simpan Barang',
                'errors'    => validation_errors('<div class="alert alert-danger">','</div>')
            );
            $this->render('items/form', $data);
        } else {
            $insert = array(
                'no'         => $this->input->post('no'),
                'code_item'  => $this->input->post('code_item'),
                'category'   => $this->input->post('category'),
                'item_name'  => $this->input->post('item_name'),
                'stock'      => $this->input->post('stock'),
                'created_by' => 'Admin'
            );
            $this->Item_model->insert($insert);
            redirect('items');
        }
    }

    public function edit($id){
        $item = $this->Item_model->get_by_id($id);
        $data = array(
            'action'    => site_url('items/update/'.$id),
            'no'        => $item->no,
            'code_item' => $item->code_item,
            'category'  => $item->category,
            'item_name' => $item->item_name,
            'stock'     => $item->stock,
            'button'    => 'Update Barang',
            'errors'    => []
        );
        $this->render('items/form', $data);
    }

    public function update($id){
        $this->form_validation->set_rules('category','Category','required');
        $this->form_validation->set_rules('item_name','Item Name','required');
        $this->form_validation->set_rules('stock','Stock','required|numeric|greater_than_equal_to[0]');

        if($this->form_validation->run() == FALSE){
            $this->edit($id);
        } else {
            $update = array(
                'category'  => $this->input->post('category'),
                'item_name' => $this->input->post('item_name'),
                'stock'     => $this->input->post('stock'),
            );
            $this->Item_model->update($id, $update);
            redirect('items');
        }
    }

    public function delete($id){
        $this->Item_model->delete($id);
        redirect('items');
    }
}
