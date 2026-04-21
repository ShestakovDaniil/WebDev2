<?php
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Результат анализа</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Результат анализа текста</h1>
    </header>

    <main>
<?php
if (isset($_POST['data']) && trim($_POST['data']) !== '') {
    // Перекодируем из UTF-8 в CP1251 для корректной работы с символами
    $text = iconv("UTF-8", "CP1251", $_POST['data']);
    echo '<div class="src_text">' . htmlspecialchars($_POST['data']) . '</div>';
    test_it($text);
} else {
    echo '<div class="src_error">Нет текста для анализа</div>';
}

function test_it($text) {
    $total_chars = strlen($text);
    $letters = 0;
    $upper = 0;
    $lower = 0;
    $punct = 0;
    $digits = 0;
    $char_counts = array();
    $words = array();
    $word = '';
    
    // Создаем массив знаков препинания
    $punctuation = array(
        '.' => true, ',' => true, '!' => true, '?' => true, 
        ';' => true, ':' => true, '-' => true, '—' => true,
        '(' => true, ')' => true, '"' => true, '\'' => true,
        '«' => true, '»' => true, '…' => true
    );
    
    // Перебираем все символы текста
    for ($i = 0; $i < strlen($text); $i++) {
        $char = $text[$i];
        $char_lower = strtolower($char);
        
        // Подсчет вхождений символов (без учета регистра)
        if (isset($char_counts[$char_lower])) {
            $char_counts[$char_lower]++;
        } else {
            $char_counts[$char_lower] = 1;
        }
        
        // Проверка на цифру (0-9)
        if ($char >= '0' && $char <= '9') {
            $digits++;
        }
        
        // Проверка на букву (латиница и кириллица в CP1251)
        // Латиница: A-Z (65-90), a-z (97-122)
        // Кириллица CP1251: А-Я (192-223), а-я (224-255), Ё(168), ё(184)
        $ord = ord($char);
        $is_letter = false;
        
        // Латинские буквы
        if (($ord >= 65 && $ord <= 90) || ($ord >= 97 && $ord <= 122)) {
            $is_letter = true;
        }
        // Кириллические буквы (CP1251)
        else if (($ord >= 192 && $ord <= 223) || ($ord >= 224 && $ord <= 255) || $ord == 168 || $ord == 184) {
            $is_letter = true;
        }
        
        if ($is_letter) {
            $letters++;
            
            // Проверка регистра
            // Заглавные: A-Z (65-90), А-Я (192-223), Ё(168)
            if (($ord >= 65 && $ord <= 90) || ($ord >= 192 && $ord <= 223) || $ord == 168) {
                $upper++;
            }
            // Строчные: a-z (97-122), а-я (224-255), ё(184)
            else {
                $lower++;
            }
            
            // Формирование слова
            $word .= $char;
        } else {
            // Конец слова
            if ($word !== '') {
                $word_lower = strtolower($word);
                if (isset($words[$word_lower])) {
                    $words[$word_lower]++;
                } else {
                    $words[$word_lower] = 1;
                }
                $word = '';
            }
            
            // Проверка на знак препинания
            if (isset($punctuation[$char])) {
                $punct++;
            }
        }
    }
    
    // Обрабатываем последнее слово если оно есть
    if ($word !== '') {
        $word_lower = strtolower($word);
        if (isset($words[$word_lower])) {
            $words[$word_lower]++;
        } else {
            $words[$word_lower] = 1;
        }
    }
    
    // Сортируем слова по алфавиту
    ksort($words);
    
    // Вывод результатов
    echo '<table class="analysis-table">';
    echo '<tr><th>Параметр</th><th>Значение</th></tr>';
    echo '<tr><td>1. Количество символов (включая пробелы)</td><td>' . $total_chars . '</td></tr>';
    echo '<tr><td>2. Количество букв</td><td>' . $letters . '</td></tr>';
    echo '<tr><td>3. Заглавные буквы</td><td>' . $upper . '</td></tr>';
    echo '<tr><td>3. Строчные буквы</td><td>' . $lower . '</td></tr>';
    echo '<tr><td>4. Знаки препинания</td><td>' . $punct . '</td></tr>';
    echo '<tr><td>5. Цифры</td><td>' . $digits . '</td></tr>';
    echo '<tr><td>6. Количество слов</td><td>' . count($words) . '</td></tr>';
    echo '</table>';
    
    // Вывод вхождений символов
    echo '<h3>7. Вхождения символов (без учета регистра)</h3>';
    echo '<table class="analysis-table"><tr><th>Символ</th><th>Количество</th></tr>';
    foreach ($char_counts as $char => $count) {
        $char_display = iconv("CP1251", "UTF-8", $char);
        echo '<tr><td>' . $char_display . '</td><td>' . $count . '</td></tr>';
    }
    echo '</table>';
    
    // Вывод вхождений слов
    echo '<h3>8. Вхождения слов (отсортировано по алфавиту)</h3>';
    echo '<table class="analysis-table"><tr><th>Слово</th><th>Количество</th></tr>';
    foreach ($words as $word => $count) {
        $word_display = iconv("CP1251", "UTF-8", $word);
        echo '<tr><td>' . $word_display . '</td><td>' . $count . '</td></tr>';
    }
    echo '</table>';
}
?>
        <a href="index.html" class="back-link">Другой анализ</a>
    </main>

    <footer>
        <p>Шестаков Даниил Романович, Группа 241-352, Лабораторная работа № А-8</p>
    </footer>
</body>
</html>