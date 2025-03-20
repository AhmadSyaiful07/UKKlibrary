<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
	public function index()
	{
		$data = array(
			'judul' => 'Login',
		);
		$this->load->view('login', $data);
	}

	public function profile()
	{
		$this->db->from('user')->where('userID', $this->session->userdata('userID'));
		$user = $this->db->get()->row();
		$data = array(
			'judul' => 'My Profile',
			'user' => $user
		);
		$this->template->load('template', 'profile', $data);
	}
	public function password()
	{
		$data = array(
			'judul' => 'Ganti Password',
		);
		$this->template->load('template', 'password', $data);
	}

	public function update()
	{
			$data = array(
				'namaLengkap' => $this->input->post('nama'),
				'alamat' => $this->input->post('alamat'),
				'email' => $this->input->post('email')
			);
			$where = array(
				'userID' => $this->input->post('userID'),
			);
			$this->db->update('user', $data, $where);
			$this->session->set_userdata($data);
			$this->session->set_flashdata('pesan', '
			<div class="alert alert-primary alert-dismissible" role="alert">
					Berhasil Menyimpan Data
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>');
			redirect('auth/profile');
	}

	public function updatepassword() {
		$username = $this->session->userdata('username');
		$passwordBaru = $this->input->post('passwordBaru');
		$passwordKonf = $this->input->post('passwordKonf');
	
		// Cek apakah password baru dan konfirmasi password sama
		if ($passwordBaru !== $passwordKonf) {
			$this->session->set_flashdata('pesan', '
			<div class="alert alert-danger alert-dismissible" role="alert">
				Password Baru Tidak Sama
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>');
			redirect('auth/password');
			return;
		}
	
		// Enkripsi password baru menggunakan password_hash()
		$hashedPassword = md5($passwordBaru);
	
		// Update password di database
		$data = array(
			'password' => $hashedPassword,
		);
		$where = array(
			'username' => $username,
		);
		$this->db->update('user', $data, $where);
	
		$this->session->set_flashdata('pesan', '
		<div class="alert alert-primary alert-dismissible" role="alert">
			Password Berhasil Diubah
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>');
		redirect('auth/password');
	}	

    public function register()
	{
		$data = array(
			'judul' => 'register',
		);
		$this->load->view('register', $data);
	}

	public function logout(){
		$this->session->sess_destroy();
		redirect('auth');
	}

   public function login()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $this->db->from('user')->where('username', $username);
        $data = $this->db->get()->row();
        if ($data == NULL) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger">Username Tidak Ditemukan</div>');
            redirect('auth');
        } else {
            // Jika password di database masih dalam format MD5, lakukan migrasi
            
                if (md5($password) == $data->password) {
                    // Login pengguna
                    $this->session->set_userdata([
                        'is_login' => TRUE,
                        'username' => $data->username,
                        'userID' => $data->userID,
                        'namaLengkap' => $data->namaLengkap,
                        'alamat' => $data->alamat,
                        'email' => $data->email,
                        'role' => $data->role,
                    ]);
                    redirect('home');
                } else {
                    $this->session->set_flashdata('pesan', '<div class="alert alert-danger">Password Salah!</div>');
                    redirect('auth');
                }
            
        }
    }

   public function simpan()
{
    // Retrieve form inputs
    $username = $this->input->post('username');
    $password = $this->input->post('password');
    $password_confirm = $this->input->post('password_confirm');

    // Check if the password and confirm password match
    if ($password !== $password_confirm) {
        $this->session->set_flashdata('pesan', '
        <div class="alert alert-danger alert-dismissible" role="alert">
                Password dan Konfirmasi Password tidak cocok.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>');
        redirect('auth/register'); // Redirect if passwords don't match
        return;
    }

    // Validate password length (min 8 characters)
    if (strlen($password) < 8) {
        $this->session->set_flashdata('pesan', '
        <div class="alert alert-danger alert-dismissible" role="alert">
                Password harus minimal 8 karakter.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>');
        redirect('auth/register'); // Redirect if password is too short
        return;
    }

    // Check if the username already exists
    $this->db->from('user')->where('username', $username);
    $cek = $this->db->get()->row();

    // If username doesn't exist, proceed with registration
    if ($cek == NULL) {
        // Hash the password using password_hash()
		$hashed_password = md5($password);	

        $data = array(
            'username' => $username,
            'password' => $hashed_password,  // Store the hashed password
            'namaLengkap' => $this->input->post('namaLengkap'),
            'alamat' => $this->input->post('alamat'),
            'email' => $this->input->post('email'),
            'role' => 'peminjam',  // Default role as 'peminjam'
        );

        // Insert user data into database
        $this->db->insert('user', $data);

        // Set success message
        $this->session->set_flashdata('pesan', '
        <div class="alert alert-primary alert-dismissible" role="alert">
                Berhasil Register, Silahkan Login
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>');
        redirect('auth'); // Redirect to the login page
    } else {
        // Set error message if username is already taken
        $this->session->set_flashdata('pesan', '
        <div class="alert alert-danger alert-dismissible" role="alert">
                Username sudah digunakan.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>');
        redirect('auth/register'); // Redirect back to registration page
    }
}

}
