<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class PertanyaanAPI extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

    //Menampilkan data pertanyaan
    function index_get() {
        $id = $this->get('idPertanyaan');
        if ($id == '') {
            $pertanyaan = $this->db->get('tblPertanyaan')->result();
        } else {
            $this->db->where('idPertanyaan', $id);
            $pertanyaan = $this->db->get('tblPertanyaan')->result();
        }
        $this->response($pertanyaan, 200);
    }

//Mengirim atau menambah data kontak baru
    function index_post() {
        $data = array(
                    'idPertanyaan'           => $this->post('idPertanyaan'),
                    'pertanyaan'          => $this->post('pertanyaan'),
                    'jawaban'    => $this->post('jawaban'));
        $insert = $this->db->insert('tblPertanyaan', $data);
        if ($insert) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }

    //Memperbarui data kontak yang telah ada
    function index_put() {
        $id = $this->put('idPertanyaan');
        $data = array(
                  'idPertanyaan'           => $this->put('idPertanyaan'),
                    'pertanyaan'          => $this->put('pertanyaan'),
                    'jawaban'    => $this->put('jawaban'));
        $this->db->where('idPertanyaan', $id);
        $update = $this->db->update('tblPertanyaan', $data);
        if ($update) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }

    //Menghapus salah satu data kontak
    function index_delete() {
        $id = $this->delete('idPertanyaan');
        $this->db->where('idPertanyaan', $id);
        $delete = $this->db->delete('tblPertanyaan');
        if ($delete) {
            $this->response(array('status' => 'success'), 201);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }



    //Masukan function selanjutnya disini
}
?>