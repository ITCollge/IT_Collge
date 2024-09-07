<?php
include 'db.php';

// التحقق من وجود المفتاح 'action' في مصفوفة $_POST
$action = isset($_POST['action']) ? $_POST['action'] : '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // إدارة الأقسام العلمية
    if ($action == 'add_department') {
        $name = $_POST['department_name'];
        $description = $_POST['department_description'];

        $stmt = $conn->prepare("INSERT INTO departments (name, description) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $description);
        $stmt->execute();
        echo "<div class='alert alert-success'>تم إضافة القسم بنجاح.</div>";

    } elseif ($action == 'edit_department') {
        $id = $_POST['department_id'];
        $name = $_POST['department_name'];
        $description = $_POST['department_description'];

        $stmt = $conn->prepare("UPDATE departments SET name = ?, description = ? WHERE id = ?");
        $stmt->bind_param("ssi", $name, $description, $id);
        $stmt->execute();
        echo "<div class='alert alert-success'>تم تحديث القسم بنجاح.</div>";

    } elseif ($action == 'delete_department') {
        $id = $_POST['department_id'];

        $stmt = $conn->prepare("DELETE FROM departments WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        echo "<div class='alert alert-success'>تم مسح القسم بنجاح.</div>";
    }

    // إدارة الأخبار
    if ($action == 'add_news') {
        $news_title = $_POST['news_title'];
        $news_content = $_POST['news_content'];
        $page = $_POST['page'];

        if (!empty($news_title) && !empty($news_content)) {
            $stmt = $conn->prepare("INSERT INTO news (title, content, page) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $news_title, $news_content, $page);
            $stmt->execute();
            echo "<div class='alert alert-success'>تم إضافة الخبر بنجاح.</div>";
        } else {
            echo "<div class='alert alert-warning'>يرجى ملء جميع الحقول.</div>";
        }

    } elseif ($action == 'edit_news') {
        $news_id = $_POST['news_id'];
        $news_title = $_POST['news_title'];
        $news_content = $_POST['news_content'];
        $page = $_POST['page'];

        if (!empty($news_id) && !empty($news_title) && !empty($news_content)) {
            $stmt = $conn->prepare("UPDATE news SET title = ?, content = ?, page = ? WHERE id = ?");
            $stmt->bind_param("sssi", $news_title, $news_content, $page, $news_id);
            $stmt->execute();
            echo "<div class='alert alert-success'>تم تحديث الخبر بنجاح.</div>";
        } else {
            echo "<div class='alert alert-warning'>يرجى ملء جميع الحقول.</div>";
        }

    } elseif ($action == 'delete_news') {
        $news_id = $_POST['news_id'];

        $stmt = $conn->prepare("DELETE FROM news WHERE id = ?");
        $stmt->bind_param("i", $news_id);
        $stmt->execute();
        echo "<div class='alert alert-success'>تم مسح الخبر بنجاح.</div>";
    }

    // إدارة الدكاترة
    if ($action == 'add_teacher') {
        $teacher_name = $_POST['teacher_name'];
        $teacher_subject = $_POST['teacher_subject'];
        $teacher_department = $_POST['teacher_department'];

        if (!empty($teacher_name) && !empty($teacher_subject) && !empty($teacher_department)) {
            $stmt = $conn->prepare("INSERT INTO teachers (name, subject, department) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $teacher_name, $teacher_subject, $teacher_department);
            $stmt->execute();
            echo "<div class='alert alert-success'>تم إضافة الدكتور بنجاح.</div>";
        } else {
            echo "<div class='alert alert-warning'>يرجى ملء جميع الحقول.</div>";
        }

    } elseif ($action == 'delete_teacher') {
        $teacher_id = $_POST['teacher_id'];

        $stmt = $conn->prepare("DELETE FROM teachers WHERE id = ?");
        $stmt->bind_param("i", $teacher_id);
        $stmt->execute();
        echo "<div class='alert alert-success'>تم مسح الدكتور بنجاح.</div>";
    }


    // إدارة المواد
    if ($action == 'add_subject') {
        $subject_name = $_POST['subject_name'];
        $subject_units = $_POST['subject_units'];
        $subject_department = $_POST['subject_department'];

        if (!empty($subject_name) && !empty($subject_units) && !empty($subject_department)) {
            $stmt = $conn->prepare("INSERT INTO subjects (name, units, id) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $subject_name, $subject_units, $subject_department);
            echo "<div class='alert alert-success'>تم إضافة المادة بنجاح.</div>";
        } else {
            echo "<div class='alert alert-warning'>يرجى ملء جميع الحقول.</div>";
        }

    } elseif ($action == 'delete_subject') {
        $subject_id = $_POST['subject_id'];

        $stmt = $conn->prepare("DELETE FROM subjects WHERE id = ?");
        $stmt->bind_param("i", $subject_id);
        $stmt->execute();
        echo "<div class='alert alert-success'>تم مسح المادة بنجاح.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="ar">

    <meta charset="UTF-8">
    <title>لوحة التحكم - المسؤول</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
       *{
            direction: rtl;
            font-family: "Changa";
        }
     

        .navbar-brand{
            display: flex;
        }

        .logo-h1{
            font-size: 20px;
            margin-right: 20px;
            padding-top: 10px;
        }


    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
    <a class="navbar-brand" href="#">
            <img src="./3.png" alt="كلية تقنية المعلومات" height="50">
            <h1 class="logo-h1">كلية تقنية المعلومات</h1>

        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" href="index.php">الصفحة الرئيسية</a>
                </li>
        

                   
            </ul>
        </div>
    </div>
</nav>


    <div class="container mt-4">
        <h1>لوحة تحكم المسؤول</h1>

        <!-- إدارة الأقسام العلمية -->
        <div class="card mb-4">
            <div class="card-header">
                <h5>إدارة الأقسام العلمية</h5>
            </div>
            <div class="card-body">
                <!-- نموذج إضافة قسم جديد -->
                <form method="POST" action="">
                    <input type="hidden" name="action" value="add_department">
                    <div class="mb-3">
                        <label for="department_name" class="form-label">اسم القسم</label>
                        <input type="text" class="form-control" id="department_name" name="department_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="department_description" class="form-label">وصف القسم</label>
                        <textarea class="form-control" id="department_description" name="department_description" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">إضافة قسم</button>
                </form>

                <!-- نموذج تعديل الأقسام -->
                <?php
                $departments_result = $conn->query("SELECT * FROM departments");
                while ($department = $departments_result->fetch_assoc()) {
                ?>
                    <form method="POST" action="">
                        <input type="hidden" name="action" value="edit_department">
                        <input type="hidden" name="department_id" value="<?php echo $department['id']; ?>">
                        <div class="mb-3">
                            <label for="department_name_<?php echo $department['id']; ?>" class="form-label">اسم القسم</label>
                            <input type="text" class="form-control" id="department_name_<?php echo $department['id']; ?>" name="department_name" value="<?php echo htmlspecialchars($department['name']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="department_description_<?php echo $department['id']; ?>" class="form-label">وصف القسم</label>
                            <textarea class="form-control" id="department_description_<?php echo $department['id']; ?>" name="department_description" rows="4" required><?php echo htmlspecialchars($department['description']); ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-warning">تحديث القسم</button>
                        <button type="submit" name="action" value="delete_department" class="btn btn-danger">مسح القسم</button>
                    </form>
                    <hr>
                <?php
                }
                ?>
            </div>
        </div>

        <!-- إدارة الأخبار -->
        <div class="card mb-4">
            <div class="card-header">
                <h5>إدارة الأخبار</h5>
            </div>
            <div class="card-body">
                <!-- نموذج إضافة خبر جديد -->
                <form method="POST" action="">
                    <input type="hidden" name="action" value="add_news">
                    <div class="mb-3">
                        <label for="news_title" class="form-label">عنوان الخبر</label>
                        <input type="text" class="form-control" id="news_title" name="news_title" required>
                    </div>
                    <div class="mb-3">
                        <label for="news_content" class="form-label">محتوى الخبر</label>
                        <textarea class="form-control" id="news_content" name="news_content" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="page" class="form-label">الصفحة</label>
                        <input type="text" class="form-control" id="page" name="page" required>
                    </div>
                    <button type="submit" class="btn btn-success">إضافة خبر</button>
                </form>

                <!-- نموذج تعديل الأخبار -->
                <?php
                $news_result = $conn->query("SELECT * FROM news");
                while ($news = $news_result->fetch_assoc()) {
                ?>
                    <form method="POST" action="">
                        <input type="hidden" name="action" value="edit_news">
                        <input type="hidden" name="news_id" value="<?php echo $news['id']; ?>">
                        <div class="mb-3">
                            <label for="news_title_<?php echo $news['id']; ?>" class="form-label">عنوان الخبر</label>
                            <input type="text" class="form-control" id="news_title_<?php echo $news['id']; ?>" name="news_title" value="<?php echo htmlspecialchars($news['title']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="news_content_<?php echo $news['id']; ?>" class="form-label">محتوى الخبر</label>
                            <textarea class="form-control" id="news_content_<?php echo $news['id']; ?>" name="news_content" rows="4" required><?php echo htmlspecialchars($news['content']); ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="page_<?php echo $news['id']; ?>" class="form-label">الصفحة</label>
                            <input type="text" class="form-control" id="page_<?php echo $news['id']; ?>" name="page" value="<?php echo htmlspecialchars($news['page']); ?>" required>
                        </div>
                        <button type="submit" class="btn btn-warning">تحديث الخبر</button>
                        <button type="submit" name="action" value="delete_news" class="btn btn-danger">مسح الخبر</button>
                    </form>
                    <hr>
                <?php
                }
                ?>
            </div>
        </div>

        <!-- إدارة الدكاترة -->
        <div class="card mb-4">
            <div class="card-header">
                <h5>إدارة الدكاترة</h5>
            </div>
            <div class="card-body">
               <!-- نموذج إضافة دكتور جديد -->
<form method="POST" action="insert_teacher.php">
    <input type="hidden" name="action" value="add_teacher">
    <div class="mb-3">
        <label for="teacher_name" class="form-label">اسم الدكتور</label>
        <input type="text" class="form-control" id="teacher_name" name="teacher_name" required>
    </div>
    <div class="mb-3">
        <label for="teacher_subject" class="form-label">المادة</label>
        <input type="text" class="form-control" id="teacher_subject" name="teacher_subject" required>
    </div>
    <div class="mb-3">
        <label for="teacher_department" class="form-label">القسم</label>
        <select class="form-control" id="teacher_department" name="teacher_department" required>
            <?php
            // جلب الأقسام من قاعدة البيانات
            $departments_result = $conn->query("SELECT id, name FROM departments");
            while ($department = $departments_result->fetch_assoc()) {
                echo "<option value='" . $department['id'] . "'>" . htmlspecialchars($department['name']) . "</option>";
            }
            ?>
        </select>
    </div>
    <button type="submit" class="btn btn-success">إضافة دكتور</button>
</form>


                <!-- نموذج حذف الدكاترة -->
                <?php
                $teachers_result = $conn->query("SELECT * FROM teachers");
                while ($teacher = $teachers_result->fetch_assoc()) {
                ?>
                    <form method="POST" action="">
                        <input type="hidden" name="action" value="delete_teacher">
                        <input type="hidden" name="teacher_id" value="<?php echo $teacher['id']; ?>">
                        <div class="mb-3">
                            <label class="form-label">اسم الدكتور: <?php echo htmlspecialchars($teacher['name']); ?></label>
                        </div>
                        <button type="submit" class="btn btn-danger">مسح الدكتور</button>
                    </form>
                    <hr>
                <?php
                }
                ?>
            </div>
        </div>

        <!-- إدارة المواد -->
        <div class="card mb-4">
            <div class="card-header">
                <h5>إدارة المواد</h5>
            </div>
            <div class="card-body">
               <!-- نموذج إضافة مادة جديدة -->
<form method="POST" action="insert_subject.php">
    <input type="hidden" name="action" value="add_subject">
    <div class="mb-3">
        <label for="subject_name" class="form-label">اسم المادة</label>
        <input type="text" class="form-control" id="subject_name" name="subject_name" required>
    </div>
    <div class="mb-3">
        <label for="subject_units" class="form-label">عدد الوحدات</label>
        <input type="text" class="form-control" id="subject_units" name="subject_units" required>
    </div>
    <div class="mb-3">
        <label for="subject_department" class="form-label">القسم</label>
        <select class="form-control" id="subject_department" name="subject_department" required>
            <?php
            // جلب الأقسام من قاعدة البيانات
            $departments_result = $conn->query("SELECT * FROM departments");
            while ($department = $departments_result->fetch_assoc()) {
                echo "<option value='{$department['id']}'>{$department['name']}</option>";
            }
            ?>
        </select>
    </div>
    <button type="submit" class="btn btn-success">إضافة مادة</button>
</form>


                <!-- نموذج حذف المواد -->
                <?php
                $subjects_result = $conn->query("SELECT * FROM subjects");
                while ($subject = $subjects_result->fetch_assoc()) {
                ?>
                    <form method="POST" action="">
                        <input type="hidden" name="action" value="delete_subject">
                        <input type="hidden" name="subject_id" value="<?php echo $subject['id']; ?>">
                        <div class="mb-3">
                            <label class="form-label">اسم المادة: <?php echo htmlspecialchars($subject['name']); ?></label>
                        </div>
                        <button type="submit" class="btn btn-danger">مسح المادة</button>
                    </form>
                    <hr>
                <?php
                }
                ?>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html> 