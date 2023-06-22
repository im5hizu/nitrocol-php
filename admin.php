<?php
include_once('./connection/connection.php');
session_start();

if($_POST) {
    $ident = $_POST['username'];
    $postPw = $_POST['password'];

    $sql = "SELECT username, password FROM `users`
    WHERE username = :ident
    ";

    $sth = $dbh->prepare($sql);
    $sth->bindParam(':ident', $ident, PDO::PARAM_STR);
    $sth->execute();

    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    $result_nbr = $sth->rowCount();

    if(isset($result[0]['password'])){
        $hashedPw = $result[0]['password'];
    }else{
        $hashedPw = '';
    }
    
    if(empty($ident) || empty($postPw)) {
        $msg_error = "Merci de rentrer vos identifiants";
    } else {
        if(password_verify($postPw, $hashedPw)) {           
            $_SESSION['username'] = $_POST['username'];
            header('Location: index.php');
            exit;
        } elseif($result_nbr < 1) {
            $msg_error = "Identifiant ou mot de passe incorrect";
        }else {
            $msg_error = "Mot de passe incorrect";
        }
    }
}

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion | Nitrocol</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  </head>
  <body>
    <?php if(isset($msg_error)): ?>
        <h3 class="alert alert-danger"><?= $msg_error?></h3>
    <?php endif; ?>
    <form class="d-flex justify-content-end flex-wrap" style="width: 25rem" method="POST" action="<?= $_SERVER['PHP_SELF']?>">
        <div class='mt-4' style="width: 20rem">
            <label for="username">Nom d'utilisateur:</label>
            <input class="form-control" type="text" name="username" id="usernameInput">
        </div>
        <div class='mt-4' style="width: 20rem">
            <label for="password">Mot de passe:</label>
            <input type="password" name="password" id="passwordInput" class="form-control">
        </div>
        <input type="submit" value="Connexion" class='btn-light mt-4 form-control mt-0' style="width: 15rem">
    </form>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  </body>
</html>