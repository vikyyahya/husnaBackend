<?php defined('BASEPATH') OR exit('No direct script access allowed');

class SpellCheck_model extends CI_Model
{

    private $_table = "spell_check";

    public $id;
    public $missspelling;
    public $correction;

    public function rules()
    {
        return [
            [
                'field' => 'missspelling',
                'label' => 'missspelling',
                'rules' => 'required'
            ],
            [
                'field' => 'correction',
                'label' => 'correction',
                'rules' => 'required'
            ]
        ];
    }

    public function getAll()
    {
        // return $this->db->get($this->_table)->result();
        $query = $this->db->query("Select s.id,s.missspelling,s.correction,a.nama  from spell_check s left join admin a on s.id_admin = a.id");
        return $query->result();
    }

    public function getById($id)
    {
        return $this->db->get_where($this->_table, ["id" => $id])->row();
    }

    public function save()
    {
        
        $post = $this->input->post();
        $a = $this->session->userdata('user_id');

        
        $this->id = null;
        $this->missspelling = $post["missspelling"];
        $this->correction = $post["correction"];
        $this->id_admin = $a;

        $this->db->insert($this->_table, $this);
    }

    public function update()
    {
        $a = $this->session->userdata('user_id');

        $post = $this->input->post();
        $this->id = $post["id"];
        $this->missspelling = $post["missspelling"];
        $this->correction = $post["correction"];
        $this->id_admin = $a;        

        $this->db->update($this->_table, $this, array('id' => $post['id']));
    }

    public function delete($id)
    {
        return $this->db->delete($this->_table, array("id" => $id));
    }


}