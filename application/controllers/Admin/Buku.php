<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Buku extends CI_Controller
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
        $this->template->load('template', 'Admin/buku_index', $data);
    }
    

	public function edit($bukuID)
	{


		$this->db->from('buku')->where('bukuID', $bukuID);
		$buku = $this->db->get()->row();
        $this->db->from('kategori')->order_by('namaKategori', 'asc');
        $kategori = $this->db->get()->result_array();
		$data = array(
			'judul'     => 'Edit Data Buku',
			'buku'      => $buku,
            'kategori'  => $kategori
		);
		$this->template->load('template', 'Admin/buku_edit', $data);
	}

	public function simpan()
    {
        // Load library upload
        $this->load->library('upload');

        // Konfigurasi upload
        $config['upload_path'] = './uploads/'; // Folder penyimpanan file
        $config['allowed_types'] = 'jpg|jpeg|png|gif'; // Jenis file yang diperbolehkan
        $config['max_size'] = 2048; // Maksimum ukuran file dalam KB
        $config['file_name'] = time() . $_FILES['foto']['name']; // Nama file unik berdasarkan timestamp

        // Inisialisasi konfigurasi upload
        $this->upload->initialize($config);

        // Cek apakah file berhasil diupload
        if ($this->upload->do_upload('foto')) {
            // Ambil data file yang diupload
            $file_data = $this->upload->data();
            $foto = $file_data['file_name']; // Ambil nama file yang diupload

            // Cek apakah buku dengan judul yang sama sudah ada
            $this->db->from('buku')->where('judul', $this->input->post('judul'));
            $cek = $this->db->get()->row();

            if ($cek == NULL) {
                // Jika belum ada, simpan data buku ke dalam database
                $data = array(
                    'judul'         => $this->input->post('judul'),
                    'penulis'       => $this->input->post('penulis'),
                    'penerbit'      => $this->input->post('penerbit'),
                    'tahunTerbit'   => $this->input->post('tahunTerbit'),
                    'kategoriID'    => $this->input->post('kategoriID'),
                    'foto'          => $foto, // Simpan nama file foto di database
                    'status'        => 'Tersedia'
                );
                $this->db->insert('buku', $data);

                // Set flash message berhasil
                $this->session->set_flashdata('pesan', '
                <div class="alert alert-primary alert-dismissible" role="alert">
                    Berhasil Menyimpan Data
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>');
                redirect('Admin/buku');
            } else {
                // Jika buku sudah ada, set flash message gagal
                $this->session->set_flashdata('pesan', '
                <div class="alert alert-primary alert-dismissible" role="alert">
                    Gagal Menyimpan Data, Buku dengan judul ini sudah ada
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>');
                redirect('Admin/buku');
            }
        } else {
            // Jika upload foto gagal
            $error = $this->upload->display_errors(); // Ambil pesan error upload
            $this->session->set_flashdata('pesan', '
            <div class="alert alert-danger alert-dismissible" role="alert">
                Gagal Upload Foto: ' . $error . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>');
            redirect('Admin/buku');
        }
    }

    public function update() {
        $data = array(
            'judul'        => $this->input->post('judul'),
            'penulis'      => $this->input->post('penulis'),
            'penerbit'     => $this->input->post('penerbit'),
            'tahunTerbit'  => $this->input->post('tahunTerbit'),
            'kategoriID'   => $this->input->post('kategoriID'),
            'status'       => $this->input->post('status')
        );
        
        $where = array(
            'bukuID' => $this->input->post('bukuID'),
        );
        
        // Update buku data
        $this->db->update('buku', $data, $where);
        
        // Set flash message
        $this->session->set_flashdata('pesan', '
        <div class="alert alert-primary alert-dismissible" role="alert">
            Berhasil Menyimpan Data
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>');
        
        // Redirect back to the buku page
        redirect('Admin/buku');
    }
    

	public function hapus($bukuID){

		$where = array(
			'bukuID' => $bukuID
		);
		$this->db->delete('buku',$where);
		$this->session->set_flashdata('pesan', '
			<div class="alert alert-primary alert-dismissible" role="alert">
					Berhasil Dihapus.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>');
			redirect('Admin/buku');
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
        $this->template->load('template', 'Admin/ulasan', $data);
    }
    
    public function updateFoto()
    {
        // Load library upload
        $bukuID = $this->input->post('bukuID');
    
        // Ambil data buku lama
        $this->db->from('buku');
        $this->db->where('bukuID', $bukuID);
        $buku = $this->db->get()->row_array();
    
        $this->load->library('upload');

        // Konfigurasi upload
        $config['upload_path'] = './uploads/'; // Folder penyimpanan file
        $config['allowed_types'] = 'jpg|jpeg|png|gif'; // Jenis file yang diperbolehkan
        $config['max_size'] = 2048; // Maksimum ukuran file dalam KB
        $config['file_name'] = time() . $_FILES['foto']['name']; // Nama file unik berdasarkan timestamp

        // Inisialisasi konfigurasi upload
        $this->upload->initialize($config);

        // Cek apakah file berhasil diupload
        if ($this->upload->do_upload('foto')) {
            // Ambil data file yang diupload
            if (!empty($buku['foto']) && file_exists('./uploads/' . $buku['foto'])) {
                unlink('./uploads/' . $buku['foto']); // Menghapus foto lama
            }
            $file_data = $this->upload->data();
            $foto = $file_data['file_name']; // Ambil nama file yang diupload

            // Ambil data id foto
            $idFoto = $this->input->post('bukuID');

            // Update data foto
            $data = array(
                'foto' => $foto
            );
            $where = array(
                'bukuID' => $idFoto
            );
            $this->db->update('buku', $data, $where);

            // Set flash message berhasil
            $this->session->set_flashdata('pesan', '
            <div class="alert alert-primary alert-dismissible" role="alert">
                Berhasil Mengupdate Foto
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>');
            redirect('Admin/buku');
        } else {
            // Jika upload foto gagal
            $error = $this->upload->display_errors(); // Ambil pesan error upload
            $this->session->set_flashdata('pesan', '
            <div class="alert alert-danger alert-dismissible" role="alert">
                Gagal Upload Foto: ' . $error . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>');
            redirect('Admin/buku');
        }
    }
}
