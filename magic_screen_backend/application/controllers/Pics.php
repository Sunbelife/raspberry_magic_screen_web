<?php
/**
 * Created by PhpStorm.
 * User: sunbelife
 * Date: 2019/8/30
 * Time: 12:04 AM
 */


class Pics extends CI_Controller
{
    function __construct() {
        parent::__construct();
        $this->load->model('Pics_model', 'api');
        $this->load->library('image_lib');
    }

    public function index()
    {
        echo "hello pics";
        return 0;
    }

    public function get_all_pics() {
        $data = $this->api->get_all_pics();
        echo json_encode($data);
        return 0;
    }

    public function edit_pic() {
        $id = $_GET['id'];
        $name = $_GET['name'];
        $data = $this->api->edit_pic($id, $name);
        echo json_encode($data);
        return 0;
    }

    public function delete_one_pic() {
        $id = $_GET['id'];
        $data = $this->api->delete_one_pic($id);
        return $data;
    }

    public function upload_pic() {
        $config['upload_path']      = './uploads/';
        $config['allowed_types']    = 'gif|jpg|png|jpeg';

        $url_prefix = "./uploads/";

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('file'))
        {
            $error = array('error' => $this->upload->display_errors());
            var_dump($error);
        }
        else
        {
            $data = array('upload_data' => $this->upload->data());

            foreach($data as $val){
                $orig_name = $val['orig_name'];
                $show_name = $val['raw_name'];
                $this->resize_pic($url_prefix.$orig_name);
                $full_path = $url_prefix.$orig_name;
                $thumb_path = $url_prefix.$val['raw_name']."_thumb".$val['file_ext'];

                $config['image_library'] = 'gd2';
                $config['source_image'] = $orig_name;
                $config['create_thumb'] = TRUE;
                $config['maintain_ratio'] = TRUE;
                $config['width']     = 75;
                $config['height']   = 50;

                $this->load->library('image_lib', $config);

                $this->image_lib->resize();

                echo $this->image_lib->display_errors();
            }

            $this->api->save_to_database($full_path, $show_name, $thumb_path);
        }
    }

    function resize_pic($orig_name) {
        $config['image_library'] = 'gd2';
        $config['source_image'] = $orig_name;
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['width']     = 75;
        $config['height']   = 50;

        $this->load->library('image_lib', $config);

        $this->image_lib->resize();

        echo $this->image_lib->display_errors();
    }
}