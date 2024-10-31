<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PostsModel;

class Socials extends BaseController
{
    function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->m_posts = new PostsModel();
        helper("global_fungsi_helper"); // Load custom helper
        $this->halaman_controller = "socials";
        $this->halaman_label = "Social Media";
    }

    function index()
    {
        $data = [];

        // Handle form submission
        if ($this->request->getMethod() == 'post') {
            $configs = ['set_socials_twitter', 'set_socials_facebook', 'set_socials_github'];

            foreach ($configs as $config) {
                $dataSimpan = [
                    'konfigurasi_value' => $this->request->getVar($config)
                ];
                konfigurasi_set($config, $dataSimpan);
            }

            session()->setFlashdata('success', 'Data berhasil disimpan');
            return redirect()->to('admin/' . $this->halaman_controller);
        }

        // Fetch configuration settings
        $configs = ['set_socials_twitter', 'set_socials_facebook', 'set_socials_github'];
        foreach ($configs as $config) {
            $data[$config] = konfigurasi_get($config)['konfigurasi_value'] ?? '';
        }

        $data['templateJudul'] = "Halaman " . $this->halaman_label;

        // Render views
        echo view('admin/v_template_header', $data);
        echo view('admin/v_socials', $data);
        echo view('admin/v_template_footer', $data);
    }
}
