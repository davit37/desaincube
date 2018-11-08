<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Template Extends CI_Loader{

        public function load($view_file_name,$data_array=[])
        {
                

                $this->view("admin/header");

                $this->view($view_file_name,$data_array);

                $this->view("admin/footer");
        }
}