<?php
class LopModel extends DB
{
    public function getAll($makhoa)
    {
        $sql = "SELECT * FROM `lop` WHERE makhoa = '$makhoa' AND `trangthai` = 1";
        $result = mysqli_query($this->con, $sql);
        $rows = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function insert($makhoa, $tenlop)
    {
        $valid = true;
        $sql = "INSERT INTO `lop`(`makhoa`,`tenlop`,`trangthai`) VALUES ('$makhoa','$tenlop',1)";
        $result = mysqli_query($this->con, $sql);
        if (!$result) $valid = false;
        return $valid;
    }

    public function delete($malop)
    {
        $valid = true;
        $sql = "UPDATE `lop` SET `trangthai`= 0 WHERE `malop` = '$malop'";
        $result = mysqli_query($this->con, $sql);
        if (!$result) $valid = false;
        return $valid;
    }

    public function update($malop, $tenlop)
    {
        $valid = true;
        $sql = "UPDATE `lop` SET `tenlop`='$tenlop' WHERE `malop` = '$malop'";
        $result = mysqli_query($this->con, $sql);
        if (!$result) $valid = false;
        return $valid;
    }

    public function checkFacultyName($makhoa)
    {
        $sql = "SELECT * FROM `lop` WHERE `tenlop` = $makhoa";
        $result = mysqli_query($this->con, $sql);
        $rows = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function getAllClass()
    {
        $sql = "SELECT * FROM `lop` WHERE trangthai = 1";
        $result = mysqli_query($this->con, $sql);
        $rows = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }
}
