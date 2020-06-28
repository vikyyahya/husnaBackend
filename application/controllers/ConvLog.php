<?php
defined('BASEPATH') or exit('No direct script access allowed');
class ConvLog extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("ConvLog_model");
        $this->load->model("Admin_model");
        $this->load->library('form_validation');
    }
    public function index()
    {
        if ($this->Admin_model->logged_id()) {
            $data["ConvLog"] = $this->ConvLog_model->getAll();
            $this->load->view("ConvLog_view", $data);
        } else {
            redirect("login");
        }
    }
    public function add()
    {
        if ($this->Admin_model->logged_id()) {
            $product = $this->Admin_model;
            $validation = $this->form_validation;
            $validation->set_rules($product->rules());
            if ($validation->run()) {
                $product->save();
                $this->session->set_flashdata('success', 'Berhasil disimpan');
            }
            $this->load->view("admin/new_admin");
        }
    }
    public function edit($id = null)
    {
        if (!isset($id)) redirect('admins');
        $product = $this->Admin_model;
        $validation = $this->form_validation;
        $validation->set_rules($product->rules());

        if ($validation->run()) {
            $product->update();
            $this->session->set_flashdata('success', 'Berhasil disimpan');
        }
        $data["product"] = $product->getById($id);
        if (!$data["product"]) show_404();
        $this->load->view("admin/edit_admin", $data);
    }
    public function delete($id = null)
    {
        if (!isset($id)) show_404();

        if ($this->Admin_model->delete($id)) {
            redirect(site_url('admins'));
        }
    }
}
