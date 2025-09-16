<?php
include "../database.php";

extract($_GET);

$user = $conn->query("SELECT * FROM users WHERE id = '$id'")->fetch_assoc();


?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS Admin Panel</title>
    <link rel="stylesheet" href="style.css">
    <!-- Lucide Icons for modern look -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet"/>
</head>
<body>

<div style="display: flex;justify-content: center">
    <form id="student-form" class="side-modal-body" action="update.php" method="post">
        <input type="hidden" value="<?=$user['id']?>" name="id">
        <div class="form-group">
            <label for="student-name">Ism:</label>
            <input type="text" id="student-name" name="name" required value="<?=$user['name']?>">
        </div>
        <div class="form-group">
            <label for="student-phone">Telefon raqami:</label>
            <input type="tel" id="student-phone" name="mobile_numer" required value="<?=$user['mobile_numer']?>">
        </div>

        <div class="side-modal-footer">
            <button type="submit" class="primary-button" onclick="document.getElementById('student-form').submit();">Saqlash</button>
            <button type="button" class="secondary-button close-modal-btn" name="

" onclick="window.history.back()">Bekor qilish</button>
        </div>
    </form>
</div>

</body>
</html>
