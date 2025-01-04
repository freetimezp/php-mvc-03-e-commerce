<?php

class Ajax_checkout extends Controller
{
    public function index($data_type = '', $id = '')
    {
        //print_r($id);

        $id = json_decode($id);
        $countries = $this->load_model('countries');
        $data = $countries->get_states($id->id);

        $info = (object)[]; //empty object
        $info->data = $data;
        $info->data_type = 'get_states';

        echo json_encode($info);
    }
}
