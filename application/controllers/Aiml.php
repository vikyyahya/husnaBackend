<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Aiml extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Aiml_model");
        $this->load->model("Admin_model");
        $this->load->library('form_validation');
    }
    public function index()
    {
        if ($this->Admin_model->logged_id()) {
            $data["aiml"] = $this->Aiml_model->getAll();
            $this->load->view("aimlView", $data);
        } else {
            redirect("login");
        }
    }
    public function add()
    {
        if ($this->Admin_model->logged_id()) {
            $product = $this->Aiml_model;
            $validation = $this->form_validation;
            $validation->set_rules($product->rules());
            if ($validation->run()) {
                $product->save();
                $this->session->set_flashdata('success', 'Berhasil disimpan');
            }
            $this->load->view("addAiml");
        }
    }
    public function edit($id = null)
    {
        if (!isset($id)) redirect('aiml');
        $product = $this->Aiml_model;
        $validation = $this->form_validation;
        $validation->set_rules($product->rules());

        if ($validation->run()) {
            $product->update();
            $this->session->set_flashdata('success', 'Berhasil disimpan');
        }
        $data["product"] = $product->getById($id);
        if (!$data["product"]) show_404();
        $this->load->view("editAiml", $data);
    }
    public function delete($id = null)
    {
        if (!isset($id)) show_404();

        if ($this->Aiml_model->delete($id)) {
            redirect(site_url('aiml'));
        }
    }
}
