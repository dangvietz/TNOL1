<?php
class KhoaModel extends DB
{
    public function create($makhoa, $tenkhoa)
    {
        $valid = true;
        $sql = "INSERT INTO `khoa`(`makhoa`, `tenkhoa`) VALUES ('$makhoa','$tenkhoa')";
        $result = mysqli_query($this->con, $sql);
        if (!$result) $valid = false;
        echo $valid;
    }

    public function update($id, $makhoa, $tenkhoa)
    {
        $valid = true;
        $sql = "UPDATE `khoa` SET `makhoa`='$makhoa',`tenkhoa`='$tenkhoa' WHERE `makhoa`='$id'";
        $result = mysqli_query($this->con, $sql);
        if (!$result) $valid = false;
        return $valid;
    }

    public function delete($makhoa)
    {
        $valid = true;
        $sql = "UPDATE `khoa` SET `trangthai`= 0 WHERE `makhoa`='$makhoa'";
        $result = mysqli_query($this->con, $sql);
        if (!$result) $valid = false;
        return $valid;
    }

    public function getAll()
    {
        $sql = "SELECT * FROM `khoa` WHERE `trangthai` = 1";
        $result = mysqli_query($this->con, $sql);
        $rows = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function getById($id)
    {
        $sql = "SELECT * FROM `khoa` WHERE `makhoa` = '$id'";
        $result = mysqli_query($this->con, $sql);
        return mysqli_fetch_assoc($result);
    }

    public function search($input)
    {
        $sql = "SELECT * FROM `khoa` WHERE `makhoa` LIKE '%$input%' OR `tenkhoa` LIKE N'%$input%';";
        $result = mysqli_query($this->con, $sql);
        $rows = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function getAllFaculty($userid)
    {
        $sql = "SELECT khoa.* FROM phancong, khoa WHERE manguoidung = '$userid' AND khoa.makhoa = phancong.makhoa AND khoa.trangthai = 1";
        $result = mysqli_query($this->con, $sql);
        $rows = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function getQuery($filter, $input, $args)
    {
        $query = "SELECT * FROM `khoa` WHERE `trangthai` = 1";
        if ($input) {
            $query = $query . " AND (`khoa`.`tenkhoa` LIKE N'%${input}%' OR `khoa`.`makhoa` LIKE '%${input}%')";
        }
        return $query;
    }

    public function checkFaculty($makhoa)
    {
        $sql = "SELECT * FROM `khoa` WHERE `makhoa` = $makhoa";
        $result = mysqli_query($this->con, $sql);
        $rows = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }
}
