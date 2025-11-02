<!DOCTYPE html>
<html lang="vi">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Quản lý sinh viên - Trang chủ</title>
     <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
     <?php include 'View/components/header.phtml'; ?>
     
     <main class="main-content">
          <div class="container">
               <h1 class="page-title">THỰC HÀNH MVC - QUẢN LÝ SINH VIÊN</h1>
               <p class="page-subtitle">Chào mừng đến với hệ thống quản lý sinh viên</p>
               
               <div style="margin-top: 2rem;">
                    <h3 style="color: var(--navy-blue); margin-bottom: 1rem;">Các chức năng:</h3>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
                         <a href="Controller/C_Student.php" class="btn btn-primary" style="text-align: center; padding: 1rem;">
                              📋 Xem danh sách sinh viên
                         </a>
                         <a href="Controller/C_Student.php?mod1=1" class="btn btn-primary" style="text-align: center; padding: 1rem;">
                              ➕ Thêm sinh viên
                         </a>
                         <a href="Controller/C_Student.php?mod2=1" class="btn btn-primary" style="text-align: center; padding: 1rem;">
                              ✏️ Cập nhật sinh viên
                         </a>
                         <a href="Controller/C_Student.php?mod3=1" class="btn btn-primary" style="text-align: center; padding: 1rem;">
                              🗑️ Xóa sinh viên
                         </a>
                         <a href="Controller/C_Student.php?mod4=1" class="btn btn-primary" style="text-align: center; padding: 1rem;">
                              🔍 Tìm kiếm sinh viên
                         </a>
                    </div>
               </div>
          </div>
     </main>
     
     <?php include 'View/components/footer.phtml'; ?>
</body>
</html>