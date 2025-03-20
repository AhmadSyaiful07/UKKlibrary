<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Peminjaman extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('is_login') == FALSE) {
            redirect('auth');
        }
        if ($this->session->userdata('role') == 'Peminjam') {
            redirect('home');
        }

    }

    public function index()
    {
        $this->db->from('peminjaman a')->order_by('a.tanggalPeminjaman', 'desc');
        $this->db->join('buku b', 'a.bukuID = b.bukuID', 'left');
        $this->db->join('user c', 'a.userID = c.userID', 'left');
        $this->db->order_by('a.peminjamanID', 'desc');
        $peminjaman = $this->db->get()->result_array();

        $data = array(
            'judul'     => 'Data Peminjaman',
            'peminjaman' => $peminjaman
        );
        $this->template->load('template', 'Admin/peminjaman', $data);
    }

	public function laporan()
    {
		$tanggal1 = $this->input->get('tanggal1');
		$tanggal2 = $this->input->get('tanggal2');
		$status = $this->input->get('status');
        $this->db->from('peminjaman a')->order_by('a.tanggalPeminjaman', 'desc');
        $this->db->join('buku b', 'a.bukuID = b.bukuID', 'left');
        $this->db->join('user c', 'a.userID = c.userID', 'left');
        $this->db->order_by('a.peminjamanID', 'desc');
        $this->db->where('a.tanggalPeminjaman >=', $tanggal1);
        $this->db->where('a.tanggalPeminjaman <=', $tanggal2);
		if($status != '-'){
			$this->db->where('a.statusPeminjaman', $status);
		}
		$peminjaman = $this->db->get()->result_array();
        $data = array(
            'judul'     => 'Data Peminjaman',
            'peminjaman' => $peminjaman
        );
        $this->load->view( 'Admin/laporan', $data);
    }

    public function tolak($peminjamanID)
	{
			$data = array(
				'statusPeminjaman' => 'Ditolak'
			);
			$where = array(
				'peminjamanID' => $peminjamanID,
			);
			$this->db->update('peminjaman', $data, $where);
			$this->session->set_flashdata('pesan', '
			<div class="alert alert-primary alert-dismissible" role="alert">
                Peminjaman berhasil ditolak
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>');
			redirect('Admin/peminjaman');
	}

    public function terima($peminjamanID,$bukuID)
	{
			$data = array(
				'statusPeminjaman' => 'Diterima'
			);
			$where = array(
				'peminjamanID' => $peminjamanID,
			);
			$this->db->update('peminjaman', $data, $where);
			$data = array('status' => 'Dipinjam');
			$where = array('bukuID' => $bukuID);
			$this->db->update('buku', $data, $where);
			$this->session->set_flashdata('pesan', '
			<div class="alert alert-primary alert-dismissible" role="alert">
                Peminjaman berhasil diterima
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>');
			redirect('Admin/peminjaman');
	}

    public function kembali($peminjamanID,$bukuID)
	{
			$data = array(
				'statusPeminjaman' => 'DiKembalikan',
                'tanggalPengembalian' => date('Y-m-d')
			);
			$where = array(
				'peminjamanID' => $peminjamanID,
			);
			$this->db->update('peminjaman', $data, $where);
			$data = array('status' => 'Tersedia');
			$where = array('bukuID' => $bukuID);
			$this->db->update('buku', $data, $where);
			$this->session->set_flashdata('pesan', '
			<div class="alert alert-primary alert-dismissible" role="alert">
                Peminjaman berhasil dikembalikan
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>');
			redirect('Admin/peminjaman');
	}

}