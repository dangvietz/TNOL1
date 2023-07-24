<?php
class NguoiDungModel extends DB
{

    public function create($id, $email, $fullname, $password, $ngaysinh, $gioitinh, $role, $trangthai, $lop)
    {
        if($role != 11) $lop=NULL;
        $password = password_hash($password, PASSWORD_DEFAULT);
        if($role != 11) {
            $sql = "INSERT INTO `nguoidung`(`id`, `email`,`hoten`, `gioitinh`,`ngaysinh`,`matkhau`,`trangthai`, `manhomquyen`, `malop`) VALUES ('$id','$email','$fullname','$gioitinh','$ngaysinh','$password','$trangthai', '$role', NULL)";
        } else {
            $sql = "INSERT INTO `nguoidung`(`id`, `email`,`hoten`, `gioitinh`,`ngaysinh`,`matkhau`,`trangthai`, `manhomquyen`, `malop`) VALUES ('$id','$email','$fullname','$gioitinh','$ngaysinh','$password','$trangthai', '$role','$lop')";
        }
        $check = true;
        $result = mysqli_query($this->con, $sql);
        if (!$result) {
            $check = false;
        }
        return $check;
    }

    public function delete($id)
    {
        $check = true;
        $sql = "DELETE FROM `nguoidung` WHERE `id`='$id'";
        $result = mysqli_query($this->con, $sql);
        if (!$result) $check = false;
        return $check;
    }

    public function update($id, $email, $fullname, $password, $ngaysinh, $gioitinh, $role, $trangthai, $lop)
    {
        $querypass = '';
        if ($password != '') {
            $passwordd = password_hash($password, PASSWORD_DEFAULT);
            $querypass = ", `matkhau`='$passwordd'";
        }
        $sql = "UPDATE `nguoidung` SET `email`='$email', `hoten`='$fullname',`gioitinh`='$gioitinh',`ngaysinh`='$ngaysinh',`trangthai`='$trangthai',`manhomquyen`='$role', `malop`='$lop' $querypass WHERE `id`='$id'";
        $check = true;
        $result = mysqli_query($this->con, $sql);
        if (!$result) $check = false;
        return $check;
    }

    // Update Profile
    public function updateProfile($fullname, $gioitinh, $ngaysinh, $email, $id)
    {
        $sql = "UPDATE `nguoidung` SET `email` = '$email',`hoten`='$fullname',`gioitinh`='$gioitinh',`ngaysinh`='$ngaysinh'WHERE `id`='$id'";
        $check = true;
        $result = mysqli_query($this->con, $sql);
        if (!$result) $check = false;
        return $check;
    }

    // Up avatar
    public function uploadFile($id, $tmpName, $imageExtension, $validImageExtension, $name)
    {
        $check = true;

        if (!in_array($imageExtension, $validImageExtension)) {
            $check = false;
        } else {
            $newImageName = $name . "-" . uniqid(); // Generate new name image
            $newImageName .= '.' . $imageExtension;

            move_uploaded_file($tmpName, './public/media/avatars/' . $newImageName);
            $sql = "UPDATE `nguoidung` SET `avatar`='$newImageName' WHERE `id`='$id'";
            mysqli_query($this->con, $sql);
            $check = true;
        }
        return $check;
    }


    public function getAll()
    {
        $sql = "SELECT nguoidung.*, nhomquyen.`tennhomquyen`, lop.`tenlop`
        FROM nguoidung, nhomquyen, lop
        WHERE nguoidung.`manhomquyen` = nhomquyen.`manhomquyen` AND nguoidung.`malop` = lop.`malop`";
        $result = mysqli_query($this->con, $sql);
        $rows = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function getById($id)
    {
        $sql = "SELECT * FROM `nguoidung` WHERE `id` = '$id'";
        $result = mysqli_query($this->con, $sql);
        return mysqli_fetch_assoc($result);
    }

    public function getByEmail($email)
    {
        $sql = "SELECT email,otp FROM `nguoidung` WHERE `email` = '$email'";
        $result = mysqli_query($this->con, $sql);
        if ($result) {
            $_SESSION['checkMail'] = $email;
            return mysqli_fetch_assoc($result);
        } else {
            return false;
        }
    }

    public function checkOpt($email, $opt)
    {
        $sql = "SELECT email,otp FROM `nguoidung` WHERE `email` = '$email' AND `otp` = '$opt'";
        $result = mysqli_query($this->con, $sql);
        return $result->num_rows;
    }


    public function changePassword($email, $new_password)
    {
        $new_password = password_hash($new_password, PASSWORD_DEFAULT);
        $sql = "UPDATE `nguoidung` SET `matkhau`='$new_password' WHERE `email` = '$email'";
        $check = true;
        $result = mysqli_query($this->con, $sql);
        if (!$result) $check = false;
        return $check;
    }

    public function checkPassword($masv, $password)
    {
        $user = $this->getById($masv);
        $result = password_verify($password, $user['matkhau']);
        return $result;
    }

    public function checkLogin($masv, $password)
    {
        $user = $this->getById($masv);
        if ($user == '') {
            return json_encode(["message" => "Tài khoản không tồn tại !", "valid" => "false"]);
        } else if ($user['trangthai'] == 0) {
            return json_encode(["message" => "Tài khoản bị khóa !", "valid" => "false"]);
        } else {
            $result = password_verify($password, $user['matkhau']);
            if ($result) {
                $token = time() . password_hash($masv, PASSWORD_DEFAULT);
                $resultToken = $this->updateToken($masv, $token);
                if ($resultToken) {
                    setcookie("token", $token, time() + 7 * 24 * 3600, "/");
                    return json_encode(["message" => "Đăng nhập thành công !", "valid" => "true"]);
                } else {
                    return json_encode(["message" => "Đăng nhập không thành công !", "valid" => "false"]);
                }
            } else {
                return json_encode(["message" => "Sai mật khẩu !", "valid" => "false"]);
            }
        }
    }

    public function updateToken($masv, $token)
    {
        $valid = true;
        $sql = "UPDATE `nguoidung` SET `token`='$token' WHERE `id` = '$masv'";
        $result = mysqli_query($this->con, $sql);
        if (!$result) $valid = false;
        return $valid;
    }

    public function validateToken($token)
    {
        $sql = "SELECT * FROM `nguoidung` WHERE `token` = '$token'";
        $result = mysqli_query($this->con, $sql);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_email'] = $row['email'];
            $_SESSION['user_name'] = $row['hoten'];
            $_SESSION['avatar'] = $row['avatar'];
            $_SESSION['user_role'] = $this->getRole($row['manhomquyen']);
            return true;
        }
        return false;
    }

    public function getRole($manhomquyen)
    {
        $sql = "SELECT chucnang, hanhdong FROM chitietquyen WHERE manhomquyen = $manhomquyen";
        $result = mysqli_query($this->con, $sql);
        $rows = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        $roles = array();
        foreach ($rows as $item) {
            $chucnang = $item['chucnang'];
            $hanhdong = $item['hanhdong'];
            if (!isset($roles[$chucnang])) {
                $roles[$chucnang] = array($hanhdong);
            } else {
                array_push($roles[$chucnang], $hanhdong);
            }
        }
        return $roles;
    }

    public function logout()
    {
        setcookie("token", "", time() - 10, '/');
        $id = $_SESSION['user_id'];
        $sql = "UPDATE `nguoidung` SET `token`= NULL WHERE `id` = '$id'";
        session_destroy();
        $result = mysqli_query($this->con, $sql);
        return $result;
    }

    public function updateOpt($email, $otp)
    {
        $sql = "UPDATE `nguoidung` SET `otp`= $otp WHERE `email`='$email'";
        $result = mysqli_query($this->con, $sql);
        return $result;
    }

    function addFile($data, $pass)
    {
        $check = true;
        foreach ($data as $user) {
            $fullname = $user['fullname'];
            $email = $user['email'];
            $mssv = $user['mssv'];
            $password = password_hash($pass, PASSWORD_DEFAULT);
            $trangthai = $user['trangthai'];
            $nhomquyen = $user['nhomquyen'];
            $malop = $user['lop'];
            $sql = "INSERT INTO `nguoidung`(`id`,`email`, `hoten`, `matkhau`, `trangthai`, `manhomquyen`,`malop`) VALUES ('$mssv','$email','$fullname','$password','$trangthai','$nhomquyen','$malop')";
            $result = mysqli_query($this->con, $sql);
            if ($result) {
            } else {
                $check = false;
            }
        }
        return $check;
    }

    function addFileGroup($data, $pass, $group)
    {
        $check = true;
        foreach ($data as $user) {
            $fullname = $user['fullname'];
            $email = $user['email'];
            $mssv = $user['mssv'];
            $password = password_hash($pass, PASSWORD_DEFAULT);
            $trangthai = $user['trangthai'];
            $nhomquyen = $user['nhomquyen'];
            $sql = "INSERT INTO `nguoidung`(`id`,`email`, `hoten`, `matkhau`, `trangthai`, `manhomquyen`) VALUES ('$mssv','$email','$fullname','$password','$trangthai','$nhomquyen')";
            $result = mysqli_query($this->con, $sql);
            $joinGroup = $this->join($group, $mssv);
            if ($result) {
            } else {
                $check = false;
            }
        }
        return $check;
    }

    public function join($manhom, $manguoidung)
    {
        $valid = true;
        $sql = "INSERT INTO `chitietnhom`(`manhom`, `manguoidung`) VALUES ('$manhom','$manguoidung')";
        $result = mysqli_query($this->con, $sql);
        $this->updateSiso($manhom);
        if (!$result) {
            $valid = false;
        } else {
            $this->updateSiso($manhom);
        }
        return $valid;
    }

    public function updateSiso($manhom)
    {
        $valid = true;
        $sql = "UPDATE `nhom` SET `siso`= (SELECT count(*) FROM `chitietnhom` where manhom = $manhom ) WHERE `manhom` = $manhom";
        $result = mysqli_query($this->con, $sql);
        if (!$result) {
            $valid = false;
        }
        return $valid;
    }

    public function getQuery($filter, $input, $args)
    {
        $query = "SELECT ND.*, NQ.tennhomquyen, L.tenlop 
        FROM nguoidung ND
        LEFT JOIN nhomquyen NQ ON ND.manhomquyen = NQ.manhomquyen
        LEFT JOIN lop L ON ND.malop = L.malop WHERE ND.manhomquyen = NQ.manhomquyen";
        if (isset($filter['role'])) {
            $query .= " AND ND.manhomquyen = " . $filter['role'];
        }
        if ($input) {
            $query = $query . " AND (ND.hoten LIKE N'%${input}%' OR ND.id LIKE '%${input}%')";
        }
        $query = $query . " ORDER BY id ASC";
        return $query;
    }

    public function checkUser($mssv, $email)
    {
        $sql = "SELECT * FROM `nguoidung` WHERE `id` = '$mssv' OR `email` = '$email'";
        $result = mysqli_query($this->con, $sql);
        $rows = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function checkEmail($id)
    {
        $sql = "SELECT * FROM nguoidung where id = '$id'";
        $result = mysqli_query($this->con, $sql);
        $data = mysqli_fetch_assoc($result);
        return $data['email'];
    }

    public function checkEmailExist($email)
    {
        $sql = "SELECT * FROM nguoidung where email = '$email'";
        $result = mysqli_query($this->con, $sql);
        $row = $result->num_rows;
        return $row;
    }

    public function updateEmail($id, $email)
    {
        $sql = "UPDATE `nguoidung` SET `email`='$email' WHERE `id`='$id'";
        $result = mysqli_query($this->con, $sql);
        return $result;
    }

    public function getAllRoles()
    {
        $sql = "SELECT * FROM nhomquyen WHERE trangthai = 1";
        $result = mysqli_query($this->con, $sql);
        $rows = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }
}
