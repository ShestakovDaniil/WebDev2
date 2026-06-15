<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ЛР А-7: Ввод массива</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main class="container">
        <h1>Ввод данных для сортировки</h1>
        <!-- Форма отправляет данные во второй файл (process.php) в новой вкладке -->
        <form method="POST" action="process.php" target="_blank">
            <table id="elements">
                <!-- Начальная строка: номер элемента слева, поле ввода справа -->
                <tr>
                    <td class="element_index">0:</td>
                    <td class="element_cell"><input type="text" name="element0" required></td>
                </tr>
            </table>

            <div class="controls">
                <!-- Селектор выбора алгоритма сортировки -->
                <select name="algorithm">
                    <option value="selection">Сортировка выбором</option>
                    <option value="bubble">Пузырьковый алгоритм</option>
                    <option value="shell">Алгоритм Шелла</option>
                    <option value="gnome">Алгоритм садового гнома</option>
                    <option value="quick">Быстрая сортировка</option>
                    <option value="php">Встроенная функция PHP</option>
                </select>

                <!-- Скрытое поле для передачи длины массива в обработчик -->
                <input type="hidden" id="arrLength" name="arrLength" value="1">
                
                <!-- Кнопки управления -->
                <button type="button" onclick="addElement('elements')">Добавить еще один элемент</button>
                <button type="submit">Сортировать массив</button>
            </div>
        </form>
    </main>

    <script>
        // Листинг А-7.2: Кросс-браузерная функция установки внутреннего HTML-контента
        function setHTML(element, txt) {
            // Проверяем поддержку стандартного свойства innerHTML
            if (element.innerHTML !== undefined) {
                element.innerHTML = txt; // Стандартный способ для современных браузеров
            } else {
                // Fallback для старых браузеров через Range и DocumentFragment
                var range = document.createRange();
                range.selectNodeContents(element);
                range.deleteContents();
                var fragment = range.createContextualFragment(txt);
                element.appendChild(fragment);
            }
        }

        // Листинг А-7.1 (модифицирован): Динамическое добавление полей ввода
        function addElement(table_name) {
            var table = document.getElementById(table_name); // Получаем объект таблицы по ID
            var index = table.rows.length; // Индекс новой строки равен текущему количеству строк
            
            var row = table.insertRow(index); // Вставляем новую строку в конец таблицы
            
            // Создаем ячейку для номера элемента (ключ массива)
            var cellIndex = row.insertCell(0);
            cellIndex.className = 'element_index';
            setHTML(cellIndex, index + ':'); // Выводим номер слева
            
            // Создаем ячейку для поля ввода с уникальным именем elementX
            var cellInput = row.insertCell(1);
            cellInput.className = 'element_cell';
            var inputHtml = '<input type="text" name="element' + index + '" required>';
            setHTML(cellInput, inputHtml); // Добавляем контент в ячейку
            
            // Обновляем скрытое поле с текущим количеством элементов массива
            document.getElementById('arrLength').value = table.rows.length;
        }
    </script>
</body>
</html>