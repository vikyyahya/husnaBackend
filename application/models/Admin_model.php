<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model
{
    private $_table = "admin";

    public $id;
    public $user_name;
    public $password;
    public $nama;

    public function rules()
    {
        return [
            ['field' => 'user_name',
            'label' => 'User Name',
            'rules' => 'required'],

            ['field' => 'password',
            'label' => 'Password',
            'rules' => 'required|min_length[5]']
        ];
    }

     function logged_id()
    {
        return $this->session->userdata('user_id');
    }

       function check_login($field1, $field2)
    {
        $this->db->select('*');
        $this->db->from("admin");
        $this->db->where($field1);
        $this->db->where($field2);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return FALSE;
        } else {
            return $query->result();
        }
    }

    public function getAll()
    {
        return $this->db->get($this->_table)->result();
    }
    
    public function getById($id)
    {
        return $this->db->get_where($this->_table, ["id" => $id])->row();
    }

    public function save()
    {
        $ip = $this->input->ip_address();
        date_default_timezone_set('Asia/Jakarta'); # add your city to set local time zone
        $now = date('Y-m-d H:i:s');
        $post = $this->input->post();

        // $pass = $this->encrypt->encode(md5($this->input->post('password')),$key);

        $this->id = null;
        $this->user_name = $post["user_name"];
        $this->password = md5($post["password"]);
        $this->nama = $post["nama"];
        $this->db->insert($this->_table, $this);
    }

    public function update()
    {
        $post = $this->input->post();
        $this->id = $post["id"];
        $this->user_name = $post["user_name"];
        $this->password = md5($post["password"]);
        $this->nama =$post["nama"];

        $this->db->update($this->_table, $this, array('id' => $post['id']));
    }

    public function delete($id)
    {
        return $this->db->delete($this->_table, array("id" => $id));
    }
}