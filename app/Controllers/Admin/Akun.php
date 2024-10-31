<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AdminModel;

class Akun extends BaseController
{
    protected $m_admin;

    function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->m_admin = new AdminModel();
        helper("global_fungsi_helper");
        $this->halaman_controller = "akun";
        $this->halaman_label = "Akun";
    }

    function index()
    {
        $data = [];
        if ($this->request->getMethod() === 'post') {
            $nama_lengkap = trim($this->request->getVar('nama_lengkap'));
            $password_lama = trim($this->request->getVar('password_lama'));
            $password_baru = trim($this->request->getVar('password_baru'));
            $password_baru_konfirmasi = trim($this->request->getVar('password_baru_konfirmasi'));

            // Aturan validasi
            $aturan = [
                'nama_lengkap' => [
                    'rules' => 'required',
                    'errors' => ['required' => 'Nama lengkap harus diisi']
                ],
                'password_lama' => [
                    'rules' => 'required|check_old_password',
                    'errors' => [
                        'required' => 'Password lama harus diisi',
                        'check_old_password' => 'Password lama tidak sesuai'
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
                    'errors' => ['matches' => 'Konfirmasi password tidak sesuai']
                ]
            ];

            // Validasi dan proses pembaruan
            if (!$this->validate($aturan)) {
                session()->setFlashdata('warning', $this->validation->getErrors());
            } else {
                // Memperbarui nama lengkap
                $dataUpdate = [
                    'email' => session()->get('akun_email'),
                    'nama_lengkap' => $nama_lengkap
                ];
                $this->m_admin->updateAdmin(session()->get('akun_id'), $dataUpdate);

                // Memperbarui password jika password baru diisi
                if (!empty($password_baru)) {
                    $hashedPassword = password_hash($password_baru, PASSWORD_DEFAULT);
                    $dataUpdatePassword = [
                        'email' => session()->get('akun_email'),
                        'password' => $hashedPassword
                    ];
                    $this->m_admin->updateAdmin(session()->get('akun_id'), $dataUpdatePassword); // Kirim ID untuk diperbarui
                }

                // Memperbarui session
                session()->set('nama_lengkap', $nama_lengkap);
                session()->setFlashdata('success', 'Data berhasil diupdate');
            }

            return redirect()->to('admin/' . $this->halaman_controller)->withCookies();
        }

        $username = session()->get('akun_username');
        $data = $this->m_admin->getData($username);
        $data['templateJudul'] = "Halaman " . $this->halaman_label;

        echo view('admin/v_template_header', $data);
        echo view('admin/v_akun', $data);
        echo view('admin/v_template_footer', $data);
    }

    // Metode untuk memeriksa password lama
    public function check_old_password(string $str): bool
    {
        $username = session()->get('akun_username');
        $adminData = $this->m_admin->getAdminByUsername($username);
        
        // Cek password lama
        if ($adminData && password_verify($str, $adminData['password'])) {
            return true;
        }

        return false;
    }
}
