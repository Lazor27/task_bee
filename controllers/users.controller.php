<?php

class UsersController extends Controller
{
    public function __construct($data = [])
    {
        parent::__construct($data);
        $this->model = new User();
    }

    public function login()
    {
        if ($_POST) {
            if (!empty($_POST['login']) && !empty($_POST['password']) ) {


                    $user = $this->model->getByLogin($_POST['login']); // false or true
                    $hash = md5(Config::get('salt') . $_POST['password']);

                    if ($user && $hash == $user['password']) {
                        Session::set('id', $user['id']);
                        Session::set('login', $user['login']);
                        Session::set('role', $user['role']);
                    }else{
                        Session::setFlash('Login and password are incorrect');
                        return false;
                    }

                    if (Session::get('role') == 'admin') {
                        Router::redirect('/admin/tasks/index/');
                    } else  {
                        Router::redirect('/user/tasks/index/');
                    }}else{
                Session::setFlash('Please fill in all fields');

            }

        }
    }

    public function registration()
    {
        if ($_POST) {
            if (!empty($_POST['first_name']) && !empty($_POST['second_name']) && !empty($_POST['login_name']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['date_of_birth']) ) {


                $first_name = $_POST['first_name'];
                $second_name = $_POST['second_name'];
                $login = $_POST['login_name'];
                $email = $_POST['email'];
                $password = md5(Config::get('salt') . $_POST['password']); // salt + password
                $date = $_POST['date_of_birth'];

                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    Session::setFlash('Please enter real email address!');
                }

                if ($this->model->getByEmail($email)) {
                    Session::setFlash('This email is used!');
                    return false;
                }

                if ($this->model->getByLogin($login)) {
                    Session::setFlash('The login is used!');
                    return false;
                }

                $this->model->registerUser($first_name, $second_name, $login, $email, $password, $date);

                Router::redirect('/users/login/'); // to the home page
            }else {
                Session::setFlash('Please fill in all fields!');
            }
        }else {
            return false;
        }
    }

    public function logout() {
        Session::destroy();
        Router::redirect('/tasks/index/1');
    }

}