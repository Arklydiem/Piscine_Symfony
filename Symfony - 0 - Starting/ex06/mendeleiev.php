<?php
    $fileContent = file_get_contents('ex06.txt');

    $rows = [];
    $currentRow = [];

    $lines = explode("\n", trim($fileContent));

    foreach ($lines as $line) {
        if (strpos($line, ' = ') === false) {
            continue; 
        }

        list($name, $properties) = explode(' = ', $line);

        preg_match_all('/(\w+):\s*([A-Za-z0-9. ]+)/', $properties, $matches);

        if (count($matches[2]) >= 5) {
            $element = [
                "name" => $name,
                "position" => (int)$matches[2][0],
                "number" => (int)$matches[2][1],
                "small" => $matches[2][2],
                "molar" => (float)$matches[2][3],
                "electron" => $matches[2][4],
            ];

            $currentRow[] = $element;

            if ($element['position'] == 17) {
                $rows[] = $currentRow;
                $currentRow = []; 
            }
        }
    }

    if (!empty($currentRow)) {
        $rows[] = $currentRow;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mendeleiev</title>
    <style>
        body {
            user-select: none;
            background-color: rgb(71, 71, 71);
        }
        td {
            margin: 0;
            padding: 0;
        }
        p {
            margin: 0;
            padding: 0;
        }
        h4 {
            margin: 0;
            padding: 0;
        }
        .cells {
            width: 80px;
            height: 80px;
            padding: 5px;
        }
        .filled {
            border-radius: 2px;
            width: 100%;
            height: 100%;
            background-color: gray;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            transition: transform 0.3s ease;
            h4 {
                transition: transform 0.3s ease;
            }
        }
        .filled:hover{
            transform: scale(1.15);
            z-index: 1;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
            h4 {
                text-shadow: 2px 2px 15px gold, 0 0 2px gold;
                color: white;
            }
        }
        .selected {
            box-shadow: 0 0 10px gold, 0 0 3px gold, 0 0 2px white !important;
            border: 1xp solid white !important;
            background-color: rgb(204, 204, 204) !important;
            h4 {
                text-shadow: 0 0 15px gold, 0 0 2px gold;
                color: white;
            }
        }
        .name, .molar {
            font-size: smaller;
        }
        .number {
            font-size: small;
        }
    </style>
</head>
<body>
    <div style="width: 100%; height: 100%; display: flex; justify-content: center; align-items: center">
        <table>
        <?php
            foreach ($rows as $row) {
                echo '<tr>';
                for ($i = 0; $i < 18; $i++) {
                    echo '<td>';
                    echo "<div class=\"cells\">";

                    foreach ($row as $element) {
                        if ($element['position'] == $i) {
                            echo "<div class=\"filled\">";
                                echo "<p class=\"name\">{$element['name']}</p>";
                                echo "<p class=\"number\">{$element['number']}</p>";
                                echo "<h4>{$element['small']}</h4>";
                                echo "<p class=\"molar\">{$element['molar']}</p>";
                            echo "</div >";
                            $found = true;
                            break;
                        }
                    }
                    echo "</div >";
                    echo '</td>';
                }
                echo '</tr>';
            }
        ?>
        </table>
    </div>
</body>
</html>

<script>
    const filledElements = document.querySelectorAll('.filled');

    filledElements.forEach(element => {
        element.addEventListener('click', () => {
            element.classList.toggle('selected');
        });
    });
</script>
