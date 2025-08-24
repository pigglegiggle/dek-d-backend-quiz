<?php 
include_once 'db_conn.php';

$sql = "SELECT * FROM blogs";
$stmt = $conn->query($sql);
$blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="alertBox">
        <div class='alert'></div>
    </div>
    <div id="wrapper">
        <div id="blogForm">
            <h2>เพิ่มกระทู้ใหม่</h2>
            <form action="add-blog.php" method="POST">
                <input type="text" name="title" id="title" placeholder="หัวข้อกระทู้" required><br>    
                <textarea name="content" id="content"></textarea><br>
                <button id="addBlogBtn" type="submit">สร้างกระทู้</button>
            </form>
        </div>
        <div id="recentBlogs">
            <h2>กระทู้ที่ตั้งไป</h2>
            <?php
                if ($blogs) {
                    foreach ($blogs as $blog) {
                        echo '<div class="blogs">'.
                                '<h3>'.$blog['title'].'</h3>'.
                                '<p>'.$blog['content'].'</p>'.
                            '</div>';
                    }
                }
            ?>
        </div>
    </div>
    <script>
        const form = document.querySelector('form');
        const alert = document.querySelector('.alert');

        function containsHTML(str) {
            const div = document.createElement('div');
            div.innerHTML = str;
            return div.children.length > 0;
        }

        function validateHTML() {
            const title = document.getElementById('title').value.trim();
            const content = document.getElementById('content').value.trim();

            const showError = (msg) => {
                alert.innerHTML = `<div id="alertFail">${msg}</div>`;
                alert.style.display = 'block';
                setTimeout(() => alert.style.display = 'none', 2000);
            };


            if (containsHTML(title) || containsHTML(content)) {
                showError('กรุณาอย่าใส่ HTML ในช่องกรอกข้อมูล');
                return false;
            }

            return true;
        }

        function validateForm() {
            const title = document.getElementById('title').value.trim();
            const content = document.getElementById('content').value.trim();

            const showError = (msg) => {
                alert.innerHTML = `<div id="alertFail">${msg}</div>`;
                alert.style.display = 'block';
                setTimeout(() => alert.style.display = 'none', 2000);
            };


            if (!title || !content) {
                showError('กรุณากรอกข้อมูลให้ครบถ้วน');
                return false;
            }

            if (title.length < 4 || title.length > 140 || content.length < 6 || content.length > 2000) {
                showError('กรุณากรอกข้อมูลให้ถูกต้อง');
                return false;
            }

            return true;
        }


        form.addEventListener('submit', function(e) {
            e.preventDefault();

            if (!validateForm() || !validateHTML()) return;

            const formData = new FormData(form);

            fetch('add-blog.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(response => {
                if (response.status === 'success') {
                alert.innerHTML = '<div id="alertSuccess">'+response.message+'</div>';
                alert.style.display = 'block';
                setTimeout(() => {
                    alert.style.display = 'none';
                    location.reload();
                }, 2000);
            } else {
                alert.innerHTML = '<div id="alertError">'+response.message+'</div>';
                alert.style.display = 'block';
                setTimeout(() => {
                    alert.style.display = 'none';
                }, 2000);
            }
            })
        })
    </script>
</body>
</html>