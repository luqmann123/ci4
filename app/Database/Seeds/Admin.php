<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Admin extends Seeder
{
    public function run()
    {
        $data = [
            'username' => $username,
            'password' => password_hash($newPassword, PASSWORD_DEFAULT), // Pastikan menggunakan password_hash
            'nama_lengkap' => $nama_lengkap,
            'email' => $email
        ];
        
        $this->db->table('admin')->insert($data);
    }
}
