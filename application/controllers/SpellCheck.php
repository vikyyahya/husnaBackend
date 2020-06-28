<?php
defined('BASEPATH') or exit('No direct script access allowed');
class SpellCheck extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("SpellCheck_model");
        $this->load->model("Admin_model");
        $this->load->library('form_validation');
    }

    public function index()
    {

        if ($this->Admin_model->logged_id()) {
            $data["aiml"] = $this->SpellCheck_model->getAll();
            $this->load->view("SpellCheckView",$data);
        } else {
            redirect("login");
        }
    }

    public function add()
    {
        if ($this->Admin_model->logged_id()) {
            $product = $this->SpellCheck_model;
            $validation = $this->form_validation;
            $validation->set_rules($product->rules());
            if ($validation->run()) {
                $product->save();
                $this->session->set_flashdata('success', 'Berhasil disimpan');
            }
            $this->load->view("addSpellCheck");
        }

    }

    public function edit($id = null)
    {

        if (!isset($id)) redirect('spellCheck');
        $product = $this->SpellCheck_model;
        $validation = $this->form_validation;
        $validation->set_rules($product->rules());

        if ($validation->run()) {
            $product->update();
            $this->session->set_flashdata('success', 'Berhasil disimpan');
        }
        $data["product"] = $product->getById($id);
        if (!$data["product"]) show_404();
        $this->load->view("editSpellCheck", $data);
    }
    public function delete($id = null)
    {
        if (!isset($id)) show_404();

        if ($this->SpellCheck_model->delete($id)) {
            redirect(site_url('spellCheck'));
        }
    }
}
