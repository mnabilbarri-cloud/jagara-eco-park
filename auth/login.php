<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Admin - Jagara Eco Park</title>
    <link rel="stylesheet" href="../assets/login.css">
</head>
<body>
     <div class="login-box">
         <h2>Login Admin</h2>
             <form action="proses_login.php" method="post">
                 <label>Username</label>
                     <input type="text" name="username" required>
                 <label>Password</label>
           <input type="password" name="password" required>
        <button type="submit">Masuk</button>
   </form>
 
    <div class="back-home">
         <a href="../index.php" class="btn-back">
             ← Kembali ke Website
    </a>
</div>

    <div class="login-footer">
        Jagara Eco Park © <?= date('Y') ?>
       </div>
    </div>
    </body>
</html>
