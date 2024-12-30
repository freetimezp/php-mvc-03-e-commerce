<?php

class Add_to_cart extends Controller
{
    private $redirect_to = "";

    public function index($id = '')
    {
        $this->set_redirect();

        $id = esc($id);

        $DB = Database::newInstance();
        $rows = $DB->read("SELECT * FROM products WHERE id = :id LIMIT 1", ['id' => $id]);

        if ($rows) {
            $row = $rows[0];

            if (isset($_SESSION['CART'])) {
                $ids = array_column($_SESSION['CART'], "id");
                if (in_array($row->id, $ids)) {
                    $key = array_search($row->id, $ids);
                    $_SESSION['CART'][$key]['qty']++;
                } else {
                    $arr = array();
                    $arr['id'] = $row->id;
                    $arr['qty'] = 1;

                    $_SESSION['CART'][] = $arr;
                }
            } else {
                $arr = array();
                $arr['id'] = $row->id;
                $arr['qty'] = 1;

                $_SESSION['CART'][] = $arr;
            }
        }

        $this->redirect();
    }


    public function add_quantity($id = '')
    {
        $this->set_redirect();

        $id = esc($id);

        if (isset($_SESSION['CART'])) {
            foreach ($_SESSION['CART'] as $key => $item) {
                if ($item['id'] == $id) {
                    $_SESSION['CART'][$key]['qty'] += 1;
                    break;
                }
            }
        }

        $this->redirect();
    }


    public function subtract_quantity($id = '')
    {
        $this->set_redirect();

        $id = esc($id);

        if (isset($_SESSION['CART'])) {
            foreach ($_SESSION['CART'] as $key => $item) {
                if ($item['id'] == $id) {
                    if ($_SESSION['CART'][$key]['qty'] <= 1) {
                        $this->remove($id);
                    } else {
                        $_SESSION['CART'][$key]['qty'] -= 1;
                    }
                    break;
                }
            }
        }

        $this->redirect();
    }


    public function remove($id = '')
    {
        $this->set_redirect();

        $id = esc($id);

        if (isset($_SESSION['CART'])) {
            foreach ($_SESSION['CART'] as $key => $item) {
                if ($item['id'] == $id) {
                    unset($_SESSION['CART'][$key]);
                    $_SESSION['CART'] = array_values($_SESSION['CART']);
                    break;
                }
            }
        }
    }


    private function redirect()
    {
        header("Location: " . $this->redirect_to);
        die;
    }


    private function set_redirect()
    {
        if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != "") {
            $this->redirect_to = $_SERVER['HTTP_REFERER'];
        } else {
            $this->redirect_to = ROOT . "shop";
        }
    }
}
