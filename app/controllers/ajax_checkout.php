<?php

class Ajax_checkout extends Controller
{
    public function index($data_type = '', $id = '')
    {
        //print_r($id);

        $id = json_decode($id);
        $country = $this->load_model('country');
        $data = $country->get_states($id->id);

        $info = (object)[]; //empty object
        $info->data = $data;
        $info->data_type = 'get_states';

        echo json_encode($info);
    }
}
