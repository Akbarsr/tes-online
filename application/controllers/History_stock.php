<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class History_stock extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('History_stock_model');
        $this->load->helper(array('form','url'));
        $this->load->library(array('form_validation'));
    }

    private function render($view, $data = []) {
        $data['contents'] = $this->load->view($view, $data, TRUE);
        $this->load->view('layouts/main', $data);
    }

    public function index(){
        $data['title'] = "History Stock";
        $this->render('history_stock/index', $data);
    }

   public function get_history() {
        $draw   = intval($this->input->post("draw"));
        $start  = intval($this->input->post("start") ?? 0);
        $length = intval($this->input->post("length") ?? 10);
        $search = $this->input->post("search")['value'] ?? '';

        $this->db->from("stock_history");
        $recordsTotal = $this->db->count_all_results();

        $this->db->from("stock_history");
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like("type", $search);
            $this->db->or_like("category", $search);
            $this->db->or_like("code_item", $search);
            $this->db->or_like("item_name", $search);
            $this->db->or_like("created_by", $search);
            $this->db->group_end();
        }
        $recordsFiltered = $this->db->count_all_results('', FALSE);

        $this->db->limit($length, $start);
        $query = $this->db->get();
        $data = [];

        foreach ($query->result() as $row) {
            $formatted_date = date("d/m/Y h:i A", strtotime($row->created_at)); 
            $data[] = [
                $row->code_item,
                $row->item_name,
                ucfirst($row->type),
                $row->category,
                number_format($row->qty),
                $row->created_by,
                $formatted_date
            ];
        }

        echo json_encode([
            "draw" => $draw,
            "recordsTotal" => $recordsTotal,
            "recordsFiltered" => $recordsFiltered,
            "data" => $data
        ]);
    }


  
    public function delete($id){
        $this->History_stock_model->delete($id);
        redirect('history_stock');
    }
}
