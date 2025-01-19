<?php

class Contact_us extends Controller
{
    public function index()
    {
        $DB = Database::newInstance();

        $data['page_title'] = "Contact US";
        $data['errors'] = array();

        $Message = $this->load_model('message');
        $User = $this->load_model('user');

        $user_data = $User->check_login();
        if (!empty($user_data)) {
            $data['user_data'] = $user_data;
        }


        if (count($_POST) > 0) {
            $data['POST'] = $_POST;

            $data['errors'] = $Message->create($_POST);

            if (!is_array($data['errors']) && $data['errors']) {
                redirect("contact_us?success=true");
            }
        }


        //show($data['POST']);
        $this->view("contact-us", $data);
    }
}
