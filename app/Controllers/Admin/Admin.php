<?php

namespace App\Controllers\Admin;

use App\Models\AdminModel;
use CodeIgniter\Controller;

class Admin extends Controller
{
    public function __construct()
    {
        $this->m_admin = new AdminModel();
        $this->validation = \Config\Services::validation();
        helper("cookie");
        helper("form"); // Load form helper
        helper("global_fungsi_helper");
    }

    public function login()
    {
        if (get_cookie('cookie_username') && get_cookie('cookie_password')) {
            $username = get_cookie('cookie_username');
            $password = get_cookie('cookie_password');
    
            $dataAkun = $this->m_admin->getData($username);
            if ($password != $dataAkun['password']) {
                $err[] = "Akun yang kamu masukkan tidak sesuai";
                return redirect()->to('admin/login');
            }
    
            $akun = [
                'akun_username' => $username,
                'akun_nama_lengkap' => $dataAkun['nama_lengkap'],
                'akun_email' => $dataAkun['email']
            ];
            session()->set($akun);
            return redirect()->to('admin/sukses');
        }
        
        $data = [];
        if ($this->request->getMethod() == 'post') {
            $rules = [
                'username' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Username harus diisi'
                    ]
                ],
                'password' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Password harus diisi'
                    ]
                ]
            ];
    
            if (!$this->validate($rules)) {
                session()->setFlashdata("warning", $this->validation->getErrors());
                return redirect()->to("admin/login");
            }
    
            // Ambil dan trim username dan password
            $username = trim($this->request->getVar('username'));
            $password = trim($this->request->getVar('password'));
            $remember_me = $this->request->getVar('remember_me');
    
            $dataAkun = $this->m_admin->getData($username);
            if (!password_verify($password, $dataAkun['password'])) {
                $err[] = "Akun yang anda masukkan tidak sesuai.";
                session()->setFlashdata('username', $username);
                session()->setFlashdata('warning', $err);
                return redirect()->to("admin/login");
            }
    
            if ($remember_me == '1') {
                set_cookie("cookie_username", $username, 3600 * 24 * 30);
                set_cookie("cookie_password", $dataAkun['password'], 3600 * 24 * 30);
            }
    
            $akun = [
                'akun_username' => $dataAkun['username'],
                'akun_nama_lengkap' => $dataAkun['nama_lengkap'],
                'akun_email' => $dataAkun['email']
            ];
            session()->set($akun);
            return redirect()->to("admin/sukses")->withCookies();
        }
    
        echo view("admin/v_login", $data);
    }

    public function akun()
    {
        $session = session();
        
        // Cek apakah pengguna sudah login
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('admin/login');
        }

        // Ambil data pengguna dari session
        $username = $session->get('akun_username');
        $dataAkun = $this->m_admin->getAdminByUsername($username);

        $data = [];
        if ($this->request->getMethod() == 'post') {
            $rules = [
                'nama_lengkap' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama lengkap harus diisi'
                    ]
                ],
                'password_lama' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Password lama harus diisi'
                    ]
                ],
                'password_baru' => [
                    'rules' => 'min_length[5]|alpha_numeric',
                    'errors' => [
                        'min_length' => 'Minimum panjang password adalah 5 karakter',
                        'alpha_numeric' => 'Hanya angka, huruf, dan beberapa simbol saja yang diperbolehkan'
                    ]
                ],
                'password_baru_konfirmasi' => [
                    'rules' => 'matches[password_baru]',
                    'errors' => [
                        'matches' => 'Konfirmasi password tidak sesuai'
                    ]
                ]
            ];

            if (!$this->validate($rules)) {
                session()->setFlashdata("warning", $this->validation->getErrors());
                return redirect()->to("admin/akun");
            }

            // Ambil dan trim data dari form
            $nama_lengkap = trim($this->request->getVar('nama_lengkap'));
            $password_lama = trim($this->request->getVar('password_lama'));
            $password_baru = trim($this->request->getVar('password_baru'));

            // Verifikasi password lama
            if (!password_verify($password_lama, $dataAkun['password'])) {
                session()->setFlashdata('warning', ['Password lama tidak sesuai.']);
                return redirect()->to("admin/akun");
            }

            // Update nama lengkap
            $dataUpdate = [
                'nama_lengkap' => $nama_lengkap
            ];

            // Jika password baru diisi, hash dan simpan
            if (!empty($password_baru)) {
                $dataUpdate['password'] = password_hash($password_baru, PASSWORD_DEFAULT);
            }

            // Perbarui data di database
            $this->m_admin->update($dataAkun['id'], $dataUpdate); // Pastikan 'id' adalah kunci primer

            // Update session
            $session->set('akun_nama_lengkap', $nama_lengkap);

            session()->setFlashdata('success', 'Data berhasil diperbarui.');
            return redirect()->to("admin/akun");
        }

        // Jika metode tidak POST, ambil data untuk ditampilkan di form
        $data['templateJudul'] = "Pengaturan Akun";
        $data['nama_lengkap'] = $dataAkun['nama_lengkap'];

        return view('admin/v_akun', $data);
    }



    
    public function loginProcess()
    {
        $session = session();
        $username = trim($this->request->getVar('username'));
        $password = trim($this->request->getVar('password'));
    
        // Cek user di database
        $admin = $this->m_admin->getAdminByUsername($username);
    
        if ($admin) {
            // Verifikasi password
            if (password_verify($password, $admin['password'])) {
                // Buat session login
                $sessionData = [
                    'id' => $admin['id'], // Pastikan ada kolom id
                    'username' => $admin['username'],
                    'nama_lengkap' => $admin['nama_lengkap'],
                    'isLoggedIn' => true
                ];
                $session->set($sessionData);
    
                return redirect()->to('/admin/dashboard');
            } else {
                return redirect()->back()->with('error', 'Password salah.');
            }
        } else {
            return redirect()->back()->with('error', 'Username tidak ditemukan.');
        }
    }
    

    public function dashboard()
{
    $session = session();
    if (!$session->get('isLoggedIn')) {
        return redirect()->to('admin/login');
    }

    // Data yang dikirim ke view
    $data = [
        'template' => 'Halaman Dashboard',
        'username' => $session->get('username'),
        'nama_lengkap' => $session->get('nama_lengkap'),
    ];

    return view('admin/v_dashboard', $data);
}

    
    

    public function logout()
    {
        session()->destroy();
        return redirect()->to('admin/login');
    }
}
