<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Esempio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    <div class="container">
        <h1>Pagina d'esempio</h1>
<?php
try {
    $db=new PDO('mysql:dbname=test_users;charset=utf8','script','tpircs');
    $u=substr($_SERVER['REMOTE_USER'],7);
    $r=$db->query('SELECT * FROM users WHERE name='.$db->quote($u));
    $row=$r->fetch(PDO::FETCH_NUM);
    if ($r->rowCount()==0) {
    die('<p class="alert alert-danger">Non sei autorizzato!</p>');
} else {
    echo "<p>Benvenuto <i>{$row[0]}</i>, il tuo ruolo è <i>$row[1]</i></p>\n";
}
} catch (PDOException $e) {
    die('<p>Errore SQL: '.$e->getMessage()."</p>\n");
}
?>
        <p><a href="users.php" class="btn btn-primary">Gestione utenti</a></p>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>