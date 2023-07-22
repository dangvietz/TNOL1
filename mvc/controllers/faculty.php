<?php
require_once "./mvc/core/AuthCore.php";

class Faculty extends Controller
{
    public $khoaModel;
    public $lopModel;

    public function __construct()
    {
        $this->khoaModel = $this->model("KhoaModel");
        $this->lopModel = $this->model("LopModel");
        require_once "./mvc/core/Pagination.php";
    }

    public function default()
    {
        if (AuthCore::checkPermission("monhoc", "view")) {
            $this->view("main_layout", [
                "Page" => "faculty",
                "Title" => "Quản lý khoa",
                "Script" => "faculty",
                "Plugin" => [
                    "sweetalert2" => 1,
                    "jquery-validate" => 1,
                    "pagination" => [],
                    "notify" => 1,
                ]
            ]);
        } else $this->view("single_layout", ["Page" => "error/page_403", "Title" => "Lỗi !"]);
    }

    public function add()
    {
        $makhoa = $_POST['makhoa'];
        $tenkhoa = $_POST['tenkhoa'];
        $result = $this->khoaModel->create($makhoa, $tenkhoa);
        echo $result;
    }

    public function checkFaculty()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $makhoa = $_POST['makhoa'];
            $result = $this->khoaModel->checkFaculty($makhoa);
            echo json_encode($result);
        }
    }

    public function checkFacultyName()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $tenlop = $_POST['tenlop'];
            $result = $this->lopModel->checkFacultyName($tenlop);
            echo json_encode($result);
        }
    }

    public function update()
    {
        $id = $_POST['id'];
        $makhoa = $_POST['makhoa'];
        $tenkhoa = $_POST['tenkhoa'];
        $result = $this->khoaModel->update($id, $makhoa, $tenkhoa);
        echo $result;
    }

    public function delete()
    {
        $makhoa = $_POST['makhoa'];
        $result = $this->khoaModel->delete($makhoa);
        echo $result;
    }

    public function getAll_Class()
    {
        $result = $this->lopModel->getAllClass();
        echo json_encode($result);
    }

    // public function getSubjectAssignment()
    // {
    //     $id = $_SESSION['user_id'];
    //     $data = $this->khoaModel->getAllSubjectAssignment($id);
    //     echo json_encode($data);
    // }

    public function getDetail()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data = $this->khoaModel->getById($_POST['makhoa']);
            echo json_encode($data);
        }
        echo false;
    }

    // //Chapter
    public function getAllClass()
    {
        $result = $this->lopModel->getAll($_POST['makhoa']);
        echo json_encode($result);
    }

    public function classDelete()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $result = $this->lopModel->delete($_POST['malop']);
            echo $result;
        }
    }

    public function addClass()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $result = $this->lopModel->insert($_POST['makhoa'], $_POST['tenkhoa']);
            echo $result;
        }
    }

    public function updateClass()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $result = $this->lopModel->update($_POST['malop'], $_POST['tenlop']);
            echo $result;
        }
    }

    public function search()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $result = $this->khoaModel->search($_POST['input']);
            echo json_encode($result);
        }
    }

    public function getQuery($filter, $input, $args)
    {
        $result = $this->khoaModel->getQuery($filter, $input, $args);
        return $result;
    }

    public function getAllSubject()
    {
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $result = $this->khoaModel->getAll();
            echo json_encode($result);
        }
    }
}
