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
        if ($this->session->userdata('role') == 'Admin') {
            redirect('home');
        }
        if ($this->session->userdata('role') == 'Petugas') {
            redirect('home');
        }
    }

    public function index()
    {
        $this->db->from('peminjaman a')->order_by('a.tanggalPeminjaman', 'desc');
        $this->db->join('buku b', 'a.bukuID = b.bukuID', 'left');
        $this->db->where('userID', $this->session->userdata('userID'));
        $peminjaman = $this->db->get()->result_array();

        $data = array(
            'judul'     => 'Riwayat Peminjaman',
            'peminjaman' => $peminjaman
        );
        $this->template->load('template', 'Peminjam/riwayat', $data);
    }

    public function batal($peminjamanID)
	{
			$data = array(
				'statusPeminjaman' => 'DiBatalkan'
			);
			$where = array(
				'peminjamanID' => $peminjamanID,
			);
			$this->db->update('peminjaman', $data, $where);
			$this->session->set_flashdata('pesan', '
			<div class="alert alert-primary alert-dismissible" role="alert">
					Berhasil Membatalakan Peminjaman
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>');
			redirect('Peminjam/peminjaman');
	}

}