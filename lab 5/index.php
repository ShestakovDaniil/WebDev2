<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Таблица умножения</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="wrapper">
        <!-- Главное меню -->
        <div id="main_menu">
            <?php
            echo '<a href="?html_type=TABLE';
            if (isset($_GET['content']))
                echo '&content=' . $_GET['content'];
            echo '"';
            if (isset($_GET['html_type']) && $_GET['html_type'] == 'TABLE')
                echo ' class="selected"';
            echo '>Табличная верстка</a>';

            echo '<a href="?html_type=DIV';
            if (isset($_GET['content']))
                echo '&content=' . $_GET['content'];
            echo '"';
            if (isset($_GET['html_type']) && $_GET['html_type'] == 'DIV')
                echo ' class="selected"';
            echo '>Блочная верстка</a>';
            ?>
        </div>

        <!-- Контейнер для бокового меню и контента -->
        <div id="container">
            <!-- Основное меню (слева) -->
            <div id="product_menu">
                <?php
                echo '<a href="/';
                if (isset($_GET['html_type']))
                    echo '?html_type=' . $_GET['html_type'];
                echo '"';
                if (!isset($_GET['content']))
                    echo ' class="selected"';
                echo '>Всё</a>';

                for ($i = 2; $i <= 9; $i++) {
                    echo '<a href="?content=' . $i;
                    if (isset($_GET['html_type']))
                        echo '&html_type=' . $_GET['html_type'];
                    echo '"';
                    if (isset($_GET['content']) && $_GET['content'] == $i)
                        echo ' class="selected"';
                    echo '>' . $i . '</a>';
                }
                ?>
            </div>

            <!-- Основной контент (таблица умножения) -->
            <div id="content">
                <?php
                // Определяем тип верстки (по умолчанию TABLE)
                if (!isset($_GET['html_type']) || $_GET['html_type'] == 'TABLE')
                    outTableForm();
                else
                    outDivForm();
                ?>
            </div>
        </div>

        <!-- Подвал с информацией -->
        <div id="footer">
            <?php
            if (!isset($_GET['html_type']) || $_GET['html_type'] == 'TABLE')
                $s = 'Табличная верстка. ';
            else
                $s = 'Блочная верстка. ';

            if (!isset($_GET['content']))
                $s .= 'Таблица умножения полностью. ';
            else
                $s .= 'Столбец таблицы умножения на ' . $_GET['content'] . '. ';

            echo $s . date('d.m.Y H:i:s');
            ?>
        </div>
    </div>
</body>
</html>

<?php
// Функция выводит число как ссылку
function outNumAsLink($x) {
    if ($x >= 2 && $x <= 9)
        return '<a href="?content=' . $x . '">' . $x . '</a>';
    else
        return $x;
}

// Функция выводит столбец таблицы умножения
function outRow($n) {
    for ($i = 2; $i <= 9; $i++) {
        echo outNumAsLink($n) . 'x' . outNumAsLink($i) . '=' . outNumAsLink($i * $n) . '<br>';
    }
}

// Функция выводит таблицу умножения в табличной форме
function outTableForm() {
    if (!isset($_GET['content'])) {
        echo '<table id="tt">';
        for ($i = 2; $i <= 9; $i++) {
            echo '<td>';
            outRow($i);
            echo '</td>';
        }
        echo '</table>';
    } else {
        echo '<table id="tt_single">';
        echo '<td>';
        outRow($_GET['content']);
        echo '</td>';
        echo '</table>';
    }
}

// Функция выводит таблицу умножения в блочной форме
function outDivForm() {
    if (!isset($_GET['content'])) {
        echo '<div class="ttRow">';
        for ($i = 2; $i <= 9; $i++) {
            echo '<div class="col">';
            outRow($i);
            echo '</div>';
        }
        echo '</div>';
    } else {
        echo '<div class="ttSingleRow">';
        outRow($_GET['content']);
        echo '</div>';
    }
}
?>