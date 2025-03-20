<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Buku extends CI_Controller
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
        // Join tabel buku dan kategori berdasarkan kategoriID
        $this->db->select('buku.*, kategori.namaKategori');
        $this->db->from('buku');
        $this->db->join('kategori', 'buku.kategoriID = kategori.kategoriID', 'left'); // Gunakan LEFT JOIN jika ada buku yang tidak punya kategori
        $this->db->order_by('buku.judul', 'asc');
        $buku = $this->db->get()->result_array();

        // Ambil data kategori untuk select option
        $this->db->from('kategori')->order_by('namaKategori', 'asc');
        $kategori = $this->db->get()->result_array();

        $data = array(
            'judul'     => 'Data buku',
            'buku'      => $buku,
            'kategori'  => $kategori,
        );
        $this->template->load('template', 'Peminjam/buku', $data);
    }

    public function ulasan($bukuID)
    {
        $this->db->from('buku')->where('bukuID', $bukuID);
        $buku = $this->db->get()->row();
        $this->db->from('ulasanbuku a');
        $this->db->join('user b', 'a.userID = b.userID', 'left');
        $this->db->where('a.bukuID', $bukuID);
        $ulasan = $this->db->get()->result_array();

        $data = array(
            'judul' => 'Ulasan Buku',
            'buku' => $buku,
            'ulasan' => $ulasan
        );
        $this->template->load('template', 'Peminjam/ulasan', $data);
    }

    // Fungsi baru untuk menyimpan ulasan
    public function simpan_ulasan()
    {
        $bukuID = $this->input->post('bukuID');
        $user = $this->session->userdata('userID');
        $ulasan = $this->input->post('ulasan');
        $rating = $this->input->post('rating');

        if (empty($bukuID) || empty($ulasan) || empty($rating)) {
            show_error('Semua data ulasan harus diisi', 400);
        }

        $data = array(
            'userID' => $user,
            'bukuID' => $bukuID,
            'ulasan' => $ulasan,
            'rating' => $rating,
        );

        $this->db->insert('ulasanbuku', $data);
        $this->session->set_flashdata('pesan', '
        <div class="alert alert-primary alert-dismissible" role="alert">
            Ulasan berhasil dikirim.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>');
        redirect('Peminjam/buku/ulasan/' . $bukuID);
    }



    public function ajukan($bukuID)
    {

        $this->db->select('buku.*, kategori.namaKategori');
        $this->db->from('buku');
        $this->db->join('kategori', 'buku.kategoriID = kategori.kategoriID', 'left');
        $this->db->where('buku.bukuID', $bukuID);
        $buku = $this->db->get()->row();

        $this->db->from('kategori')->order_by('namaKategori', 'asc');
        $kategori = $this->db->get()->result_array();

        $data = array(
            'judul'     => 'Ajukan Buku',
            'buku'      => $buku,
            'kategori'  => $kategori
        );

        $this->template->load('template', 'Peminjam/ajukan', $data);
    }

    public function pinjam()
    {
        $this->db->from('peminjaman')
            ->where('bukuID', $this->input->post('bukuID'))
            ->where('statusPeminjaman', 'Proses');
        $cek = $this->db->get()->row();
        if ($cek == NULL) {
            $data = array(
                'bukuID' => $this->input->post('bukuID'),
                'userID' => $this->session->userdata('userID'),
                'tanggalPeminjaman' => $this->input->post('tanggalPeminjaman'),
                'statusPeminjaman' => 'Proses'

            );

            $this->db->insert('peminjaman', $data);
            $this->session->set_flashdata('pesan', '
			<div class="alert alert-primary alert-dismissible" role="alert">
					Berhasil Megajukan Peminjaman, silahkan tunggu konfirmasi dari Admin.
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>');
            redirect('Peminjam/buku');
        } else {
            $this->session->set_flashdata('pesan', '
            <div class="alert alert-danger alert-dismissible" role="alert">
                    Gagal Megajukan Peminjaman, anda sudah mengajukan peminjaman buku ini atau buku ini sedang dipinjam oleh orang lain.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>');
            redirect('Peminjam/buku');
        }
    }

    public function addKoleksi($bukuID)
    {
        $this->db->from('koleksi')
            ->where('bukuID', $bukuID)
            ->where('userID', $this->session->userdata('userID'));
        $cek = $this->db->get()->row();
        if ($cek == NULL) {
            $data = array(
                'bukuID' => $bukuID,
                'userID' => $this->session->userdata('userID')
            );

            $this->db->insert('koleksi', $data);
            $this->session->set_flashdata('pesan', '
			<div class="alert alert-primary alert-dismissible" role="alert">
					Berhasil Menambahkan Koleksi Buku.
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>');
            redirect('Peminjam/buku');
        } else {
            $this->session->set_flashdata('pesan', '
        <div class="alert alert-danger alert-dismissible" role="alert">
					Gagal Menambahkan Koleksi Buku, Buku ini sudah ada di koleksi anda.
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>');
            redirect('Peminjam/buku');
        }
    }

    public function ulasanHapus($bukuID){
		$where = array(
			'bukuID' => $bukuID,
            'userID' => $this->session->userdata('userID'),
		);
		$this->db->delete('ulasanbuku',$where);
		$this->session->set_flashdata('pesan', '
			<div class="alert alert-primary alert-dismissible" role="alert">
					Berhasil Dihapus.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>');
			redirect('Peminjam/buku/ulasan/' . $bukuID);
	}
}
