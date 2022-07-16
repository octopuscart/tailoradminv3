<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Order_model extends CI_Model {

    function __construct() {
// Call the Model constructor
        parent::__construct();
        $this->load->database();
    }

//get order details  
    public function getOrderDetails($key_id, $is_key = 0) {
        $order_data = array();
        if ($is_key === 'key') {
            $this->db->where('order_key', $key_id);
        } else {
            $this->db->where('id', $key_id);
        }
        $query = $this->db->get('user_order');
        $order_details = $query ? $query->row() : array();
        if ($order_details) {

            $order_data['order_data'] = $order_details;
            $this->db->where('order_id', $order_details->id);
            $query = $this->db->get('cart');
            $cart_items = $query->result();

            $this->db->order_by('display_index', 'asc');
            $this->db->where('order_id', $order_details->id);
            $query = $this->db->get('custom_measurement');
            $custom_measurement = $query->result_array();

            $order_data['measurements_items'] = $custom_measurement;

            foreach ($cart_items as $key => $value) {
                $cart_id = $value->id;

                $this->db->where('cart_id', $cart_id);
                $query = $this->db->get('cart_customization');
                $cartcustom = $query->result_array();

                $customdata = array();
                foreach ($cartcustom as $key1 => $value1) {
                    $customdata[$value1['style_key']] = $value1['style_value'];
                }
                $value->custom_dict = $customdata;
                $value->product_status = array();
            }
            $order_data['cart_data'] = $cart_items;
        }
        return $order_data;
    }

    public function getOrderDetailsV2($key_id, $is_key = 0) {
        $order_data = array();
        if ($is_key === 'key') {
            $this->db->where('order_key', $key_id);
        } else {
            $this->db->where('id', $key_id);
        }
        $query = $this->db->get('user_order');
        $order_details = $query->row();
        $payment_details = array("payment_mode" => "", "txn_id" => "", "payment_date" => "");

        if ($order_details) {

            $this->db->order_by('id', 'desc');
            $this->db->where('order_id', $order_details->id);
            $query = $this->db->get('user_order_status');
            $userorderstatus = $query->result();
            $order_data['order_status'] = $userorderstatus;

            if ($order_details) {
                $this->db->where('order_id', $order_details->id);
                $query = $this->db->get('paypal_status');
                $paypal_details = $query->result();

                if ($paypal_details) {
                    $paypal_details = end($paypal_details);
                    $payment_details['payment_mode'] = "PayPal";
                    $payment_details['txn_id'] = $paypal_details->txn_no;
                    $payment_details['payment_date'] = $paypal_details->timestemp;
                }
            }

            $order_id = $order_details->id;
            $order_data['order_data'] = $order_details;
            $this->db->where('order_id', $order_details->id);
            $query = $this->db->get('cart');
            $cart_items = $query->result();

//            $this->db->order_by('display_index', 'asc');
            $this->db->where('custom_measurement_profile', $order_details->measurement_id);
            $query = $this->db->get('custom_measurement');
            $custom_measurement = $query->result_array();

            $order_data['measurements_items'] = $custom_measurement;

            foreach ($cart_items as $key => $value) {
                $cart_id = $value->id;

                $this->db->where('cart_id', $cart_id);
                $query = $this->db->get('cart_customization');
                $cartcustom = $query->result_array();

                $customdata = array();
                foreach ($cartcustom as $key1 => $value1) {
                    $customdata[$value1['style_key']] = $value1['style_value'];
                }
                $value->custom_dict = $customdata;

//                $this->db->where('order_id', $order_id);
//                $this->db->where('vendor_id', $vendor_id);
//                $query = $this->db->get('vendor_order_status');
//                $orderstatus = $query->result();
                $value->product_status = array();
            }

            $order_data['cart_data'] = $cart_items;
//            $order_data['amount_in_word'] = $this->convert_num_word($order_data['order_data']->total_price);
        }
        $order_data['payment_details'] = $payment_details;
        return $order_data;
    }

    public function getVendorsOrder($key_id) {
        $order_data = array();
        $this->db->where('order_key', $key_id);
        $query = $this->db->get('user_order');
        $order_details = $query->row();
        $venderarray = array();
        if ($order_details) {
            $order_id = $order_details->id;
            $order_data['order_data'] = $order_details;
            $this->db->where('order_id', $order_id);
            $query = $this->db->get('vendor_order');
            $vendor_orders = $query->result();
            $order_data['vendor'] = array();
            foreach ($vendor_orders as $key => $value) {
                $vid = $value->vendor_id;
                $order_data['vendor'][$vid] = array();
                $order_data['vendor'][$vid]['vendor'] = $value;

                $this->db->order_by('id', 'desc');
                $this->db->where('vendor_order_id', $value->id);
                $query = $this->db->get('vendor_order_status');
                $status = $query->row();

                $order_data['vendor'][$vid]['status'] = $status ? $status->status : $value->status;
                $order_data['vendor'][$vid]['remark'] = $status ? $status->remark : $value->status;

                $this->db->where('order_id', $order_id);
                $this->db->where('vendor_id', $vid);
                $query = $this->db->get('cart');
                $order_data['vendor'][$vid]['cart_items'] = $query->result();
            }
        }

        return $order_data;
    }

    function order_mail($order_id, $subject = "") {
        setlocale(LC_MONETARY, 'en_US');
        $order_details = $this->getOrderDetailsV2($order_id, 'key');
        $emailsender = EMAIL_SENDER;
        $sendername = EMAIL_SENDER_NAME;
        $email_bcc = EMAIL_BCC;

        if ($order_details) {
            $currentstatus = $order_details['order_status'][0];
            $order_no = $order_details['order_data']->order_no;

            $checkcode = REPORT_MODE;
            if ($checkcode == 0) {
                echo $this->load->view('Email/order_mail', $order_details, true);
            } else {
                $this->email->from(EMAIL_BCC, $sendername);
                $this->email->to($order_details['order_data']->email);
                $this->email->bcc(EMAIL_BCC);
                $subject = SITE_NAME . " - " . $currentstatus->remark;
                $this->email->subject($subject);
                $this->email->message($this->load->view('Email/order_mail', $order_details, true));
                $this->email->print_debugger();
                $result = $this->email->send();
            }
        }
    }

    function order_pdf($order_id, $subject = "") {
        setlocale(LC_MONETARY, 'en_US');
        $order_details = $this->getOrderDetailsV2($order_id, 0);
        if ($order_details) {
            $order_no = $order_details['order_data']->order_no;
            $html = $this->load->view('Email/order_pdf', $order_details, true);
            $html_header = $this->load->view('Email/order_mail_header', $order_details, true);
            $html_footer = $this->load->view('Email/order_mail_footer', $order_details, true);
            $pdfFilePath = str_replace("/", "", $order_no) . ".pdf";
            $checkcode = REPORT_MODE;
            if ($checkcode == 0) {
                echo $html;
            } else {

                $this->load->library('pdf');
                $this->dompdf->set_option('isRemoteEnabled', true);
                // Load HTML content
                $this->dompdf->loadHtml($html);
                // (Optional) Setup the paper size and orientation
                $this->dompdf->setPaper('A4');
                // Render the HTML as PDF
                $this->dompdf->render();
                // Output the generated PDF (1 = download and 0 = preview)
                $this->dompdf->stream($pdfFilePath, array("Attachment" => 1));
            }
        }
    }

    function order_pdf_worker($order_id, $subject = "") {
        setlocale(LC_MONETARY, 'en_US');
        $order_details = $this->getOrderDetailsV2($order_id, 0);
        if ($order_details) {
            $order_no = $order_details['order_data']->order_no;
            $html = $this->load->view('Email/order_pdf_worker', $order_details, true);
            $html_header = $this->load->view('Email/order_mail_header', $order_details, true);
            $html_footer = $this->load->view('Email/order_mail_footer', $order_details, true);
            $pdfFilePath = $order_no . "_worker_report.pdf";
            $checkcode = REPORT_MODE;
            if ($checkcode == 0) {
                echo $html;
            } else {
                $this->load->library('pdf');
                $this->dompdf->set_option('isRemoteEnabled', true);
                // Load HTML content
                $this->dompdf->loadHtml($html);
                // (Optional) Setup the paper size and orientation
                $this->dompdf->setPaper('A4');
                // Render the HTML as PDF
                $this->dompdf->render();
                // Output the generated PDF (1 = download and 0 = preview)
                $this->dompdf->stream("welcome.pdf", array("Attachment" => 0));
            }
        }
    }

    //previouse customization
    public function selectPreviouseProfiles($user_id, $item_id) {
        $itemquery = "";
        if ($item_id) {
            $itemquery = " and  item_id = $item_id";
        }
        $row_query = "SELECT id, item_name, item_id,  op_date_time, order_id FROM `cart` where user_id = $user_id $itemquery   and attrs ='Custom' and status!='delete' and id in (select cart_id from cart_customization);";
        $query = $this->db->query($row_query);
        $data = [];
        $preitemdata = array("has_pre_design" => false, "designs" => array());
        if ($query) {
            $customdatadata = $query->result_array();
            foreach ($customdatadata as $key => $value) {
                $order_no = $this->db->where("id", $value["order_id"])->get("user_order")->row_array();
                $profilename = $value["item_name"] . " " . $value["id"];
                $customdata = $this->db->select("style_key, style_value")->where("cart_id", $value["id"])->get("cart_customization")->result_array();

                $customdatadict = array();
                foreach ($customdata as $ckey => $cvalue) {
                    $customdatadictp[$cvalue["style_key"]] = $cvalue["style_value"];
                }
                $preitemdata["designs"][$value["id"]] = array(
                    "name" => $profilename,
                    "order_no" => $order_no ? $order_no["order_no"] : "RF" . str_replace("-", "/", $value["id"]),
                    "cart_data" => $value,
                    "style" => $customdata
                );
                $preitemdata["has_pre_design"] = true;
            }
        }
        return $preitemdata;
    }



    public function selectPreviouseMeasurementProfilesReport($profile_id) {

        $row_query = "SELECT id, profile, order_id, user_id,  status, datetime FROM `custom_measurement_profile` where id = $profile_id order by status desc;";
        $query = $this->db->query($row_query);

        $preitemdata = array("has_pre_measurement" => false, "measurement" => array());
        if ($query) {
            $customdatadata = $query->row_array();

            $order_no = $this->db->where("measurement_id", $customdatadata["id"])->order_by("id desc")->get("user_order")->row_array();

            $customdata = $this->db->select("measurement_key, measurement_value")->where("custom_measurement_profile", $customdatadata["id"])->get("custom_measurement")->result_array();

            $userdataquery = $this->db->select("first_name, last_name, email")->where("id", $customdatadata["user_id"])->get("admin_users");

            $customdatadict = array();
            foreach ($customdata as $ckey => $cvalue) {
                $customdatadictp[$cvalue["measurement_key"]] = $cvalue["measurement_value"];
            }
            $preitemdata = array(
                "name" => $customdatadata["profile"],
                "order_no" => $order_no ? $order_no["order_no"] : "No Order",
                "meausrement_data" => $customdatadata,
                "measurements" => $customdata,
                "user_data" => $userdataquery ? $userdataquery->row_array() : array()
            );

            $preitemdata["has_pre_measurement"] = true;
        }
        return $preitemdata;
    }

    function resetPasswordMail($user_details) {
        $emailsender = EMAIL_SENDER;
        $sendername = EMAIL_SENDER_NAME;
        $email_bcc = EMAIL_BCC;
        if ($user_details) {
            $checkcode = REPORT_MODE;
//            $checkcode = 0;
            $html = $this->load->view('Email/password_reset', array("user_data" => $user_details), true);
            if ($checkcode == 0) {
                echo $html;
            } else {
                $this->email->from(EMAIL_BCC, $sendername);
                $this->email->to($user_details["email"]);
                $this->email->bcc(EMAIL_BCC);
                $subject = SITE_NAME . " - " . " password reset request.";
                $this->email->subject($subject);
                $this->email->message($html);
                $this->email->print_debugger();
                $result = $this->email->send();
            }
        }
    }

    function getUserSubscriptionByUserId($user_id) {
        $querydata = $this->db->where("user_id", $user_id)->get("newsletter_subscription")->row_array();
        return $querydata;
    }

}

?>
