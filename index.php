<?php 
session_start();
ob_start();

include_once('./config/config.php');
include_once './classes/create.php';
include_once './classes/read.php';
include_once './classes/update.php';
include_once './classes/delete.php';
include_once './classes/userClass.php';

$currentUser = $_SESSION['username'];

if(empty($currentUser)){
    header('Location: admin.php');
}


$database = new Database();
$db = $database->getConnection();

$create = new Create($db);
$readSetUser = new readSetUser($db);
$read = new Read($db);
$delete = new Delete($db);
$update = new Update($db);

$stmt = $readSetUser->readSetUserData($currentUser);
$currentUserData = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $read->readData();
$existingUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nitrocol | Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  </head>
  <body>
    <h1 class="m-4">Bienvenue <?= $currentUser ?></h1>
        <div class="m-4">
            <h2>Votre profil:</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom d'utilisateur</th>
                        <th>Prénom</th>
                        <th>Nom</th>
                        <th>Image</th>
                        <th>Rôle</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php foreach($currentUserData as $key => $value): ?>
                            <?php if($key !== 'password' && $key !== 'img'): ?>
                                <td><?= $value ?></td>
                            <?php elseif($key == 'img'):?>
                                <td style='width: 250px; height: 150px'><img class='img-thumbnail' style='width: 250px; height: 150px' src="<?= $value ?>"></td>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="m-4">
            <h2>Utilisateurs existants:</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom d'utilisateur</th>
                        <th>Prénom</th>
                        <th>Nom</th>
                        <th>Image</th>
                        <th>Rôle</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($existingUsers as $existingUser): ?>
                        <tr>
                            <?php foreach($existingUser as $key => $value): ?>
                                <?php if($key !== 'password' && $key !== 'img'): ?>
                                    <td><?= $value ?></td>
                                <?php elseif($key == 'img'):?>
                                    <td style='width: 250px; height: 150px'><img class='img-thumbnail' style='width: 250px; height: 150px' src="<?= $value ?>"></td>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  </body>
</html>