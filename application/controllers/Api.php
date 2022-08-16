<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require(APPPATH . 'libraries/REST_Controller.php');

class Api extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Product_model');
        $this->load->model('Order_model');
        $this->load->library('session');
        $this->checklogin = $this->session->userdata('logged_in');
        $this->user_id = $this->checklogin ? $this->session->userdata('logged_in')['login_id'] : 0;
    }

    public function index() {
        $this->load->view('welcome_message');
    }

    function updateCurd_post() {
        $fieldname = $this->post('name');
        $value = $this->post('value');
        $pk_id = $this->post('pk');
        $tablename = $this->post('tablename');
        if ($this->checklogin) {
            $data = array($fieldname => $value);
            $this->db->set($data);
            $this->db->where("id", $pk_id);
            $this->db->update($tablename, $data);
        }
    }

    //function for product list
    function loginOperation_get() {
        $userid = $this->user_id;
        $this->db->select('au.id,au.first_name,au.last_name,au.email,au.contact_no');
        $this->db->from('admin_users au');
        $this->db->where('id', $userid);
        $this->db->limit(1);
        $query = $this->db->get();
        $result = $query->row();
        $this->response($result);
    }

    //Login Function 
    //function for product list
    function loginOperation_post() {
        $email = $this->post('contact_no');
        $password = $this->post('password');
        $this->db->select('au.id,au.first_name,au.last_name,au.email,au.contact_no');
        $this->db->from('admin_users au');
        $this->db->where('contact_no', $email);
        $this->db->where('password', md5($password));
        $this->db->limit(1);
        $query = $this->db->get();
        $result = $query->row();

        $sess_data = array(
            'username' => $result->email,
            'first_name' => $result->first_name,
            'last_name' => $result->last_name,
            'login_id' => $result->id,
        );
        $this->session->set_userdata('logged_in', $sess_data);
        $this->response($result);
    }

    function registerMobileGuest_post() {
        $this->config->load('rest', TRUE);
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $reg_id = $this->post('reg_id');
        $model = $this->post('model');
        $manufacturer = $this->post('manufacturer');
        $uuid = $this->post('uuid');
        $regArray = array(
            "reg_id" => $reg_id,
            "manufacturer" => $manufacturer,
            "uuid" => $uuid,
            "model" => $model,
            "user_id" => "Guest",
            "user_type" => "Guest",
            "datetime" => date("Y-m-d H:i:s a")
        );
        $this->db->where('reg_id', $reg_id);
        $query = $this->db->get('gcm_registration');
        $regarray = $query->result_array();
        if ($regArray) {
            
        } else {
            $this->db->insert('gcm_registration', $regArray);
        }
        $this->response(array("status" => "done"));
    }

    //Mobile Booking APi
    function orderFromMobile_post() {
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
        header('Access-Control-Allow-Origin: *');

        $this->config->load('rest', TRUE);
        $bookingarray = $this->post();

        $cartdata = $this->post("cartdata");
        $cartjson = json_decode($cartdata);

        $web_order = array(
            'name' => $this->post('name'),
            'email' => $this->post('email'),
            'contact_no' => $this->post('contact_no'),
            'address' => $this->post('address'),
            'pincode' => $this->post('pincode'),
            'order_date' => date("Y-m-d"),
            'order_time' => date("H:i:s a"),
            'total_quantity' => $this->post('quantity'),
            'total_price' => $this->post('total'),
            'payment_mode' => $this->post('payment_method'),
            'status' => "Processing",
            'user_id' => $this->post('user_id') ? $this->post('user_id') : 'Guest',
            'order_key' => $this->post('user_id') ? $this->post('user_id') : 'Guest',
        );
        $this->db->insert('user_order', $web_order);

        $last_id = $this->db->insert_id();
        $oderid = $last_id;

        $orderno = "JL" . date('Y/m/d') . "/" . $last_id;
        $orderkey = md5($orderno);
        $this->db->set('order_no', $orderno);
        $this->db->set('order_key', $orderkey);
        $this->db->where('id', $last_id);
        $this->db->update('user_order');

        $order_status_data = array(
            'c_date' => date('Y-m-d'),
            'c_time' => date('H:i:s'),
            'order_id' => $last_id,
            'status' => "Order Confirmed",
            'user_id' => $this->post('user_id') ? $this->post('user_id') : 'Guest',
            'remark' => "Order Confirmed By Using COD,  Waiting For Payment",
        );
        $this->db->insert('user_order_status', $order_status_data);

        foreach ($cartjson as $key => $value) {



            $product_dict = array(
                'title' => $value->title,
                'price' => $value->price,
                'sku' => $value->sku,
                'attrs' => "",
                'vendor_id' => "",
                'total_price' => $value->total_price,
                'file_name' => base_url() . 'assets/product_images/' . $value->file_name,
                'quantity' => $value->quantity,
                'user_id' => $value->title,
                'credit_limit' => 0,
                'order_id' => $last_id,
                'product_id' => '',
                'op_date_time' => date('Y-m-d H:i:s'),
            );

            $this->db->insert('cart', $product_dict);
        }
        $this->response(array("order_id" => $oderid));
    }

    function registration_post() {
        $this->config->load('rest', TRUE);
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $name = $this->post('name');
        $email = $this->post('email');
        $contact_no = $this->post('contact_no');
        $password = $this->post('password');
        $usercode = rand(10000000, 99999999);
        $regArray = array(
            "name" => $name,
            "email" => $email,
            "contact_no" => $contact_no,
            "password" => $password,
            "usercode" => $usercode,
            "datetime" => date("Y-m-d H:i:s a")
        );
        $this->db->where('email', $email);
        $query = $this->db->get('app_user');
        $userdata = $query->row();
        if ($userdata) {
            $this->response(array("status" => "already", "userdata" => ""));
        } else {
            $this->db->insert('app_user', $regArray);
            $this->response(array("status" => "done", "userdata" => $regArray));
        }
    }

    function loginmob_post() {
        $this->config->load('rest', TRUE);
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $email = $this->post('contact_no');
        $password = $this->post('password');
        $regArray = array(
            "email" => $email,
            "password" => $password,
        );
        $this->db->where('contact_no', $email);
        $this->db->where('password', $password);
        $query = $this->db->get('app_user');
        $userdata = $query->row();
        if ($userdata) {
            $this->response(array("status" => "done", "userdata" => $userdata));
        } else {
            $this->response(array("status" => "error", "userdata" => ""));
        }
    }

    function updateProfile_post() {
        $this->config->load('rest', TRUE);
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $email = $this->post('email');
        $profiledata = array(
            'name' => $this->post('name'),
            'email' => $this->post('email'),
            'contact_no' => $this->post('contact_no'),
        );
        $this->db->set($profiledata);
        $this->db->where('email', $email); //set column_name and value in which row need to update
        $this->db->update("app_user");
        $this->db->order_by('name asc');

        $this->db->where('email', $email); //set column_name and value in which row need to update
        $query = $this->db->get('app_user');
        $userData = $query->row();
        $this->response(array("userdata" => $userData));
    }

    //function for product list
    function userbooking_post() {
        $this->config->load('rest', TRUE);
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $email = $this->post('email');
        $this->db->order_by('id desc');
        $this->db->where('email', $email);
        $query = $this->db->get("web_order");
        $result = $query->result();
        $this->response($result);
    }

//
    //function for product list
    function userorder_get($user_id) {
        $this->db->where('user_id', $user_id);
        $this->db->order_by('id desc');
        $query = $this->db->get("user_order");
        $order_mobile = $query->result_array();
//        $orderlist = [];
//        foreach ($order_mobile as $key => $value) {
//            $orderid = $value['id'];
//            $this->db->where('order_id', $orderid);
//            $query = $this->db->get("ordercart");
//            $cartdata = $query->result_array();
//            $value['cart_data'] = $cartdata;
//            array_push($orderlist, $value);
//        }
        $this->response($order_mobile);
    }

    //function for order details list
    function userorderdetails_get($order_id) {
        $this->db->where('id', $order_id);
        $this->db->order_by('id desc');
        $query = $this->db->get("user_order");
        $order_mobile = $query->row();
        $orderdetails = array("order" => $order_mobile);

        $orderid = $order_mobile->id;
        $this->db->where('order_id', $order_id);
        $query = $this->db->get("cart");
        $cartdata = $query->result_array();
        $orderdetails['cart_data'] = $cartdata;

        $this->response($orderdetails);
    }

    //-----------
    //function for product list

    function category_get() {
        $cats = [65, 67, 69, 70, 71, 73];
        $cats = [1, 2, 3, 4, 5, 6, 7, 8];
        $this->config->load('rest', TRUE);
        $this->db->where_in("id", $cats);
        $query = $this->db->get("category");
        $galleryList = $query->result();
        $this->response($galleryList);
    }

    function productCategoryAll_get() {
        $this->config->load('rest', TRUE);
        $query = $this->db->get("category");
        $galleryList = $query->result();
        $this->response($galleryList);
    }

    function productCategory_get($category_id) {
        $this->config->load('rest', TRUE);
        $categorieslist = $this->Product_model->get_children($category_id, array());
        $this->response($categorieslist);
    }

    function productDetails_get($prodct_id) {
        $this->config->load('rest', TRUE);
        $this->db->where_in("id", $prodct_id);
        $query = $this->db->get("products");
        $productlist = $query->row();
        $this->response($productlist);
    }

    function mobilebrands_get() {
        $cats = [74, 75, 78, 77];
        $this->config->load('rest', TRUE);
        $this->db->where_in("id", $cats);
        $query = $this->db->get("category");
        $galleryList = $query->result();
        $catelist = [];
        foreach ($galleryList as $key => $value) {
            if ($key % 2 == 0) {
                $templist = [$galleryList[$key], $galleryList[$key + 1]];
                array_push($catelist, $templist);
            }
        }
        $this->response($catelist);
    }

    function productListSearch_get() {
        $this->config->load('rest', TRUE);
        $search = $this->get('search');
        $this->db->where("title like '%$search%'");
        $this->db->where("status", '1');
//        $this->db->where_in("stock_status", 'In Stock');
        $query = $this->db->get("products");
        $productlist = $query->result();
        $this->response($productlist);
    }

    function productList_get($categoryid) {
        $this->config->load('rest', TRUE);
        $categoriesString = $this->Product_model->stringCategories($categoryid);
        $categoriesString = ltrim($categoriesString, ", ");
        $categorylist = explode(", ", $categoriesString);
        if ($categoriesString) {
            $categorylist = $categorylist;
        } else {
            $categorylist = [];
        }
        array_push($categorylist, $categoryid);
        $this->db->where_in("category_id", $categorylist);
        $this->db->where("status", '1');
//        $this->db->where_in("stock_status", 'In Stock');
        $query = $this->db->get("products");
        $productlist = $query->result();
        $this->response($productlist);
    }

    function productListOffers_get($categoryid) {
        $this->config->load('rest', TRUE);
        $categoriesString = $this->Product_model->stringCategories($categoryid);
        $categoriesString = ltrim($categoriesString, ", ");
        $categorylist = explode(", ", $categoriesString);
        if ($categoriesString) {
            $categorylist = $categorylist;
        } else {
            $categorylist = [];
        }
        array_push($categorylist, $categoryid);
        $this->db->where_in("category_id", $categorylist);
        $this->db->where("status", '1');
        $this->db->where("offer", '1');
//        $this->db->where_in("stock_status", 'In Stock');
        $query = $this->db->get("products");
        $productlist = $query->result();
        $this->response($productlist);
    }

    function productListOffersFront_get($categoryid) {
        $this->config->load('rest', TRUE);
        $categoriesString = $this->Product_model->stringCategories($categoryid);
        $categoriesString = ltrim($categoriesString, ", ");
        $categorylist = explode(", ", $categoriesString);
        if ($categoriesString) {
            $categorylist = $categorylist;
        } else {
            $categorylist = [];
        }
        array_push($categorylist, $categoryid);
        $this->db->where_in("category_id", $categorylist);
        $this->db->where("status", '1');
        $this->db->where("offer", '1');
        $this->db->limit(10);
        $query = $this->db->get("products");
        $productlist = $query->result();
        $this->response($productlist);
    }

    function enquiry_post() {
        $this->config->load('rest', TRUE);
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $enquiry = array(
            'name' => $this->post('name'),
            'message' => $this->post('message'),
            'email' => $this->post('email'),
            'contact' => $this->post('contact_no'),
        );

        $this->db->insert('web_enquiry', $enquiry);
    }

    function paymentInstamojo_get() {
        $this->config->load('rest', TRUE);
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://www.instamojo.com/api/1.1/payment-requests/');
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER,
                array("X-Api-Key:7987c263e708a6a7c88eebe6701dc834",
                    "X-Auth-Token:ad1c848926d896c37a2d0dad200261c2"));
        $payload = Array(
            'purpose' => 'FIFA 16',
            'amount' => '2500',
            'phone' => '9999999999',
            'buyer_name' => 'John Doe',
            'redirect_url' => 'http://www.example.com/redirect/',
            'send_email' => true,
            'webhook' => 'http://www.example.com/webhook/',
            'send_sms' => true,
            'email' => 'foo@example.com',
            'allow_repeated_payments' => false
        );
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
        $response = curl_exec($ch);
        curl_close($ch);
        $this->response($response);
    }

    public function donationListApi_get() {
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
        header('Access-Control-Allow-Origin: *');
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));

        $c_query = "SELECT * "
                . "FROM `charity_donation` where confirm_status!='Delete' order by id desc";

        $querytotal = $this->db->query($c_query);

        $query = "$c_query  limit  $start, $length";
        $queryfilter = $this->db->query($query);
        $result_array = $queryfilter->result_array();

        $return_array = [];
        foreach ($result_array as $key => $value) {
            $value["datetime"] = $value["date"] . " " . $value["time"];
            $value["donate_name"] = "<b>" . $value["name"] . "</b><br/>" . $value["contact_no"] . "<br/>" . $value["email"];
            $value["anonymous_donation"] = $value["anonymous_donation"] == "true" ? "Yes" : "";
            if ($value["confirm_status"] == "Confirm") {
                $value["confirm"] = "";
                $value["delete"] = "";
            } else {
                $value["confirm"] = "<a class='btn btn-success' href='" . site_url("Charity/confirm/" . $value["id"]) . "' title='Confirm Now'><i class='fa fa-check'></i></a>";
                $value["delete"] = "<a class='btn btn-danger' href='" . site_url("Charity/delete/" . $value["id"]) . "' title='Confirm Now'><i class='fa fa-trash'></i></a>";
            }
            array_push($return_array, $value);
        }


        $output = array(
            "draw" => $draw,
            "recordsTotal" => $querytotal->num_rows(),
            "recordsFiltered" => $queryfilter->num_rows(),
            "data" => $return_array
        );
        echo json_encode($output);
        exit();
    }

    //Pre Design Profile
    function getUserPreDesingByItem_get($user_id, $item_id) {
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
        header('Access-Control-Allow-Origin: *');
        $previouse_profiledata = $this->Product_model->selectPreviouseProfiles($user_id, $item_id);
        $this->response($previouse_profiledata);
    }

    function getSingleDesing_get($design_id) {
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
        header('Access-Control-Allow-Origin: *');
        $previouse_profiledata = $this->Product_model->singleProfileDetails($design_id);
        $this->response($previouse_profiledata);
    }

    function deleteUserPreDesing_get($desing_id) {
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
        header('Access-Control-Allow-Origin: *');
        $this->db->set("status", "d");
        $this->db->where("id", $desing_id);
        $this->db->update("cart_customization_profile");
    }

    function favoriteUserPreDesing_get($desing_id, $status = 0) {
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
        header('Access-Control-Allow-Origin: *');
        if ($status) {
            $this->db->set("status", "");
        } else {
            $this->db->set("status", "f");
        }
        $this->db->where("id", $desing_id);
        $this->db->update("cart_customization_profile");
    }

    //end of design profile
    //
    //
    //pre measurement profiles
    function getUserPreMeasurementByItem_get($user_id, $item_id = "") {
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
        header('Access-Control-Allow-Origin: *');
        $previouse_profiledata = $this->Product_model->selectPreviousMeasurements($user_id, $item_id);
        $this->response($previouse_profiledata);
    }

    function getSingleMeasurementById_get($measurement_id) {
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
        header('Access-Control-Allow-Origin: *');
        $previouse_profiledata = $this->Product_model->selectPreviouseMeasurementProfilesReport($measurement_id);
        $this->response($previouse_profiledata);
    }

    function getMeausrementData_get() {
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
        header('Access-Control-Allow-Origin: *');
        $this->db->select("title, min_value, max_value, standard_value");
//        $this->db->order_by("display_index");
        $query = $this->db->get("measurement");
        $measurementdata = $query->result_array();
        $measurementdataDict = array();
        foreach ($measurementdata as $key => $value) {
            $measurementdataDict[$value["title"]] = $value;
        }
        $this->response($measurementdataDict);
    }

    function deleteUserPreMeasurement_get($mes_id) {
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
        header('Access-Control-Allow-Origin: *');
        $this->db->set("status", "d");
        $this->db->where("id", $mes_id);
        $this->db->update("custom_measurement_profile");
    }

    function favoriteUserPreMeasurement_get($mes_id, $status = 0) {
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
        header('Access-Control-Allow-Origin: *');
        if ($status) {
            $this->db->set("status", "");
        } else {
            $this->db->set("status", "f");
        }
        $this->db->where("id", $mes_id);
        $this->db->update("custom_measurement_profile");
    }

//   news letter subscription


    function getUserSubscription_get($user_id) {
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
        header('Access-Control-Allow-Origin: *');
        $resultData = array("has_subscription" => "no", "subscription_data" => array());
        $querydata = $this->Order_model->getUserSubscriptionByUserId($user_id);
        if ($querydata) {
            $resultData["subscription_data"] = $querydata;
            $resultData["has_subscription"] = "yes";
        }
        $this->response($resultData);
    }

    function setUserSubscription_get($user_id, $sub_type) {
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
        header('Access-Control-Allow-Origin: *');
        $querydata = $this->Order_model->getUserSubscriptionByUserId($user_id);

        $userquery = $this->db->where("id", $user_id)->get("admin_users");
        $userdata = $userquery ? $userquery->row_array() : array("email" => "");

        $subdata = array(
            "newsletter_type" => urldecode($sub_type),
            'c_time' => date('H:i:s a'),
            'c_date' => date('Y-m-d'),
            'email' => $userdata["email"],
            'user_type' => "Website User"
        );

        if ($querydata) {
            $this->db->set($subdata);
            $this->db->where("user_id", $user_id);
            $this->db->update("newsletter_subscription");
        } else {
            $subdata["user_id"] = $user_id;
            $this->db->insert('newsletter_subscription', $subdata);
        }
    }

    function resetPassword_post() {

        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $email = $this->post('email');
        $this->db->where('email', $email); //set column_name and value in which row need to update
        $query = $this->db->get("admin_users");
        $userData = $query->row_array();
        $status = "404";
        if ($userData) {
            $status = "200";
            $this->Order_model->resetPasswordMail($userData);
        }

        $this->response(array("status" => $status));
    }

    function test_resetPassword_get($user_id) {
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
        header('Access-Control-Allow-Origin: *');
        $this->db->where('id', $user_id); //set column_name and value in which row need to update
        $query = $this->db->get("admin_users");
        $userData = $query->row_array();
        $this->Order_model->resetPasswordMail($userData);
    }

    function updateCustomeDesign_post() {
        print_r($this->post());
        $fieldname = $this->post('name');
        $value = $this->post('value');
        $pk_id = $this->post('pk');
        $tablename = $this->post('tablename');
        $foregin_id = $this->post('foregin_id');
        $data = array("style_value" => $value);
        $this->db->set($data);
        $this->db->where("profile_id", $pk_id);
        $this->db->where("style_key", $fieldname);
        $this->db->update($tablename);
    }

    function updateCustomeMeasurement_post() {
        print_r($this->post());
        $fieldname = $this->post('name');
        $value = $this->post('value');
        $pk_id = $this->post('pk');
        $tablename = $this->post('tablename');
        $foregin_id = $this->post('foregin_id');
        $data = array("measurement_value" => $value);
        $this->db->set($data);
        $this->db->where("custom_measurement_profile", $pk_id);
        $this->db->where("measurement_key", $fieldname);
        $this->db->update($tablename);
    }

    //ProductList APi
    public function productListApi_get($category_id, $custom_id) {
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
        header('Access-Control-Allow-Origin: *');
        $attrdatak = $this->get();
        $startpage = $attrdatak["start"] - 1;
        $endpage = $attrdatak["end"];
        unset($attrdatak["start"]);
        unset($attrdatak["end"]);
        $products = [];
        $countpr = 0;
        $pricequery = "";
        $psearch = "";
        if (isset($attrdatak["search"])) {
            $searchdata = $attrdatak["search"];
            unset($attrdatak["search"]);
            if ($searchdata) {
                $psearch = " and title like '%$searchdata%' ";
            }
        }
        $filterquery = "";
        if (isset($attrdatak["filter"])) {
            switch ($attrdatak["filter"]) {
                case "Sales":
                    $filterquery = "  is_sale desc, ";

                    break;
                case "Popular":
                    $filterquery = "  is_populer  desc, ";
                    break;
                case "Related":

                    break;
                default:
            }
        }

        $pricefilter = isset($attrdatak['pfilter']) ? $attrdatak['pfilter'] . "" : "";
        $pricelistarray = array();
        if ($pricefilter) {
            $pricelistarrayt = explode("--", $pricefilter);
            foreach ($pricelistarrayt as $key => $value) {
                $pricelistarray[$value] = $value;
            }
        }


        if (isset($attrdatak["a47"])) {
            $val = str_replace("-", ", ", $attrdatak["a47"]);
            $query_attr = "SELECT product_id FROM product_attribute
                           where  attribute_id in (47) and attribute_value_id in ($val)
                           group by product_id";
            $queryat = $this->db->query($query_attr);
            $productslist = $queryat ? $queryat->result() : array();
            foreach ($productslist as $key => $value) {
                array_push($products, $value->product_id);
            }
        }

        //print_r($products);

        $productdict = [];

        $productcheck = array_count_values($products);

        //print_r($productcheck);

        foreach ($productcheck as $key => $value) {
            if ($value == 1) {
                array_push($productdict, $key);
            }
        }

        $proquery = "";
        if (count($productdict)) {
            $proquerylist = implode(",", $productdict);
            $proquery = " and pt.id in ($proquerylist) ";
        }

        $categoriesString = $this->Product_model->stringCategories($category_id) . ", " . $category_id;
        $categoriesString = ltrim($categoriesString, ", ");

        $product_query = "select pt.id as product_id, pt.*
            from products as pt where pt.category_id in ($categoriesString) $psearch $pricequery $proquery  order by $filterquery display_index desc";
        $product_result = $this->Product_model->query_exe($product_query);

        $productListSt = [];

        $productListFinal = [];
        $productListFinalTotal = [];

        $pricecount = [];

        $priceListWidget = array();

        $brandWidget = array();

        foreach ($product_result as $key => $value) {
            $value['attr'] = $this->Product_model->singleProductAttrs($value['product_id']);
            $item_price = $this->Product_model->category_items_prices_id2($value['category_items_id'], $custom_id);

            $brandcheck = $this->db->select("category_name as brand")->where("id", $value['category_items_id'])->get("category_items");
            $brandname = $brandcheck ? $brandcheck->row_array()["brand"] : "";

            $price_p = $item_price ? $item_price->price : 0;
            $price_s = $item_price ? $item_price->sale_price : 0;

            $value['price'] = $value['is_sale'] == 'true' ? $price_s : $price_p;
            $value['org_price'] = $price_p;

            if ($brandname) {
                $brandWidget[$brandname] = $price_p;
            }


            array_push($pricecount, $value['price']);

            $priceListWidget[$price_p] = $price_p;

            if ($pricelistarray) {

                if (isset($pricelistarray[$price_p])) {

                    array_push($productListFinal, $value);
                    array_push($productListSt, $value['product_id']);
                }
            } else {


                array_push($productListFinal, $value);
                array_push($productListSt, $value['product_id']);
            }

//            array_push($productListFinal, $value);
        }

        $attr_filter = array();
        $pricelist = array();
        if (count($productListSt)) {
            $pricelist = array('maxprice' => max($pricecount), 'minprice' => min($pricecount));

            $productString = implode(",", $productListSt);

            $attr_query = "select count(cav.id) product_count, '' as checked, cvv.widget, cav.attribute_value, cav.additional_value, cav.id, pa.attribute, pa.attribute_id from product_attribute as pa
        join category_attribute_value as cav on cav.id = pa.attribute_value_id
        join category_attribute as cvv on cvv.id = cav.attribute_id
        where pa.product_id in ($productString)
        group by cav.id";
            $attr_result = $this->Product_model->query_exe($attr_query);

            foreach ($attr_result as $key => $value) {
                $filter = $value['attribute_id'];
                $attitle = $value['attribute'];
                $widget = $value['widget'];
                if (isset($attr_filter[$filter])) {
                    array_push($attr_filter[$filter], $value);
                } else {
                    $attr_filter[$filter] = array("title" => $attitle, "attrs" => [], "widget" => $widget);
                    array_push($attr_filter[$filter], $value);
                }
            }
        }
        $productListFinal = array_slice($productListFinal, $startpage, 12);
        $this->output->set_header('Content-type: application/json');
        $productArray = array('attributes' => $attr_filter,
            'products' => $productListFinal,
            'product_count' => count($productListSt),
            'price' => $pricelist,
            "priceList" => $priceListWidget,
            "brandList" => $brandWidget
        );
        $this->response($productArray);
    }

  

}

?>