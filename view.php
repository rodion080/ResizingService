<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="scripts/jquery-3.5.1.min.js"></script>
</head>
<body>

<form id="img__form" action="/resize.php">
    <label id="img__input-label" for="img__input">Загрузите файл</label>
    <input id="img__input" type="file" accept="image/*" ><br>
    <label id="img__input-label" for="img__width">Ширина:</label>
    <input type="text" id="img__width"><br>
    <label id="img__input-label" for="img__height">Высота:</label>
    <input type="text" id="img__height"><br>
    <button id="img__saveButton" type="submit">Save</button>
</form>

<script src="scripts/main.js"></script>
</body>
</html>