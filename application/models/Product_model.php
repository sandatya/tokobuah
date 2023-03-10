<?php 

defined('BASEPATH') or exit('No direct script access allowed');

class Product_model extends CI_Model{
    private $_table = "products";

    public $product_id;
    public $name;
    public $price;
    public $image = "default.jpg";
    public $description;

    public function rules(){
        return[
            ['field' => 'name',
             'label' => 'Name',
             'rules' => 'required'],

             ['field' => 'price',
             'label' => 'Price',
             'rules' => 'numeric'],

             ['field' => 'description',
             'label' => 'Description',
             'rules' => 'required']
        ];
    }

    public function getAll(){
        return $this->db->get($this->_table)->result(); // _table adalah nama table & result mengambil semua data hasil query
    }

    public function getById($id){
        return $this->db->get_where($this->_table, ["product_id" => $id])->row(); // row mengambil satu data dari hasil query
    }

    public function save(){
        $post = $this->input->post(); // ambil data dari form
        $this->product_id = uniqid(); // membuat id unik
        $this->name = $post["name"]; // isi field name
        $this->price = $post["price"]; // isi field price
        $this->image = $this->_uploadImage();
        $this->description = $post["description"]; // isi field description
        return $this->db->insert($this->_table, $this); // simpan ke database
    }

    public function update(){
        $post = $this->input->post();
        $this->product_id = $post["id"];
        $this->name = $post["name"];
        $this->price = $post["price"];
        if (!empty($_FILES["image"]["name"])) {
            $this->image = $this->_uploadImage();
        } else {
            $this->image = $post["old_image"];
        }
        $this->description = $post["description"];
        return $this->db->update($this->_table, array("product_id" => $post['id']));
    }

    public function delete($id){
        $this->_deleteImage($id);
        return $this->db->delete($this->_table, array("product_id" => $id));
    }

    private function _uploadImage()
    {
        $config['upload_path']          = './upload/product/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['file_name']            = $this->product_id;
        $config['overwrite']			= true;
        $config['max_size']             = 1024; // 1MB
        // $config['max_width']            = 1024;
        // $config['max_height']           = 768;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('image')) {
            return $this->upload->data("file_name");
        }
        
        return "default.jpg";
    }

    private function _deleteImage($id)
    {
        $product = $this->getById($id);
        if ($product->image != "default.jpg") {
            $filename = explode(".", $product->image)[0];
            return array_map('unlink', glob(FCPATH."upload/product/$filename.*"));
        }
    }


    //get data dari tabel products
    function get_data($table){
        return $this->db->get($table);
    }
}    