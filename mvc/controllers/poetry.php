<?php
require_once 'vendor/autoload.php';
require_once 'vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php';
use Dompdf\Dompdf;
use Sabberworm\CSS\Value\Size;

class Poetry extends Controller
{

    public $dethimodel;
    public $chitietde;
    public $ketquamodel;

    public function __construct()
    {
        $this->dethimodel = $this->model("DeThiModel");
        $this->chitietde = $this->model("ChiTietDeThiModel");
        $this->ketquamodel = $this->model("KetQuaModel");
        parent::__construct();
        require_once "./mvc/core/Pagination.php";
    }

    public function default()
    {
        if (AuthCore::checkPermission("dethi", "view")) {
            $this->view("main_layout", [
                "Page" => "poetry",
                "Title" => "Đề kiểm tra",
                "Plugin" => [
                    "notify" => 1,
                    "select" => 1,
                    "sweetalert2" => 1,
                    "datepicker" => 1,
                    "flatpickr" => 1,
                    "jquery-validate" => 1,
                    // "pagination" => [],
                ],
                "Script" => "poetry",
                "user_id" => $_SESSION['user_id'],
            ]);
        } else {
            $this->view("single_layout", ["Page" => "error/page_403", "Title" => "Lỗi !"]);
        }
    }

    public function getAllTest(){
        $result = $this->dethimodel->getAllTest();
        echo json_encode($result);
    }

    public function getPoetryAll(){
        $query = $_POST['query'];
        $filter = $_POST['filter'];
        $result = $this->dethimodel->getPoetryAll($query,$filter);
        echo json_encode($result);
    }

    public function getPoetryDetail(){
        $cathi = $_POST['cathi'];
        $result = $this->dethimodel->getPoetryDetail($cathi);
        echo json_encode($result);
    }

    public function addPoetry(){
        $tencathi = $_POST['tencathi'];
        $dethi = $_POST['dethi'];
        $cathi = $_POST['cathi'];
        $ngaythi = $_POST['ngaythi'];
        $loaide = $_POST['loaide'];
        $thoigian = $_POST['thoigian'];
        $result = $this->dethimodel->createPoetry($tencathi,$dethi,$cathi,$ngaythi,$loaide,$thoigian);
        echo $result;
    }

    public function updatePoetry(){
        $macathi = $_POST['macathi'];
        $tencathi = $_POST['tencathi'];
        $dethi = $_POST['dethi'];
        $cathi = $_POST['cathi'];
        $ngaythi = $_POST['ngaythi'];
        $loaide = $_POST['loaide'];
        $thoigian = $_POST['thoigian'];
        $result = $this->dethimodel->updatePoetry($macathi,$tencathi,$dethi,$cathi,$ngaythi,$loaide,$thoigian);
        echo $result;
    }

    public function delete(){
        $cathi = $_POST['cathi'];
        $result = $this->dethimodel->deletePoetry($cathi);
        echo $result;
    }
}