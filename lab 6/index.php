<?php
// Листинг А-6.1: Проверка того, что форма была отправлена пользователем
// Если в массиве $_POST существует ключ 'A', значит данные из формы переданы
if (isset($_POST['A'])) {
    // Приводим ввод пользователя к формату с точкой для корректной работы с числами
    // Справочная информация: str_replace() заменяет все вхождения запятой на точку
    $A = (float)str_replace(',', '.', $_POST['A']);
    $B = (float)str_replace(',', '.', $_POST['B']);
    $C = (float)str_replace(',', '.', $_POST['C']);

    $result = null; // Переменная для хранения результата вычислений
    $taskType = $_POST['TASK']; // Получаем тип выбранной задачи

    // Листинг А-6.3: Автоматическое решение математической задачи
    // Используем цепочку if/else if для выбора алгоритма в зависимости от селектора
    if ($taskType == 'area') {
        // Площадь треугольника по формуле Герона
        $p = ($A + $B + $C) / 2;
        // Функция sqrt() вычисляет квадратный корень
        $result = sqrt($p * ($p - $A) * ($p - $B) * ($p - $C));
    } 
    else if ($taskType == 'perimeter') {
        // Периметр треугольника
        $result = $A + $B + $C;
    } 
    else if ($taskType == 'volume') {
        // Объем параллелепипеда
        $result = $A * $B * $C;
    } 
    else if ($taskType == 'mean') {
        // Среднее арифметическое
        $result = ($A + $B + $C) / 3;
    } 
    else if ($taskType == 'hypotenuse') {
        // Кастомная задача 1: Гипотенуза по катетам A и B
        $result = sqrt(pow($A, 2) + pow($B, 2));
    } 
    else if ($taskType == 'custom') {
        // Кастомная задача 2: (A * B) + C
        $result = ($A * $B) + $C;
    }

    // Справочная информация: round() округляет число до указанного количества знаков
    $result = round($result, 2);

    // Листинг А-6.6: Формируем отчет в промежуточную переменную $out_text
    // Это необходимо для многократного использования (вывод в браузер + отправка по почте)
    $out_text = '';
    $out_text .= 'ФИО: ' . htmlspecialchars($_POST['FIO']) . '<br>';
    $out_text .= 'Группа: ' . htmlspecialchars($_POST['GROUP']) . '<br>';
    
    // Проверяем, заполнено ли поле "Немного о себе"
    if (!empty($_POST['ABOUT'])) {
        $out_text .= '<br>' . htmlspecialchars($_POST['ABOUT']) . '<br>';
    }

    $out_text .= 'Решаемая задача: ';
    // Сопоставляем значение селектора с человекочитаемым названием
    if ($taskType == 'area') $out_text .= 'ПЛОЩАДЬ ТРЕУГОЛЬНИКА';
    else if ($taskType == 'perimeter') $out_text .= 'ПЕРИМЕТР ТРЕУГОЛЬНИКА';
    else if ($taskType == 'volume') $out_text .= 'ОБЪЕМ ПАРАЛЛЕЛЕПИПЕДА';
    else if ($taskType == 'mean') $out_text .= 'СРЕДНЕЕ АРИФМЕТИЧЕСКОЕ';
    else if ($taskType == 'hypotenuse') $out_text .= 'ГИПОТЕНУЗА ПРЯМОУГОЛЬНОГО ТРЕУГОЛЬНИКА';
    else $out_text .= 'КАСТОМНАЯ ЗАДАЧА (A*B+C)';
    $out_text .= '<br>';

    $out_text .= 'Входные данные: A=' . $A . ', B=' . $B . ', C=' . $C . '<br>';

    // Подготовка ответа пользователя для сравнения
    $userAnswer = str_replace(',', '.', $_POST['result']);

    // Листинг А-6.5: Сравнение ответа человека и машины
    // Если поле ответа пустое, выводим соответствующую надпись
    if ($userAnswer === '') {
        $out_text .= 'Предполагаемый ответ: Задача самостоятельно решена не была<br>';
    } 
    // Справочная информация: оператор === проверяет совпадение и значения, и типа данных
    // Для корректности приводим оба значения к строке с округлением до 2 знаков
    else if ((string)round((float)$userAnswer, 2) === (string)$result) {
        $out_text .= '<b>ТЕСТ ПРОЙДЕН</b><br>';
    } 
    else {
        $out_text .= '<b>ОШИБКА: ТЕСТ НЕ ПРОЙДЕН!</b><br>';
    }

    $out_text .= 'Вычисленный программой результат: ' . $result . '<br>';

    // Листинг А-6.6: Проверка установки флажка "Отправить результат по e-mail"
    // array_key_exists() проверяет наличие ключа в массиве, даже если значение пустое
    if (array_key_exists('send_mail', $_POST)) {
        $toEmail = htmlspecialchars($_POST['MAIL']);
        $subject = 'Результат тестирования';
        // Справочная информация: str_replace() заменяет HTML-теги переноса на символы новой строки для письма
        $message = str_replace('<br>', "\r\n", $out_text);
        $headers = "From: auto@mami.ru\n" . "Content-Type: text/plain; charset=utf-8\n";
        
        // Функция mail() отправляет сообщение. На локальных серверах может требовать настройки SMTP
        mail($toEmail, $subject, $message, $headers);
        
        $out_text .= '<p>Результаты теста были автоматически отправлены на e-mail ' . $toEmail . '</p>';
    }

    // Определение режима отображения для применения разных стилей
    $viewMode = isset($_POST['VIEW']) ? $_POST['VIEW'] : 'browser';
    $isBrowserVersion = ($viewMode === 'browser');
} 
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ЛР №6 - Тест математических знаний</title>
    <!-- Подключение внешнего файла стилей -->
    <link rel="stylesheet" href="style.css">
    <style>
        /* Условные стили для режима печати, генерируемые PHP */
        <?php if (!isset($isBrowserVersion) || !$isBrowserVersion): ?>
        @media print {
            body { background: #fff; color: #000; }
            .container { max-width: 100%; box-shadow: none; }
            .no-print { display: none !important; }
        }
        <?php endif; ?>
    </style>
</head>
<body>
<div class="container <?php echo (isset($isBrowserVersion) && $isBrowserVersion) ? 'browser-version' : 'print-version'; ?>">
    <?php
    // Листинг А-6.4: Вывод результатов обработки или повторный вывод формы
    // Если переменная $result определена, значит данные были обработаны
    if (isset($result)) {
        echo $out_text;
        
        // Листинг А-6.7: Ссылка "Повторить тест" выводится только в браузерной версии
        // Передаем ФИО и Группу через GET-параметры для автозаполнения
        if ($isBrowserVersion) {
            $fioSafe = urlencode($_POST['FIO']);
            $groupSafe = urlencode($_POST['GROUP']);
            echo '<a href="?F=' . $fioSafe . '&G=' . $groupSafe . '" id="back_button" class="btn-link">Повторить тест</a>';
        }
    } 
    else {
        // Начальная загрузка страницы: выводим форму
        // Получаем значения из GET для сохранения ФИО и Группы при повторном тесте
        $defaultFio = isset($_GET['F']) ? htmlspecialchars($_GET['F']) : 'Shestakov Daniil Romanovich';
        $defaultGroup = isset($_GET['G']) ? htmlspecialchars($_GET['G']) : '241-352';
        
        // Справочная информация: mt_rand() генерирует случайные числа
        // Делим на 100, чтобы получить десятичные дроби от 5.00 до 100.00
        $initA = mt_rand(500, 10000) / 100;
        $initB = mt_rand(500, 10000) / 100;
        $initC = mt_rand(500, 10000) / 100;
    ?>
    <!-- Форма передает данные методом POST на саму же страницу (action="") -->
    <form name="form_1" method="post" action="">
        <div class="form-row">
            <label for="fio">ФИО:</label>
            <input type="text" id="fio" name="FIO" value="<?php echo $defaultFio; ?>" required>
        </div>
        <div class="form-row">
            <label for="group">Номер группы:</label>
            <input type="text" id="group" name="GROUP" value="<?php echo $defaultGroup; ?>" required>
        </div>
        <div class="form-row">
            <label for="A">Значение А:</label>
            <input type="text" id="A" name="A" value="<?php echo $initA; ?>" required>
        </div>
        <div class="form-row">
            <label for="B">Значение В:</label>
            <input type="text" id="B" name="B" value="<?php echo $initB; ?>" required>
        </div>
        <div class="form-row">
            <label for="C">Значение С:</label>
            <input type="text" id="C" name="C" value="<?php echo $initC; ?>" required>
        </div>
        <div class="form-row">
            <label for="task">Тип задачи:</label>
            <select id="task" name="TASK">
                <option value="area">Площадь треугольника</option>
                <option value="perimeter">Периметр треугольника</option>
                <option value="volume">Объем параллелепипеда</option>
                <option value="mean" selected>Среднее арифметическое</option>
                <option value="hypotenuse">Гипотенуза (A, B - катеты)</option>
                <option value="custom">Другое (A*B + C)</option>
            </select>
        </div>
        <div class="form-row">
            <label for="result">Ваш ответ:</label>
            <input type="text" id="result" name="result">
        </div>
        <div class="form-row">
            <label for="about">Немного о себе:</label>
            <textarea id="about" name="ABOUT" rows="4"></textarea>
        </div>
        
        <!-- Чекбокс с JavaScript обработчиком события onClick -->
        <!-- Справочная информация: скрывает/показывает блок email_field -->
        <div class="form-row checkbox-row">
            <input type="checkbox" id="send_mail" name="send_mail" value="1" 
                   onClick="
                       var obj = document.getElementById('email_field');
                       if(this.checked) obj.style.display='flex'; else obj.style.display='none';
                   ">
            <label for="send_mail">Отправить результат теста по e-mail</label>
        </div>
        
        <div id="email_field" class="form-row" style="display: none;">
            <label for="MAIL">Ваш e-mail:</label>
            <input type="email" id="MAIL" name="MAIL">
        </div>

        <div class="form-row">
            <label for="view">Режим вывода:</label>
            <select id="view" name="VIEW">
                <option value="browser">Версия для просмотра в браузере</option>
                <option value="print">Версия для печати</option>
            </select>
        </div>

        <div class="form-row button-row no-print">
            <!-- Кнопка  -->
            <a href="javascript:void(0);" class="btn-link" onclick="document.forms['form_1'].submit(); return false;">Проверить</a>
        </div>
    </form>
    <?php 
    } // Конец блока else (вывод формы)
    ?>
</div>
</body>
</html>