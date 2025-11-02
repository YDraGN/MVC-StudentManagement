<?php
include_once("E_Student.php");
class Model_Student {
     public function __construct() {}

     public function getAllStudent() {
          $link = mysqli_connect("localhost","root","","dulieu1") or die(mysqli_connect_error());

          $sql = "SELECT * FROM sinhvien";
          $rs = mysqli_query($link, $sql);
          
          $student = [];
          while($row = mysqli_fetch_assoc($rs)) {
               $id = $row['id'];
               $name = $row['name'];
               $age = $row['age'];
               $university = $row['university'];
               
               $student[$id] = new Entity_student($id, $name, $age, $university);
          }
          mysqli_free_result($rs);
          $link->close();
          return $student;
     } 
     
     public function getStudentDetail($id) {
          $allStudent = $this->getAllStudent();
          return isset($allStudent[$id]) ? $allStudent[$id] : null;
     }

     public function notifyError($type, $message) {
          if(!isset($_SESSION)) {
               session_start();
          }
          $_SESSION['error'] = [
               "type" => $type,
               "message" => $message
          ];
     }

     public function checkExist($id) {
          $link = mysqli_connect("localhost", "root", "", "dulieu1") or die(mysqli_connect_error());
          $sql = "SELECT * FROM sinhvien WHERE id = ?";
          $stmt = mysqli_prepare($link, $sql);
          if ($stmt === false) {
               self::notifyError("DATABASE", "Lỗi khi chuẩn bị câu lệnh SQL!");
               $link->close();
               return false;
          }
          mysqli_stmt_bind_param($stmt, "s", $id);
          mysqli_stmt_execute($stmt);
          mysqli_stmt_store_result($stmt);
          $num = mysqli_stmt_num_rows($stmt);
          mysqli_stmt_close($stmt);
          mysqli_close($link);
          return ($num > 0);
     }

     public function insertStudent($id, $name, $age, $university) {
          $link = mysqli_connect("localhost", "root", "", "dulieu1") or die(mysqli_connect_error());

          $id = trim($id) ?? '';
          $name = trim($name) ?? '';
          $age = trim($age) ?? '';
          $university = trim($university) ?? '';

          if (empty($id) || empty($name) || empty($age) || empty($university)) {
               self::notifyError("VALIDATION", "Vui lòng điền đầy đủ thông tin sinh viên!");
               $link->close();
               return false;
          }

          if (!is_numeric($age) || $age < 16 || $age > 150) {
               self::notifyError("VALIDATION", "Tuổi phải là số dương và không lớn hơn 150!");
               $link->close();
               return false;
          }

          if (self::checkExist($id)) {
               self::notifyError("DUPLICATE", "Mã số sinh viên này đã tồn tại!");
               $link->close();
               return false;
          }

          $sql = "INSERT INTO sinhvien VALUES (?, ?, ?, ?)";
          $stmt = mysqli_prepare($link, $sql);
          if ($stmt === false) {
               self::notifyError("DATABASE", "Lỗi khi chuẩn bị câu lệnh SQL!");
               $link->close();
               return false;
          }

          mysqli_stmt_bind_param($stmt, "ssss", $id, $name, $age, $university);
          if(!mysqli_stmt_execute($stmt)) {
               self::notifyError("DATABASE", "Lỗi khi thêm sinh viên vào cơ sở dữ liệu: " . mysqli_stmt_error($stmt));
               $link->close();
               return false;
          }

          $stmt->close();
          $link->close();
          return true;
     }

     public function updateStudent($id, $name, $age, $university) {
          $link = mysqli_connect("localhost", "root", "", "dulieu1") or die(mysqli_connect_error());

          $id = trim($id) ?? '';
          $name = trim($name) ?? '';
          $age = trim($age) ?? '';
          $university = trim($university) ?? '';

          if (empty($id) || empty($name) || empty($age) || empty($university)) {
               self::notifyError("VALIDATION", "Vui lòng điền đầy đủ thông tin sinh viên!");
               $link->close();
               return false;
          }

          if (!is_numeric($age) || $age < 16 || $age > 150) {
               self::notifyError("VALIDATION", "Tuổi phải là số dương và không lớn hơn 150!");
               $link->close();
               return false;
          }

          $query = "UPDATE sinhvien SET name = ?, age = ?, university = ? WHERE ID = ?";
          $stmt = mysqli_prepare($link, $query);

          if ($stmt === false) {
               self::notifyError("DATABASE", "Lỗi khi chuẩn bị câu lệnh SQL!");
               $link->close();
               return false;
          }

          mysqli_stmt_bind_param($stmt, "ssss", $name, $age, $university, $id);
          if(!mysqli_stmt_execute($stmt)) {
               self::notifyError("DATABASE", "Lỗi khi cập nhật thông tin sinh viên vào cơ sở dữ liệu: " . mysqli_stmt_error($stmt));
               $link->close();
               return false;
          }

          $stmt->close();
          $link->close();
          return true;
     }

     public function deleteStudent($id) {
          $link = mysqli_connect("localhost", "root", "", "dulieu1") or die(mysqli_connect_error());

          $id = trim($id ?? '');
          if (!self::checkExist($id)) {
               self::notifyError("NOT FOUND", "Không tìm thấy sinh viên có ID này!");
               $link->close();
               return false;
          }

          $query = "DELETE FROM sinhvien WHERE id = ?";
          $stmt = mysqli_prepare($link, $query);
          if ($stmt === false) {
               self::notifyError("DATABASE", "Lỗi khi chuẩn bị câu lệnh SQL!");
               $link->close();
               return false;
          }

          mysqli_stmt_bind_param($stmt, "s", $id);
          if(!mysqli_stmt_execute($stmt)) {
               self::notifyError("DATABASE", "Lỗi khi xóa sinh viên khỏi cơ sở dữ liệu: " . mysqli_stmt_error($stmt));
               $link->close();
               return false;
          }
          
          $stmt->close();
          $link->close();
          return true;
     }
     
     public function searchStudent($criteria, $searchValue) {
          $students = [];
          $link = mysqli_connect("localhost", "root", "", "dulieu1") or die(mysqli_connect_error());
          
          $criteria = trim($criteria ?? '');
          $searchValue = trim($searchValue ?? '');
          $validCriteria = ['id', 'name', 'age', 'university'];
          if (!in_array($criteria, $validCriteria)) {
               self::notifyError("INVALID CRITERIA", "Tiêu chí search không hợp lệ!");
               $link->close();
               return $students;
          }

          if (empty($searchValue)) {
               $likeValue = "%%"; 
          } else {
               $likeValue = "%" . $searchValue . "%";
          }

          $query = "SELECT * FROM sinhvien WHERE " . $criteria . " LIKE ?";
          $stmt = mysqli_prepare($link, $query);
          if ($stmt === false) {
               self::notifyError("DATABASE", "Lỗi khi chuẩn bị câu lệnh SQL!");
               $link->close();
               return $students;
          }

          mysqli_stmt_bind_param($stmt, "s", $likeValue);
          if(!mysqli_stmt_execute($stmt)) {
               self::notifyError("DATABASE", "Lỗi khi tìm kiếm sinh viên: " . mysqli_stmt_error($stmt));
               $link->close();
               return $students;
          }

          $result = mysqli_stmt_get_result($stmt);
    
          if ($result) {
               while($row = mysqli_fetch_assoc($result)) {
                    $id = $row['id'];
                    $name = $row['name'];
                    $age = $row['age'];
                    $university = $row['university'];
                    $students[$id] = new Entity_student($id, $name, $age, $university);
               }
               mysqli_free_result($result);
               
               if (empty($students)) {
            self::notifyError("NOT FOUND", "Không tìm thấy sinh viên phù hợp với tiêu chí tìm kiếm!");
        }
          }

          $stmt->close();
          $link->close();
          return $students;
     }
}
?>