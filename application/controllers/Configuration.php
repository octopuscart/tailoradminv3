<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 */
defined('BASEPATH') or exit('No direct script access allowed');
ob_start();

class Configuration extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Product_model');
        $this->load->model('User_model');
        $this->load->library('session');
        $this->user_id = $this->session->userdata('logged_in')['login_id'];
        $this->user_type = $this->session->logged_in['user_type'];
    }

    public function index()
    {
    }

    //Add product function
    function add_sliders($slider_id = 0)
    {
        $query = $this->db->get('sliders');
        $data['sliders'] = $query->result();

        $this->db->where('id', $slider_id);
        $query = $this->db->get('sliders');
        $sliderobj = $query->row();

        $operation = "add";

        $sliderdata = array(
            'id' => '',
            'title' => '',
            'title_color' => '',
            'line1' => '',
            'line1_color' => '',
            'line2' => '',
            'line2_color' => '',
            'file_name' => '',
            'link' => '',
            'link_text' => '',
            'position' => '',
        );

        $data['sliderdata'] = $sliderobj;
        if ($slider_id) {
            $operation = "edit";
            $data['sliderdata'] = $sliderobj;

            $sliderdata = array(
                'id' => $sliderobj->id,
                'title' => $sliderobj->title,
                'title_color' => $sliderobj->title_color,
                'line1' => $sliderobj->line1,
                'line1_color' => $sliderobj->line1_color,
                'line2' => $sliderobj->line2,
                'line2_color' => $sliderobj->line2_color,
                'file_name' => $sliderobj->file_name,
                'link' => $sliderobj->link,
                'link_text' => $sliderobj->link_text,
                'position' => $sliderobj->position,
            );

            $data['sliderdata'] = $sliderdata;

            if (isset($_POST['submit'])) {
                if (!empty($_FILES['picture']['name'])) {
                    $config['upload_path'] = 'assets_main/sliderimages';
                    $config['allowed_types'] = '*';
                    $temp1 = rand(100, 1000000);
                    $ext1 = explode('.', $_FILES['picture']['name']);
                    $ext = strtolower(end($ext1));
                    $file_newname = $temp1 . "1." . $ext;
                    $config['file_name'] = $file_newname;
                    //Load upload library and initialize configuration
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('picture')) {
                        $uploadData = $this->upload->data();
                        $picture = $uploadData['file_name'];
                    } else {
                        $picture = '';
                    }
                    $this->db->set('file_name', $file_newname);
                } else {
                    $picture = '';
                }
                $user_id = $this->session->userdata('logged_in')['login_id'];

                $this->db->set('title', $this->input->post('title'));

                $this->db->set('line1', $this->input->post('line1'));
                $this->db->set('title_color', $this->input->post('title_color'));
                $this->db->set('line1_color', $this->input->post('line1_color'));
                $this->db->set('line2_color', $this->input->post('line2_color'));
                $this->db->set('line2', $this->input->post('line2'));
                $this->db->set('link', $this->input->post('link'));
                $this->db->set('link_text', $this->input->post('link_text'));
                $this->db->set('position', $this->input->post('position'));

                $this->db->where('id', $this->input->post('slider_id')); //set column_name and value in which row need to update
                $this->db->update('sliders');

                redirect('Configuration/add_sliders');
            }
        } else {
            if (isset($_POST['submit'])) {
                if (!empty($_FILES['picture']['name'])) {
                    $config['upload_path'] = 'assets_main/sliderimages';
                    $config['allowed_types'] = '*';
                    $temp1 = rand(100, 1000000);
                    $ext1 = explode('.', $_FILES['picture']['name']);
                    $ext = strtolower(end($ext1));
                    $file_newname = $temp1 . "1." . $ext;
                    $config['file_name'] = $file_newname;
                    //Load upload library and initialize configuration
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('picture')) {
                        $uploadData = $this->upload->data();
                        $picture = $uploadData['file_name'];
                    } else {
                        $picture = '';
                    }
                } else {
                    $picture = '';
                }
                $user_id = $this->session->userdata('logged_in')['login_id'];
                $post_data = array(
                    'title' => $this->input->post('title'),
                    'title_color' => $this->input->post('title_color'),
                    'line1_color' => $this->input->post('line1_color'),
                    'line2_color' => $this->input->post('line2_color'),
                    'line1' => $this->input->post('line1'),
                    'line2' => $this->input->post('line2'),
                    'link' => $this->input->post('link'),
                    'link_text' => $this->input->post('link_text'),
                    'file_name' => $file_newname
                );
                $this->db->insert('sliders', $post_data);
                $last_id = $this->db->insert_id();
                redirect('Configuration/add_sliders');
            }
        }
        $data['operation'] = $operation;
        $this->load->view('Configuration/add_sliders', $data);
    }

    public function reportConfiguration()
    {
        $data = array();
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('configuration_report');
        $systemlog = $query->row();
        $data['configuration_report'] = $systemlog;

        if (isset($_POST['update_data'])) {
            $confArray = array(
                "email_header" => $this->input->post("email_header"),
                "email_footer" => $this->input->post("email_footer"),
                "pdf_report_header" => $this->input->post("pdf_report_header"),
            );
            $this->db->update('configuration_report', $confArray);
            redirect("Configuration/reportConfiguration");
        }


        $this->load->view("configuration/reportConfiguration", $data);
    }

    public function checkokutConfiguration()
    {
        $data = array();

        $query = $this->db->get('configuration_cartcheckout');
        $systemlog = $query->row_array();
        $data['configuration_payment'] = $systemlog;
        $this->load->view("configuration/checkout", $data);
    }

    public function migration()
    {
        if ($this->db->table_exists('mailchimp_list')) {
            // table exists
        } else {
            $this->db->query('CREATE TABLE IF NOT EXISTS `mailchimp_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `m_id` varchar(100) DEFAULT NULL,
  `name` varchar(250) DEFAULT NULL,
  `datetime` varchar(100) DEFAULT NULL,
  `member_count` varchar(50) NOT NULL,
  `display_index` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;');
        }


        if ($this->db->field_exists('hotel', 'appointment_list')) {
            // table exists
        } else {
            $this->db->query('ALTER TABLE `appointment_list` ADD `hotel` VARCHAR(200) NOT NULL AFTER `contact_no`, ADD `address` VARCHAR(300) NOT NULL AFTER `hotel`, ADD `city_state` VARCHAR(200) NOT NULL AFTER `address`, ADD `country` VARCHAR(200) NOT NULL AFTER `city_state`;');
        }
    }
}
