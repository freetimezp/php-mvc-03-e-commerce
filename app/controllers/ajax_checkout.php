<?php

class Ajax_checkout extends Controller
{
    public function index($data_type = '', $id = '')
    {
        $info = file_get_contents("php://input");
        $info = json_decode($info);

        $id = $info->data->id;

        $countries = $this->load_model('countries');
        $data = $countries->get_states($id);

        $info = (object)[]; //empty object
        $info->data = $data;
        $info->data_type = 'get_states';

        echo json_encode($info);
    }
}
