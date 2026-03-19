<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Шестаков Даниил Романович, Группа 241-352, Лабораторная работа № А-2</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <img src="Logo_Polytech_rus_main.jpg" alt="Логотип университета" class="university-logo">
        <h1>Шестаков Даниил Романович, Лабораторная работа № А-2</h1>
    </header>
    
    <main>
        <?php
        $x = 25;
        $encounting = 30;
        
        $step = 2;
        
        $min_value = -100;
        
        $max_value = 1000;
        
        
        $type = 'D';
        
        $sum = 0;           // Сумма всех значений функции
        $count = 0;         // Количество вычисленных значений
        $max_f = PHP_FLOAT_MIN; // Максимальное значение функции
        $min_f = PHP_FLOAT_MAX; // Минимальное значение функции
        $values = [];       // Массив для хранения значений функции
        $results = [];      // Массив для хранения пар (аргумент, значение)
        
        
        $i = 0;
        do {
            if ($x <= 10) {
                // x <= 10: f(x) = 10 * x - 5
                $f = 10 * $x - 5;
            } else if ($x < 20) {
                // 10 < x < 20: f(x) = (x + 3) * x^2
                $f = ($x + 3) * pow($x, 2);
            } else {
                if ($x == 25) {
                    $f = 'error';
                } else {
                    $f = 3 / ($x - 25) + 2;
                }
            }
            
            // Проверка на числовое значение для сбора статистики
            if (is_numeric($f)) {
                $values[] = $f;
                $sum += $f;
                $count++;
                
                // Обновление максимального и минимального значений
                if ($f > $max_f) $max_f = $f;
                if ($f < $min_f) $min_f = $f;
            }
            
            // Сохранение текущего значения аргумента и функции
            $results[] = ['x' => $x, 'f' => $f];
            
            // Увеличение счетчиков
            $i++;
            $x += $step;
        } while ($i < $encounting && ($f === 'error' || (is_numeric($f) && $f >= $min_value && $f <= $max_value)));
        
        // Вывод результатов в зависимости от типа верстки
        switch ($type) {
            case 'A':
                // Простая верстка текстом
                // Каждая строка "f(x)=y" выводится с разделителем <br>
                foreach ($results as $result) {
                    echo "f(" . $result['x'] . ") = " . $result['f'] . "<br>";
                }
                break;
                
            case 'B':
                
                // Каждая строка "f(x)=y" выводится как элемент маркированного списка
                echo '<ul>';
                foreach ($results as $result) {
                    echo '<li>f(' . $result['x'] . ') = ' . $result['f'] . '</li>';
                }
                echo '</ul>';
                break;
                
            case 'C':
                // Нумерованный список
                // Каждая строка "f(x)=y" выводится как элемент нумерованного списка
                echo '<ol>';
                foreach ($results as $result) {
                    echo '<li>f(' . $result['x'] . ') = ' . $result['f'] . '</li>';
                }
                echo '</ol>';
                break;
                
            case 'D':
                // Табличная верстка
                // Выводится таблица с тремя колонками:
                // №, Аргумент (x), Функция f(x)
                // Границы ячеек одинарные, черного цвета
                echo '<table border="1" cellpadding="5" cellspacing="0">';
                echo '<tr><th>№</th><th>Аргумент (x)</th><th>Функция f(x)</th></tr>';
                $counter = 1;
                foreach ($results as $result) {
                    echo '<tr>';
                    echo '<td>' . $counter++ . '</td>';
                    echo '<td>' . $result['x'] . '</td>';
                    echo '<td>' . $result['f'] . '</td>';
                    echo '</tr>';
                }
                echo '</table>';
                break;
                
            case 'E':
                // Блочная верстка
                // Каждая строка "f(x)=y" выводится внутри блока (тег <div>)
                // Все блоки располагаются по горизонтали с красной рамкой толщиной 2px
                // и отступом друг от друга на 8px
                echo '<div class="blocks-container">';
                foreach ($results as $result) {
                    echo '<div class="block">' . "f(" . $result['x'] . ") = " . $result['f'] . '</div>';
                }
                echo '</div>';
                break;
        }
        
        // Вывод статистики
        echo '<div class="statistics">';
        echo '<h2>Статистика:</h2>';
        
        if ($count > 0) {
            // Вычисление среднего арифметического
            $average = $sum / $count;
            
            // Округление значений до 3-х знаков после запятой
            echo '<p>Максимальное значение: ' . round($max_f, 3) . '</p>';
            echo '<p>Минимальное значение: ' . round($min_f, 3) . '</p>';
            echo '<p>Среднее арифметическое: ' . round($average, 3) . '</p>';
            echo '<p>Сумма значений: ' . round($sum, 3) . '</p>';
            echo '<p>Количество вычисленных значений: ' . $count . '</p>';
        } else {
            // Если не удалось вычислить ни одного значения функции
            echo '<p>Не удалось вычислить ни одного значения функции</p>';
        }
        
        echo '</div>';
        ?>
    </main>
    
    <footer>
        <!-- Вывод типа верстки в подвале страницы -->
        Тип верстки: <?php echo $type; ?>
    </footer>
</body>
</html>