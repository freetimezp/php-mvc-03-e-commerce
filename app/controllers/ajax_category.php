<?php

class Ajax_category extends Controller
{
    public function index()
    {
        $data = file_get_contents("php://input");
        $data = json_decode($data);
        //var_dump($data);

        if (is_object($data) && isset($data->data_type)) {
            $DB = Database::newInstance();
            $category = $this->load_model('category');

            if ($data->data_type == 'add_category') {
                //add new category
                $check = $category->create($data);

                if ($_SESSION['error'] != "") {
                    $arr['message'] = $_SESSION['error'];
                    $_SESSION['error'] = "";
                    $arr['message_type'] = 'error';

                    $arr['data'] = "";
                    $arr['data_type'] = "add_new";

                    echo json_encode($arr);
                } else {
                    $arr['message'] = 'Category added successfully';
                    $arr['message_type'] = 'info';

                    $cats = $category->get_all();
                    $arr['data'] = $category->make_table($cats);
                    $arr['data_type'] = "add_new";
                    //var_dump($cats);

                    echo json_encode($arr);
                }
            } else if ($data->data_type == 'delete_row') {
                //delete category
                $category->delete($data->id);

                $arr['message'] = "Your category was deleted!";
                $_SESSION['error'] = "";

                $arr['message_type'] = 'info';
                $arr['data_type'] = "delete_row";

                $cats = $category->get_all();
                $arr['data'] = $category->make_table($cats);

                echo json_encode($arr);
            } else if ($data->data_type == 'disable_row') {
                //disable category
                $id = $data->id;
                $disabled = ($data->current_state == "Disabled") ? 0 : 1;

                $query = "UPDATE categories SET disabled = '$disabled' WHERE id = '$id' LIMIT 1";
                $DB->write($query);

                $arr['message'] = "You activate or deactivate row!";
                $_SESSION['error'] = "";

                $arr['message_type'] = 'info';
                $arr['data_type'] = "disable_row";

                $cats = $category->get_all();
                $arr['data'] = $category->make_table($cats);

                echo json_encode($arr);
            } else if ($data->data_type == 'edit_category') {
                //edit category
                $category->edit($data->id, $data->category);

                $arr['message'] = "Your category was updated!";
                $_SESSION['error'] = "";

                $arr['message_type'] = 'info';
                $arr['data_type'] = "edit_category";

                $cats = $category->get_all();
                $arr['data'] = $category->make_table($cats);

                echo json_encode($arr);
            }
        }
    }
}
