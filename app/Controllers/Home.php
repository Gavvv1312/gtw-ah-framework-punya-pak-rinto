<?php

namespace App\Controllers;

use App\Models\SiswaModel;

class Home extends BaseController
{
    public function index()
    {
        $siswaModel = new SiswaModel();
        $data['siswa'] = $siswaModel->getSiswa();

        return view('siswa', $data);
    }

    // Method untuk menyimpan data siswa baru
    public function tambah()
    {
        $data = [
            'nis'   => trim((string) $this->request->getPost('nis')),
            'nama'  => trim((string) $this->request->getPost('nama')),
            'kelas' => trim((string) $this->request->getPost('kelas')),
        ];

        if (! $this->validateData($data, [
            'nis'   => 'required',
            'nama'  => 'required',
            'kelas' => 'required',
        ])) {
            if ($this->wantsJsonResponse()) {
                return $this->response
                    ->setStatusCode(422)
                    ->setJSON(['success' => false, 'errors' => $this->validator->getErrors()]);
            }

            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $siswaModel = new SiswaModel();
        $id = $siswaModel->insert($data, true);

        if ($id === false) {
            if ($this->wantsJsonResponse()) {
                return $this->response
                    ->setStatusCode(500)
                    ->setJSON(['success' => false, 'message' => 'Data siswa gagal disimpan.']);
            }

            return redirect()->back()->withInput()->with('error', 'Data siswa gagal disimpan.');
        }

        $siswa = $siswaModel->find($id);

        if ($this->wantsJsonResponse()) {
            return $this->response->setJSON(['success' => true, 'siswa' => $siswa]);
        }

        return redirect()->to(base_url('/'));
    }

    public function edit()
    {
        $id = trim((string) $this->request->getPost('id'));
        $data = [
            'nis'   => trim((string) $this->request->getPost('nis')),
            'nama'  => trim((string) $this->request->getPost('nama')),
            'kelas' => trim((string) $this->request->getPost('kelas')),
        ];
        $validationData = ['id' => $id] + $data;

        if (! $this->validateData($validationData, [
            'id'    => 'required|is_natural_no_zero',
            'nis'   => 'required',
            'nama'  => 'required',
            'kelas' => 'required',
        ])) {
            if ($this->wantsJsonResponse()) {
                return $this->response
                    ->setStatusCode(422)
                    ->setJSON(['success' => false, 'errors' => $this->validator->getErrors()]);
            }

            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id = (int) $id;
        $siswaModel = new SiswaModel();
        if ($siswaModel->find($id) === null) {
            if ($this->wantsJsonResponse()) {
                return $this->response
                    ->setStatusCode(404)
                    ->setJSON(['success' => false, 'message' => 'Data siswa tidak ditemukan.']);
            }

            return redirect()->to(base_url('/'))->with('error', 'Data siswa tidak ditemukan.');
        }

        if (! $siswaModel->update($id, $data)) {
            if ($this->wantsJsonResponse()) {
                return $this->response
                    ->setStatusCode(500)
                    ->setJSON(['success' => false, 'message' => 'Data siswa gagal diperbarui.']);
            }

            return redirect()->back()->withInput()->with('error', 'Data siswa gagal diperbarui.');
        }

        if ($this->wantsJsonResponse()) {
            return $this->response->setJSON(['success' => true, 'siswa' => $siswaModel->find($id)]);
        }

        return redirect()->to(base_url('/'));
    }

    // Method untuk menghapus data siswa berdasarkan ID
    public function hapus($id)
    {
        $siswaModel = new SiswaModel();
        $siswa = $siswaModel->find($id);

        if ($siswa === null || ! $siswaModel->delete($id)) {
            if ($this->wantsJsonResponse()) {
                return $this->response
                    ->setStatusCode(404)
                    ->setJSON(['success' => false, 'message' => 'Data siswa tidak ditemukan atau gagal dihapus.']);
            }

            return redirect()->to(base_url('/'))->with('error', 'Data siswa tidak ditemukan atau gagal dihapus.');
        }

        if ($this->wantsJsonResponse()) {
            return $this->response->setJSON(['success' => true, 'id' => (int) $id]);
        }

        return redirect()->to(base_url('/'));
    }

    private function wantsJsonResponse(): bool
    {
        return $this->request->isAJAX()
            || str_contains($this->request->getHeaderLine('Accept'), 'application/json');
    }
}