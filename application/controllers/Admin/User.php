<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if($this->session->userdata('is_login')==FALSE){
			redirect('auth');
		}
		if($this->session->userdata('role')=='Peminjam'){
			redirect('home');
		}
		if($this->session->userdata('role')=='Petugas'){
			redirect('home');
		}
	}

	public function index()
	{
		$this->db->from('user')->order_by('namaLengkap', 'asc');
		$user = $this->db->get()->result_array();
		$data = array(
			'judul' => 'Data User',
			'user' => $user
		);
		$this->template->load('template', 'Admin/user_index', $data);
	}

	public function edit($userID)
	{
		$this->db->from('user')->where('userID', $userID);
		$user = $this->db->get()->row();
		$data = array(
			'judul' => 'Edit Data User',
			'user' => $user
		);
		$this->template->load('template', 'Admin/user_edit', $data);
	}

	public function simpan()
	{
		// Get the input username
		$username = $this->input->post('username');
		
		// Check if the username already exists
		$this->db->from('user')->where('username', $username);
		$cek = $this->db->get()->row();
		
		// Check if password is at least 8 characters long
		$password = $this->input->post('password');
		if (strlen($password) < 8) {
			$this->session->set_flashdata('pesan', '
			<div class="alert alert-danger alert-dismissible" role="alert">
					Password harus minimal 8 karakter
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>');
			redirect('Admin/User');
		}
		
		// If the username does not exist, proceed with saving
		if ($cek == NULL) {
			$data = array(
				'username' => $username,
				'password' => md5($password),  // Save the password securely
				'namaLengkap' => $this->input->post('nama'),
				'alamat' => $this->input->post('alamat'),
				'email' => $this->input->post('email'),
				'role' => $this->input->post('role')
			);
			
			// Insert the data into the database
			$this->db->insert('user', $data);
			
			// Set success message
			$this->session->set_flashdata('pesan', '
			<div class="alert alert-primary alert-dismissible" role="alert">
					Berhasil Menyimpan Data
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>');
			redirect('Admin/User');
		} else {
			// Set failure message if username exists
			$this->session->set_flashdata('pesan', '
			<div class="alert alert-primary alert-dismissible" role="alert">
					Gagal Menyimpan Data
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>');
			redirect('Admin/User');
		}
	}	

	public function update(){
			$data = array(
				'namaLengkap' => $this->input->post('nama'),
				'alamat' => $this->input->post('alamat'),
				'email' => $this->input->post('email'),
				'role' => $this->input->post('role')
			);
			$where = array(
				'userID' => $this->input->post('userID'),
			);
			$this->db->update('user', $data, $where);
			$this->session->set_flashdata('pesan', '
			<div class="alert alert-primary alert-dismissible" role="alert">
					Berhasil Menyimpan Data
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>');
			redirect('Admin/User');
	}

	public function hapus($userID){
		$where = array(
			'userID' => $userID
		);
		$this->db->delete('user',$where);
		$this->session->set_flashdata('pesan', '
			<div class="alert alert-primary alert-dismissible" role="alert">
					Berhasil Dihapus.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>');
			redirect('Admin/User');
	}
}
