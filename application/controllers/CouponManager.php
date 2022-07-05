<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 */
defined('BASEPATH') OR exit('No direct script access allowed');
ob_start();

class CouponManager extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Product_model');
        $this->load->model('User_model');
        $this->load->library('session');
        $this->checklogin = $this->session->userdata('logged_in');
        $this->user_id = $this->checklogin ? $this->session->userdata('logged_in')['login_id'] : 0;
    }

    public function index() {
        $data = array();
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('coupon_conf');
        $coupon_list = $query->result_array();
        $data['coupon_list'] = $coupon_list;

        if (isset($_POST['submitData'])) {
            $confArray = array(
                "code" => $this->input->post("code"),
                "value" => $this->input->post("value"),
                "value_type" => $this->input->post("value_type"),
                "coupon_type" => $this->input->post("coupon_type"),
                "valid_till" => $this->input->post("valid_till"),
                "promotion_message" => $this->input->post("promotion_message"),
            );
            $this->db->insert('coupon_conf', $confArray);
            redirect("CouponManager/index");
        }


        $this->load->view("CouponManagement/list", $data);
    }

    public function couponReport() {
        $data['exportdata'] = 'yes';
        $date1 = date('Y-m-') . "01";
        $date2 = date('Y-m-d');
        if (isset($_GET['daterange'])) {
            $daterange = $this->input->get('daterange');
            $datelist = explode(" to ", $daterange);
            $date1 = $datelist[0];
            $date2 = $datelist[1];
        }
        $daterange = $date1 . " to " . $date2;
        $data['daterange'] = $daterange;

        $this->db->order_by('id', 'desc');
        $this->db->where('order_date between "' . $date1 . '" and "' . $date2 . '"');
        $query = $this->db->get('user_order');
        $orderlist = $query->result();
        $orderslistr = [];
        foreach ($orderlist as $key => $value) {
            $this->db->order_by('id', 'desc');
            $this->db->where('order_id', $value->id);
            $query = $this->db->get('user_order_status');
            $status = $query->row();
            $value->status = $status ? $status->status : $value->status;
            $value->status_datetime = $status ? $status->c_date . " " . $status->c_time : $value->order_date . " " . $value->order_time;
            $this->db->order_by('id', 'desc');
            $this->db->where('order_id', $value->id);
            $query = $this->db->get('cart');
            $cartdata = $query->result();
            $tempdata = array();
            $itemarray = array();
            foreach ($cartdata as $key1 => $value1) {
                array_push($tempdata, $value1->item_name . "(" . $value1->quantity . ")");
                $itemarray[$value1->item_name] = $value1->quantity;
            }
            $value->itemsarray = $itemarray;
            $value->items = implode(", ", $tempdata);
            array_push($orderslistr, $value);
        }
        $data['orderslist'] = $orderslistr;
        $this->load->view('CouponManagement/orderslist', $data);
    }

}
