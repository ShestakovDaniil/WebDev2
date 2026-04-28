<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Лабораторная работа № А-4</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Лабораторная работа № А-4</h1>
        <p>Шестаков Даниил Романович, Группа 241-352</p>
    </header>

    <main>
        <?php
        $columnsCount = 2; 

        $structures = [
            'Данные1_1*Данные1_2*Данные1_3*Данные1_4#Данные2_1*Данные2_2*Данные2_3*Данные2_4',
            'A1*A2#B1*B2*B3*B4',
            'C1*C2*C3*C4*C5#D1*D2',
            'E1*E2*E3*E4',
            '#F1*F2*F3*F4',           // Пустая первая строка
            'G1*G2*G3*G4#',           // Пустая вторая строка
            '',                       // Полностью пустая структура
            '##',                     // Только разделители строк
            'H1*H2*H3*H4#I1*I2*I3*I4',
            'J1*J2*J3*J4#K1*K2*K3*K4#L1*L2*L3*L4',
            'M1*M2*M3*M4'             
        ];

function getTR($rowData, $numCols) {
    if ($rowData === '') {
        $html = '<tr>';
        for ($i = 0; $i < $numCols; $i++) {
            $html .= '<td></td>';
        }
        $html .= '</tr>';
        return $html;
    }
    
    $cells = explode('*', $rowData);

    $hasContent = false;
    foreach ($cells as $cell) {
        if (trim($cell) !== '') {
            $hasContent = true;
            break;
        }
    }
    
    if (!$hasContent) {
        return '';
    }

    $html = '<tr>';
    for ($i = 0; $i < $numCols; $i++) {
        $content = isset($cells[$i]) ? htmlspecialchars(trim($cells[$i])) : '';
        $html .= "<td>$content</td>";
    }
    $html .= '</tr>';
    return $html;
}        function outTable($structure, $numCols, $tableIndex) {

            echo "<h2>Таблица №$tableIndex</h2>";

            if (trim($structure) === '') {
                echo "<p>В таблице нет строк</p>";
                return;
            }

            $rows = explode('#', $structure);
            $datas = '';
            $hasRowsWithCells = false;

            foreach ($rows as $rowStr) {
                $trHtml = getTR($rowStr, $numCols);
                if ($trHtml !== '') {
                    $datas .= $trHtml;
                    $hasRowsWithCells = true;
                }
            }

            if (!$hasRowsWithCells) {
                echo "<p>В таблице нет строк с ячейками</p>";
                return;
            }

            echo "<table>$datas</table>";
        }


        if ($columnsCount <= 0) {
            echo "<h2>Неправильное число колонок</h2>";
        } else {
            foreach ($structures as $idx => $struct) {
                outTable($struct, $columnsCount, $idx + 1);
            }
        }
        ?>
    </main>

    <footer>
        <p>&copy; 2026 Шестаков Д.Р.</p>
    </footer>
</body>
</html>