<?php
class TasksController extends Controller
{
    const itemsPerPage = 3;

    public function __construct($data = [])
    {
        parent::__construct($data);
        $this->model = new Task();
    }

    public function start()
    {
        Router::redirect('/tasks/index/1');
    }

    public function index()
    {
        $params = App::getRouter()->getParams();
        $page = isset($params[0]) ? $params[0] : 1;
        $this->data['role'] = ((!empty(Session::get('role'))) ? '/'. Session::get('role') : '');
        $sort = $_GET['sort'] ?? 'id';
        $itemsCount = count($this->model->getList());
        $p = new Pagination(array(
            'itemsCount' => $itemsCount,
            'itemsPerPage' => self::itemsPerPage,
            'currentPage' => $page
        ));
        $this->data['tasks'] =  $this->model->getList($page, self::itemsPerPage, $sort);
        $this->data['p'] = $p;

    }

    public function user_index()
    {
        $this->index();
    }

    public function admin_index()
    {
        $this->index();

    }

    public function view()
    {
        $params = App::getRouter()->getParams();
        $id = isset($params[0]) ? $params[0] : null;
        $this->data['task'] = $this->model->getByID($id);
        $this->data['role'] = ((!empty(Session::get('role'))) ? '/'. Session::get('role') : '');
    }

    public function user_view()
    {
        $this->view();
    }

    public function admin_view()
    {
        $this->view();
    }



    public function add()
    {
        if ($_POST) {
            if (!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['description']) && !empty($_FILES['picture'])) {

                $result = $this->model->saveArticle($_POST); // save to mySQL

                $id = $this->model->getID(); // name of the folder
                mkdir(ROOT.DS."webroot".DS."img".DS.$id);// create folder
                mkdir(ROOT.DS."webroot".DS."img".DS."tmp".DS.$id);

                $dir_name = ROOT.DS."webroot".DS."img".DS.$id.DS;
                $tmp_dir_name = ROOT.DS."webroot".DS."img".DS."tmp".DS.$id.DS;
                if ($_FILES) {
                    $type = $_FILES['picture']['type'];
                    if ($type == 'image/jpg' || $type == 'image/png' || $type == 'image/gif'){
                        $img = new Image($dir_name, $tmp_dir_name);
                        $name = $img->resize($_FILES['picture']);
                        $img->delete_tmp($name);
                    }else {
                        Session::setFlash('Type of image is not jpg/gif/png. (Or it was converted to jpg from jpeg)');
                        return false;
                    }
                }

                if ($result) {
                    Session::setFlash('Article was saved.');
                } else {
                    Session::setFlash('Error');
                }
                $uri = (!empty(Session::get('role'))) ? '/'. Session::get('role').'/tasks/index/' : '/tasks/index/';
                Router::redirect($uri);
            } else {
                Session::setFlash("Please fill all fields");
            }
        } else {
            return false;
        }
    }

    public function admin_add()
    {
        $this->add();
    }

    public function user_add()
    {
        $this->add();
    }

    function admin_edit(){
        if ($_POST) {
            if (!empty($_POST['name']) &&  !empty($_POST['description'])) {
                $params = App::getRouter()->getParams();
                $id = isset($params[0]) ? $params[0] : null;
                $result = $this->model->saveArticle($_POST, $id);

                if ($result) {
                    Session::setFlash('Article was saved.');
                } else {
                    Session::setFlash('Error');
                }
                Router::redirect("/admin/tasks/view/{$id}");
            } else {
                Session::setFlash("Please fill all fields");
            }
        }

        $params = App::getRouter()->getParams();
        $id = isset($params[0]) ? $params[0] : null;
        $this->data['task'] = $this->model->getByID($id);
    }

    public function admin_setDone()
    {
        $params = App::getRouter()->getParams();
        $id = isset($params[0]) ? $params[0] : null;
        $this->model->setDone($id);
        $uri = (!empty(Session::get('role'))) ? '/'. Session::get('role').'/tasks/view' : '/tasks/index/view';
        Router::redirect($uri.'/'.$id);
    }


}