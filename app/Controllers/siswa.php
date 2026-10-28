<?php

namespace App\Controllers;

use App\Models\SiswaModel;

class Siswa extends BaseController
{
    public function index()
    {
        $model = new SiswaModel();
        $data['siswa'] = $model->findAll();

        return view('siswa/index', $data);
    }
}