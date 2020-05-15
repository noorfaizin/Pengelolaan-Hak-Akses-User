<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_Dashboard extends CI_Controller{
	
	function __construct(){
		parent::__construct();		
		$this->load->model('M_Akun_User');
		$this->load->helper('url');
		$this->cek_login->user(); 
	}
 
	function index(){
		$data['judul'] = "K⍜PIKU | My Account";
		$data['users']= $this->db->get_where('users', ['username' =>
		$this->session->userdata('username')])->row_array();
		$this->load->model('cart/M_Cart');
		$data['cart']= $this->M_Cart->get_data();
		$data['sum_jumlah']= $this->M_Cart->jumlah_cart();

		$this->load->view('beranda/template/user_header', $data);
		$this->load->view('user_dashboard/template/header', $data);
		$this->load->view('userdashboardv',$data);
		$this->load->view('user_dashboard/template/footer', $data);
		$this->load->view('beranda/template/user_footer', $data);
	}

	function akun(){
		$data['judul'] = "K⍜PIKU | My Account";
		$data['users']= $this->db->get_where('users', ['username' =>
		$this->session->userdata('username')])->row_array();
		$this->load->model('cart/M_Cart');
		$data['cart']= $this->M_Cart->get_data();
		$data['sum_jumlah']= $this->M_Cart->jumlah_cart();
		$this->load->view('beranda/template/user_header', $data);
		$this->load->view('user_dashboard/template/header', $data);
		$this->load->view('account/akun',$data);
		$this->load->view('user_dashboard/template/footer', $data);
		$this->load->view('beranda/template/user_footer', $data);
	}

	function edit(){
		$data['judul'] = "Edit | My Account";
		$data['users']= $this->db->get_where('users', ['username' =>
		$this->session->userdata('username')])->row_array();

		$this->form_validation->set_rules('nama', 'Full Name', 'required|trim');
		$this->form_validation->set_rules('alamat', 'Address', 'required|trim');
		$this->form_validation->set_rules('email', 'Email', 'required|trim');
		$this->form_validation->set_rules('nohp', 'Phone Number', 'required|trim');
		if($this->form_validation->run() == false){
			$this->load->model('cart/M_Cart');
			$data['cart']= $this->M_Cart->get_data();
			$data['sum_jumlah']= $this->M_Cart->jumlah_cart();
			$this->load->view('beranda/template/user_header', $data);
			$this->load->view('user_dashboard/template/header', $data);
			$this->load->view('account/update_akun',$data);
			$this->load->view('user_dashboard/template/footer', $data);
			$this->load->view('beranda/template/user_footer', $data);
		}else{
			$nama = $this->input->post('nama');
			$alamat = $this->input->post('alamat');
			$email = $this->input->post('email');
			$nohp = $this->input->post('nohp');
			$username = $this->input->post('username');
			$this->db->set('nama',$nama);
			$this->db->set('alamat',$alamat);
			$this->db->set('email',$email);
			$this->db->set('nohp',$nohp);
			$this->db->where('username',$username);
			$this->db->update('users');
			//flashdata
			$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert">&times;</button>Data akun berhasil diubah</div>');
			redirect('user_dashboard/akun');
		}
	}

	function nonaktif(){
		$data['users']= $this->db->get_where('users', ['username' =>
		$this->session->userdata('username')])->row_array();
		$this->db->where('username',$username);
		$this->db->delete('users');
		redirect('user_dashboard/login');
	}
}
