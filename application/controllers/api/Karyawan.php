<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
class Karyawan extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Karyawan_model', 'karyawan');

        $this->methods['index_get']['limit'] = 10;
    }
    public function index_get()
    {
        $id = $this->get('id');
        if ($id === null) {
            $karyawan = $this->karyawan->getKaryawan();
        } else {
            $karyawan = $this->karyawan->getKaryawan($id);
        }
        if ($karyawan) {
            $this->response([
                'status' => true,
                'data' => $karyawan
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'data' => 'id not found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
    public function index_delete()
    {
        $id = $this->delete('id');
        if ($id === null) {
            $this->response([
                'status' => false,
                'message' => 'provide an id!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if ($this->karyawan->deleteKaryawan($id) > 0) {
                //ok
                $this->response([
                    'status' => true,
                    'id' => $id,
                    'message' => 'data karyawan has been deleted!'
                ], REST_Controller::HTTP_NO_CONTENT);
            } else {
                //id not found
                $this->response([
                    'status' => false,
                    'message' => 'id not found!'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }
    public function index_post()
    {
        $data = [
            'id' => $this->post('id'),
            'no_karyawan' => $this->post('no_karyawan'),
            'nama' => $this->post('nama'),
            'no_tlp' => $this->post('no_tlp')
        ];
        if ($this->karyawan->createKaryawan($data) > 0) {
            $this->response([
                'status' => true,
                'message' => 'new karyawan has been created.'
            ], REST_Controller::HTTP_CREATED);
        } else {
            //id not found
            $this->response([
                'status' => false,
                'message' => 'failed to create new data!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    public function index_put()
    {
        // kenapa dibedakan agar id masuk ke where
        $id = $this->put('id');
        $data = [
            'id' => $this->put('id'),
            'no_karyawan' => $this->put('no_karyawan'),
            'nama' => $this->put('nama'),
            'no_tlp' => $this->put('no_tlp')
        ];
        if ($this->karyawan->updateKaryawan($data, $id) > 0) {
            $this->response([
                'status' => true,
                'message' => 'data karyawan has been updated.'
            ], REST_Controller::HTTP_NO_CONTENT);
        } else {
            //id not found
            $this->response([
                'status' => false,
                'message' => 'failed to update data!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}
