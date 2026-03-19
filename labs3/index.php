<?php
$page_title = "Шестаков Даниил, Группа 241-352, Лабораторная работа № А-3";

// Инициализация хранилища из GET-параметра или пустой строки
if (!isset($_GET['store'])) {
    $_GET['store'] = '';
}

// Инициализация счётчика нажатий из GET-параметра или 0
if (!isset($_GET['counter'])) {
    $_GET['counter'] = 0;
}

// Обработка нажатия кнопки
if (isset($_GET['key'])) {
    if ($_GET['key'] === 'reset') {
        // Кнопка СБРОС - очищаем хранилище
        $_GET['store'] = '';
    } else {
        // Кнопка с цифрой - добавляем цифру в хранилище
        $_GET['store'] .= $_GET['key'];
    }
    // Увеличиваем счётчик нажатий
    $_GET['counter']++;
}

$store = $_GET['store'];
$counter = $_GET['counter'];
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Шапка сайта -->
    <header>
        <div class="header-content">
            <img src="logo1.jpg" alt="Эмблема" class="emblem">
            <div class="header-text">
                <h1>Шестаков Даниил</h1>
                <p>Группа 241-352</p>
                <p>Лабораторная работа № А-3</p>
            </div>
        </div>
    </header>
    
    <!-- Основной контент -->
    <main>
        <h1>Виртуальная клавиатура</h1>
        
        <!-- Окно просмотра результата -->
        <div class="result"><?php echo htmlspecialchars($store); ?></div>
        
        <!-- Кнопки цифр -->
        <div class="keyboard">
            <div class="row">
                <a href="?key=1&store=<?php echo urlencode($store); ?>&counter=<?php echo $counter; ?>" class="btn">1</a>
                <a href="?key=2&store=<?php echo urlencode($store); ?>&counter=<?php echo $counter; ?>" class="btn">2</a>
                <a href="?key=3&store=<?php echo urlencode($store); ?>&counter=<?php echo $counter; ?>" class="btn">3</a>
                <a href="?key=4&store=<?php echo urlencode($store); ?>&counter=<?php echo $counter; ?>" class="btn">4</a>
                <a href="?key=5&store=<?php echo urlencode($store); ?>&counter=<?php echo $counter; ?>" class="btn">5</a>
            </div>
            <div class="row">
                <a href="?key=6&store=<?php echo urlencode($store); ?>&counter=<?php echo $counter; ?>" class="btn">6</a>
                <a href="?key=7&store=<?php echo urlencode($store); ?>&counter=<?php echo $counter; ?>" class="btn">7</a>
                <a href="?key=8&store=<?php echo urlencode($store); ?>&counter=<?php echo $counter; ?>" class="btn">8</a>
                <a href="?key=9&store=<?php echo urlencode($store); ?>&counter=<?php echo $counter; ?>" class="btn">9</a>
                <a href="?key=0&store=<?php echo urlencode($store); ?>&counter=<?php echo $counter; ?>" class="btn">0</a>
            </div>
            <div class="row">
                <a href="?key=reset&store=&counter=<?php echo $counter; ?>" class="btn reset">СБРОС</a>
            </div>
        </div>
    </main>
    
    <!-- Подвал сайта -->
    <footer>
        <?php
        date_default_timezone_set('Europe/Moscow');
        ?>
        <p>Сформировано <?php echo date('d.m.Y в H:i:s'); ?> | Общее число нажатий: <strong><?php echo $counter; ?></strong></p>
    </footer>
</body>
</html>