<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller{
	
	function __construct(){
		parent::__construct();		
		$this->load->helper('url');
		$this->cek_login->user(); 
	}
 
	function index(){
		$data['judul'] = "Dashboard | Admin";
		$data['users']= $this->db->get_where('users', ['username' =>
		$this->session->userdata('username')])->row_array();
		$this->load->model('cart_beli/M_Cart_Beli');
		$data['sum_jumlah']= $this->M_Cart_Beli->jumlah_cart();
		$this->load->view('template/admin_header', $data);
		$this->load->view('template/admin_sidebar');
		$this->load->view('dashboardv',$data);
		$this->load->view('template/admin_footer');
	}
}
