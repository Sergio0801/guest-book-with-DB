<!DOCTYPE html>
<html>
<head>
    <title>Гостевая книга</title>
    <link rel="stylesheet" href="../css/index.css">
    <meta charset="utf-8"/>
    <script src="../js/jquery.min.js" type="text/javascript"></script>
</head>
<body>
<?php
$letters = "ABCDEFGKIJKLMNOPQRSTUVWXYZ123456789abcdefgkijklmnopqrstuvwxyz";
$caplimit = 4;
for ($i = 0; $i < $caplimit; $i++) {
    $captcha[$i] = $letters[mt_rand(0, strlen($letters) - 1)];
}
$ss = $captcha;
$co = implode('', $ss);
$code = md5($co);
?>
<form method="POST" action="function.php">
    <table width="100%" cellspacing="0" cellpadding="4">
        <tr>
            <td align="right" width="100">Имя</td>
            <td><input type="text" name="name" maxlength="50" size="20"></td>
        </tr>
        <tr>
            <td align="right">Email</td>
            <td><input type="email" name="email" maxlength="50" size="20"></td>
        </tr>
        <tr>
            <td align="right">Тема</td>
            <td><input type="text" name="subject" maxlength="50" size="20"></td>
        </tr>
        <tr>
            <td align="right" valign="top">Сообщение</td>
            <td><textarea name="message" cols="35" rows="10"></textarea></td>
        </tr>
        <tr>
            <td><?php echo $co; ?></td>
            <td><input type="hidden" name="code" value="<?php echo $code; ?>">
                <input type="text" name="codeorig" size="5"> <input type="submit" name="sub"></td>
        </tr>
    </table>
</form>
</body>
</html>
