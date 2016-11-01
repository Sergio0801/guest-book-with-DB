<?php
$page = $_GET['page'];
if (($page < 1) or ($page == "")) {
    $page = 1;
}
$begin = ($page - 1) * 5;
$link = mysqli_connect('localhost', 'root', '', 'guestbook');
$select = "SELECT m.*, a.timeLost, a.ip FROM message m JOIN antiflood a ON m.id=a.id ORDER BY a.timeLost DESC LIMIT $begin, 5";
$result = mysqli_query($link, $select);
while ($row = mysqli_fetch_array($result)) {
    echo "Id = {$row['id']} " . "Ip = {$row['ip']} " . "Дата получения: {$row['timeLost']} <br/>" . "Имя = {$row['name']} " . "Email =  {$row['email']} <br/>" . "Тема = {$row['topic']} " . "Сообщение = {$row['message']}" . "<br/><br/>";
}
$selCount = 'SELECT count(id) FROM antiflood';
$res = mysqli_query($link, $selCount);
$dbCount = mysqli_fetch_row($res);
$dbCount = intval($dbCount[0]);
$limit = 5;
$total = ($dbCount - 1) / $limit + 1;
mysqli_close($link);
if ($page > $total) {
    $page = $total;
}
if ($page != 1) {
    $pervpage = '<a href=admin.php?page=1><<</a> <a href=admin.php?page=' . ($page - 1) . '><</a> ';
}
// Проверяем нужны ли стрелки вперед
if ($page != $total) {
    $nextpage = ' <a href=admin.php?page=' . ($page + 1) . '>> </a> <a href=admin.php?page=' . $total . '>>></a>';
}
// Находим две ближайшие станицы с обоих краев
if ($page - 2 > 0) {
    $page2left = ' <a href=admin.php?page=' . ($page - 2) . '>' . ($page - 2) . '</a> | ';
}
if ($page - 1 > 0) {
    $page1left = '<a href=admin.php?page=' . ($page - 1) . '>' . ($page - 1) . '</a> | ';
}
if ($page + 2 <= $total) {
    $page2right = ' | <a href=admin.php?page=' . ($page + 2) . '>' . ($page + 2) . '</a>';
}
if ($page + 1 <= $total) {
    $page1right = ' | <a href=admin.php?page=' . ($page + 1) . '>' . ($page + 1) . '</a>';
}
// Вывод меню
echo '<div class="nav">' . $pervpage . $page2left . $page1left . '<b>' . $page . '</b>' . $page1right . $page2right . $nextpage . '</div>';

?>