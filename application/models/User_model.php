<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model
{
    private $_table = "users";

    public $id_user;
    public $nama_user;
    public $username;
    public $password;

    public function rules()
    {
        return [
            ['field' => 'nama_user',
            'label' => 'Nama User',
            'rules' => 'required'],

            ['field' => 'username',
            'label' => 'Username',
            'rules' => 'required'],

            ['field' => 'password',
            'label' => 'Password',
            'rules' => 'required'],
            
        ];
    }

    public function getAll()
    {
        return $this->db->get($this->_table)->result();
    }
    
    public function getById($id)
    {
        return $this->db->get_where($this->_table, ["id_user" => $id])->row();
    }

    public function save()
    {
        $post = $this->input->post();
        $this->id_user = uniqid();
        $this->nama_user = $post["nama_user"];
        $this->username = $post["username"];
        $this->password = $post["password"];
        return $this->db->insert($this->_table, $this);
    }

    public function update()
    {
        $post = $this->input->post();
        $this->id_user = $post["id_user"];
        $this->nama_user = $post["nama_user"];
        $this->password = $post["password"];
        return $this->db->update($this->_table, $this, array('id_user' => $post['id_user']));
    }

    public function delete($id_user)
    {
        return $this->db->delete($this->_table, array("id_user" => $id_user));
    }

   public  function cek_login($table,$where){		
		return $this->db->get_where($table,$where);
	}	
}
