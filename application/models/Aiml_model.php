<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Aiml_model extends CI_Model
{
    private $_table = "aiml";

    public $id;
    public $bot_id;
    public $pattern;
    public $thatpattern;
    public $template;
    public $topic;
    public $filename;



    public function rules()
    {
        return [
            ['field' => 'pattern',
            'label' => 'Pattern',
            'rules' => 'required'],

            ['field' => 'template',
            'label' => 'Template',
            'rules' => 'required'],

             ['field' => 'filename',
            'label' => 'Filename',
            'rules' => 'required']
        ];
    }

   
    public function getAll()
    {
        // return $this->db->get($this->_table)->result();
        $query = $this->db->query("Select aiml.id,aiml.pattern,aiml.thatpattern,aiml.template,aiml.topic,aiml.filename,admin.nama from aiml LEFT join admin on aiml.id_admin = admin.id ");
        return $query->result();
    }
    public function getById($id)
    {
        return $this->db->get_where($this->_table, ["id" => $id])->row();
    }
    public function save()
    {
        $a=$this->session->userdata('user_id');
        $post = $this->input->post();
        $this->id = null;
        $this->bot_id = "1";
        $this->pattern = $post["pattern"];
        $this->thatpattern = $post["thatpattern"];
        $this->template = $post["template"];
        $this->topic = $post["topic"];
        $this->filename = $post["filename"];
        $this->id_admin = $a;
        // $this->id_admin = $post[""];
        $this->db->insert($this->_table, $this);
    }
    public function update()
    {
        $a = $this->session->userdata('user_id');
        $post = $this->input->post();
        $this->id = $post['id'];
        $this->bot_id = "1";
        $this->pattern = $post["pattern"];
        $this->thatpattern = $post["thatpattern"];
        $this->template = $post["template"];
        $this->topic = $post["topic"];
        $this->filename = $post["filename"];
        $this->id_admin = $a;
        $this->db->update($this->_table, $this, array('id' => $post['id']));
    }
    public function delete($id)
    {
        return $this->db->delete($this->_table, array("id" => $id));
    }
}