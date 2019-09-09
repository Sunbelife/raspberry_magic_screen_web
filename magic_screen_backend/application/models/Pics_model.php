<?php
/**
 * Created by PhpStorm.
 * User: sunbelife
 * Date: 2019/9/2
 * Time: 11:27 AM
 */

Class Pics_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_pics() {
        $sql = "SELECT * FROM mg_pics";
        $query  = $this->db->query($sql);
        $result = $query->result_array();
        foreach ($result as $k=>$v) {
            $result[$k]['pic_dir'] = $this->config->item('base_url').'/'.$v['pic_dir'];
            $result[$k]['pic_thumb'] = $this->config->item('base_url').'/'.$v['pic_thumb'];
        }
        return $result;
    }

    public function save_to_database($full_path, $orig_name, $thumb_path) {
        $sql = "INSERT INTO `mg_pics` (`id`, `pic_name`, `pic_dir`, `pic_thumb`) VALUES (NULL, '".$orig_name."', '".$full_path."', '".$thumb_path."');";
        $query = $this->db->query($sql);
        if ($query == 1) {
            return 0;
        } else {
            return -1;
        }
    }

    public function edit_pic($id, $name) {
        $sql = "UPDATE `mg_pics` SET `pic_name` = '".$name."' WHERE `mg_pics`.`id` = ". $id;
        $query = $this->db->query($sql);
        if ($query == 1) {
            return 0;
        } else {
            return -1;
        }
    }

    public function delete_one_pic($id) {
        $sql = "DELETE FROM `mg_pics` WHERE `id` = " . $id;
        $query = $this->db->query($sql);
        if ($query == 1) {
            return 0;
        } else {
            return -1;
        }
    }
}