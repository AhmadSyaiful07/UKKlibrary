<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		if($this->session->userdata('is_login')==FALSE){
			redirect('auth');
		}
	}

	public function index()
	{
		$data = array(
			'judul' => 'dashboard',
		);
		$this->template->load('template','dashboard', $data);
	}
}
