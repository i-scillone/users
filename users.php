<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Utenti</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.min.js" integrity="sha256-AlTido85uXPlSyyaZNsjJXeCs07eSv3r43kyCVc8ChI=" crossorigin="anonymous"></script>
    <link href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css" rel="stylesheet">
    <script>
        $(function(){
            $('#userName').autocomplete({ source: 'ldap.php', minLength: 3 });
            $('#existing').on('submit',function(ev){
                var ok=false;
                $('.selUsers').each(function(index,element){
                    if (element.checked) {
                        ok=true;
                    }
                });
                if (!ok) {
                    alert('Non hai selezionato alcun utente!');
                    ev.preventDefault();
                }
            });
        });
    </script>
  </head>
  <body>
    <div class="container">
        <h1 class="text-center">Gestione utenti</h1>
<?php
const ROLES=<<<HTML
<select name="role">
    <option value="u">Utente</option>
    <option value="a">Amministratore</option>
</select>
HTML;
try {
    $db=new PDO('mysql:dbname=test_users;charset=utf8','script','tpircs');
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_NUM);
    if (isset($_POST['doIt'])) {
        switch ($_POST['doIt']) {
            case 'edit':
                $upd=$db->prepare('UPDATE users SET role=? WHERE name=?');
                foreach ($_POST['sel'] as $name) {
                    $upd->bindValue(1,$_POST['role'],PDO::PARAM_STR);
                    $upd->bindValue(2,$name,PDO::PARAM_STR);
                    $upd->execute();
                }
                break;
            case 'delete':
                foreach ($_POST['sel'] as $name) {
                    $db->exec('DELETE FROM users WHERE name='.$db->quote($name));
                }
                break;
            case 'new':
                $ins=$db->prepare('INSERT INTO users VALUES(?,?)');
                $ins->bindValue(1,$_POST['userName'],PDO::PARAM_STR);
                $ins->bindValue(2,$_POST['role'],PDO::PARAM_STR);
                $ins->execute();
            break;
        }
    }
} catch (PDOException $e) {
    die('<p>Errore SQL: '.$e->getMessage()."</p>\n");
}
?>
<form id="existing" method="post">
    <h2>Utenti attuali</h2>
    <table class="table bordered">
        <tr><th>Nome</th><th>Ruolo</th><th></th></tr>
<?php
$r=$db->query('SELECT * FROM users');
echo "";
foreach ($r as $row) {
    echo '<tr>';
    printf('<td>%s</td>',htmlspecialchars($row[0]));
    echo "<td>{$row[1]}</td>";
    printf(
        '<td><input name="sel[]" type="checkbox" value="%s" class="selUsers"></td>',
        htmlspecialchars($row[0])
    );
    echo "</tr>\n";
}
?>
    </table>
    <p>
        <?= ROLES ?>
        <button name="doIt" type="submit" value="edit" class="btn btn-primary">Cambia ruolo</button>
    </p>
    <p><button name="doIt" type="submit" value="delete" class="btn btn-primary">Cancella</button></p>
</form>
<form method="post">
    <h2>Nuovo utente</h2>
    <p>Nome: <input id="userName" name="userName" type="text"></p>
    <p>Ruolo: <?= ROLES ?></p>
    <p><button name="doIt" type="submit" value="new" class="btn btn-primary">Aggiungi</button></p>
</form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>