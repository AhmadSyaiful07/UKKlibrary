<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Koleksi extends CI_Controller
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
        $this->db->from('koleksi a')
                 ->join('buku b', 'a.bukuID = b.bukuID', 'left')
                 ->join('kategori c', 'b.kategoriID = c.kategoriID', 'left')
                 ->where('a.userID', $this->session->userdata('userID'));
    
        $buku = $this->db->get()->result_array();
            
        $data = array(
            'judul'     => 'Koleksi Buku',
            'buku'      => $buku,
        );
        $this->template->load('template', 'Peminjam/koleksi', $data);
        
    }

    public function hapus($bukuID)
    {
        $where = array(
            'bukuID' => $bukuID, 
            'userID' => $this->session->userdata('userID')
        );
        $this->db->delete('koleksi', $where);
        $this->session->set_flashdata('pesan', '
			<div class="alert alert-primary alert-dismissible" role="alert">
                Koleksi berhasil dihapus
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>');
        redirect('Peminjam/koleksi');
    }
   
}