<?php
include_once("../Model/M_Student.php");
class Ctrl_Student {
     public function invoke() {
          if(!isset($_SESSION)) {
               session_start();
          }

          if(isset($_GET['id'])) {
               if($_GET['action'] == 1) {
                    $modelStudent = new Model_Student();
                    $student = $modelStudent->getStudentDetail($_GET['id']);
                    include_once("../View/StudentDetail.phtml");   
               } else if($_GET['action'] == 2) {
                    $modelStudent = new Model_Student();
                    $student = $modelStudent->getStudentDetail(($_GET['id']));
                    include_once("../View/UpdateStudent.phtml"); 
               } else if($_GET['action'] == 3) {
                    $modelStudent = new Model_Student();

                    if ($modelStudent->deleteStudent($_GET['id'])) {
                         $_SESSION['delete_status'] = 'success';
                    } else {
                         $_SESSION['delete_status'] = 'error';
                    }

                    $studentList = $modelStudent->getAllStudent();
                    include_once("../View/StudentList.phtml");
               }
          } 
          else if(isset($_GET['mod1'])) {
               unset($_SESSION['insert_status']);
               unset($_SESSION['error']);
               include_once("../View/InsertStudent.phtml");
          } 
          else if(isset($_GET['mod4'])) {
               include_once("../View/SearchStudent.phtml");
          } 
          else if(isset($_POST['criteria']) && isset($_POST['searchValue'])) {
               $criteria = $_POST['criteria'];
               $searchValue = $_POST['searchValue'];

               $modelStudent = new Model_Student();
               $students = $modelStudent->searchStudent($criteria, $searchValue);

               if(empty($students)) {
                    $_SESSION['search_status'] = 'error';
               } else {
                    $_SESSION['search_status'] = 'success';
               }

               include_once("../View/SearchStudent.phtml");
          }
          else if(isset($_POST['insert'])) {
               $id = $_REQUEST['id'];
               $name = $_REQUEST['name'];
               $age = $_REQUEST['age'];
               $university = $_REQUEST['university'];
               $modelStudent = new Model_Student();

               if($modelStudent->insertStudent($id, $name, $age, $university)) {
                    $_SESSION['insert_status'] = 'success';
               } else {
                    $_SESSION['insert_status'] = 'error';
               }
               include_once("../View/InsertStudent.phtml");
          }
          else if(isset($_POST['update'])) {
               $id = $_REQUEST['id'];
               $name = $_REQUEST['name'];
               $age = $_REQUEST['age'];
               $university = $_REQUEST['university'];
               $modelStudent = new Model_Student();
               $student = $modelStudent->getStudentDetail($id);

               if($modelStudent->updateStudent($id, $name, $age, $university)) {
                    $_SESSION['update_status'] = 'success';
               } else {
                    $_SESSION['update_status'] = 'error';
               }
               include_once("../View/UpdateStudent.phtml");
          }
          else {
               $modelStudent = new Model_Student();
               $studentList = $modelStudent->getAllStudent();
               include_once("../View/StudentList.phtml");
          } 
          
     }
};
$C_Student = new Ctrl_Student();
$C_Student->invoke();
?>