<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $table = 'admin'; // Nama tabel yang digunakan
    protected $primaryKey = 'id'; // Nama kolom primary key
    protected $allowedFields = ['username', 'nama_lengkap', 'email', 'password']; // Kolom yang dapat diupdate

    // Mengambil data admin berdasarkan username
    public function getAdminByUsername($username)
    {
        return $this->where('username', $username)->first();
    }

    // Metode untuk mengambil data admin berdasarkan username (redundan, bisa dihapus jika tidak digunakan)
    public function getData($username)
    {
        return $this->where('username', $username)->first();
    }

    // Memeriksa apakah password lama cocok
    public function check_old_password($username, $old_password)
    {
        $adminData = $this->getAdminByUsername($username);
        return $adminData && password_verify($old_password, $adminData['password']);
    }

    // Memperbarui data admin
    public function updateAdmin($id, $data): bool
    {
        return $this->update($id, $data);
    }
}
