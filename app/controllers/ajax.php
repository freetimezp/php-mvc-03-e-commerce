<?php

class Ajax extends Controller
{
    public function index()
    {
        $data = file_get_contents("php://input");
        $data = json_decode($data);
        //var_dump($data);

        if (is_object($data)) {
            if ($data->data_type == 'add_category') {
                //add new category
                $category = $this->load_model('category');
                $check = $category->create($data);

                if ($_SESSION['error'] != "") {
                    $arr['message'] = $_SESSION['error'];
                    $_SESSION['error'] = "";
                    $arr['message_type'] = 'error';
                    $arr['data'] = "";

                    echo json_encode($arr);
                } else {
                    $arr['message'] = 'Category added successfully';
                    $arr['message_type'] = 'info';

                    $cats = $category->get_all();
                    $arr['data'] = $category->make_table($cats);
                    //var_dump($cats);

                    echo json_encode($arr);
                }
            }
        }
    }
}
