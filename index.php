<?php
error_reporting(E_ALL);

$pdo = new PDO('mysql:host=localhost;dbname=global', 'kerimov', 'neto0990');
$pdo->exec("SET NAMES utf8");

$name = '';
$isbn = '';
$author = '';

if (!empty($_POST)){
  $name = $_POST['name'];
  $isbn = $_POST['isbn'];
  $author = $_POST['author'];
}

$sql = 'SELECT * FROM books WHERE isbn LIKE :isbn AND name LIKE :name AND author LIKE :author';
$statement = $pdo->prepare($sql);
$statement->execute([
  "isbn" => $isbn . '%',
  "name" => $name . '%',
  "author" => $author . '%'
]);

function bookOutput($array){
  foreach ($array as $row) {
    echo '<tr>';
    echo '<td>' . $row['name'] . '</td>';
    echo '<td>' . $row['author'] . '</td>';
    echo '<td>' . $row['year'] . '</td>';
    echo '<td>' . $row['genre'] . '</td>';
    echo '<td>' . $row['isbn'] . '</td>';
    echo '</tr>';
  }
}

?>

<!doctype html>
<html lang="ru">
<head>
  <title>Книги</title>
  <style>
    table, tr, th, td {
      padding: 5px;
      border: 1px solid black;
    }
    
    table {
      margin-top: 20px;
      border-collapse: collapse;
    }
    
    th {
      background-color: #eee;
    }
  </style>
</head>
<body>
  <form method="post">
    <input type="text" name="isbn" id="isbn" placeholder="ISBN" value="<?= $isbn ?>">
    <input type="text" name="name" id="book" placeholder="Название книги" value="<?= $name ?>">
    <input type="text" name="author" id="author" placeholder="Автор" value="<?= $author ?>">
    <button type="submit">Найти</button>
  </form>
  <table>
      <tr>
        <th>Название</th>
        <th>Автор</th>
        <th>Год выпуска</th>
        <th>Жанр</th>
        <th>ISBN</th>
      </tr>
    <?php
      if (!empty($stat)){
        bookOutput($stat);
      } else {
        bookOutput($statement);
      }
    ?>
  </table>
</body>
</html>