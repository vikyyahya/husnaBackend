<?php defined('BASEPATH') or exit('No direct script access allowed');

class InfoBot_model extends CI_Model
{

    private $_table = "bots";

    public $bot_id;
    public $bot_name;
    public $error_response;
    public $unknown_user;

    public function rules()
    {
        return [
            [
                'field' => 'bot_name',
                'label' => 'bot_name',
                'rules' => 'required'
            ],
            [
                'field' => 'error_response',
                'label' => 'error_response',
                'rules' => 'required'
            ],
            [
                'field' => 'unknow_user',
                'label' => 'unknow_user',
                'rules' => 'required'
            ]
        ];
    }

    public function getAll()
    {
        return $this->db->get($this->_table)->result();
        // $query = $this->db->query("Select s.id,s.missspelling,s.correction,a.nama  from spell_check s left join admin a on s.id_admin = a.id");
        // return $query->result();
    }

    public function getById($id)
    {
        return $this->db->get_where($this->_table, ["id" => $id])->row();
    }

    // public function save()
    // {

    //     $post = $this->input->post();
    //     $a = $this->session->userdata('user_id');


    //     $this->bot_id = null;
    //     $this->missspelling = $post["missspelling"];
    //     $this->correction = $post["correction"];
    //     $this->id_admin = $a;

    //     $this->db->insert($this->_table, $this);
    // }

    public function update()
    {
        $post = $this->input->post();
        $this->bot_id = $post["bot_id"];
        $this->bot_name = $post["bot_name"];
        $this->error_response = $post["error_response"];
        $this->unknown_user = $post["unknown_user"];

        $this->db->update($this->_table, $this, array('id' => $post['id']));
    }

    public function delete($id)
    {
        return $this->db->delete($this->_table, array("id" => $id));
    }
}
