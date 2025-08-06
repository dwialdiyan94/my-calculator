<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculator PHP</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .calculator {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 30px;
            max-width: 400px;
            width: 100%;
        }

        .calculator h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
            font-size: 2rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 600;
            font-size: 1.1rem;
        }

        input[type="number"] {
            width: 100%;
            padding: 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 1.2rem;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        input[type="number"]:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.2);
        }

        .operator-group {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-bottom: 20px;
        }

        .operator-btn {
            background: #667eea;
            color: white;
            border: none;
            padding: 15px;
            border-radius: 10px;
            font-size: 1.2rem;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: bold;
        }

        .operator-btn:hover {
            background: #5a67d8;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }

        .operator-btn.active {
            background: #764ba2;
            transform: translateY(-1px);
        }

        .calculate-btn {
            width: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 18px;
            border-radius: 10px;
            font-size: 1.3rem;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 20px;
        }

        .calculate-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        .result {
            background: #f8f9fa;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
            min-height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .result.success {
            background: #d4edda;
            border-color: #28a745;
            color: #155724;
        }

        .result.error {
            background: #f8d7da;
            border-color: #dc3545;
            color: #721c24;
        }

        .clear-btn {
            width: 100%;
            background: #6c757d;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 10px;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 15px;
        }

        .clear-btn:hover {
            background: #5a6268;
            transform: translateY(-1px);
        }

        @media (max-width: 480px) {
            .calculator {
                padding: 20px;
            }
            
            .calculator h1 {
                font-size: 1.5rem;
            }
            
            input[type="number"], .operator-btn, .calculate-btn {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="calculator">
        <h1>🔢 Calculator</h1>
        
        <?php
        $num1 = '';
        $num2 = '';
        $operator = '';
        $result = '';
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $num1 = $_POST['num1'] ?? '';
            $num2 = $_POST['num2'] ?? '';
            $operator = $_POST['operator'] ?? '';

            if (is_numeric($num1) && is_numeric($num2) && !empty($operator)) {
                $num1 = floatval($num1);
                $num2 = floatval($num2);

                switch ($operator) {
                    case '+':
                        $result = $num1 + $num2;
                        break;
                    case '-':
                        $result = $num1 - $num2;
                        break;
                    case '*':
                        $result = $num1 * $num2;
                        break;
                    case '/':
                        if ($num2 != 0) {
                            $result = $num1 / $num2;
                        } else {
                            $error = "Error: Pembagian dengan nol!";
                        }
                        break;
                    default:
                        $error = "Error: Operator tidak valid!";
                }

                if (!$error && is_numeric($result)) {
                    // Format hasil untuk menghilangkan desimal tidak perlu
                    if ($result == floor($result)) {
                        $result = number_format($result, 0);
                    } else {
                        $result = number_format($result, 6);
                        $result = rtrim($result, '0');
                        $result = rtrim($result, '.');
                    }
                }
            } else {
                $error = "Error: Masukkan angka yang valid!";
            }
        }
        ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="num1">Angka Pertama:</label>
                <input type="number" id="num1" name="num1" step="any" value="<?php echo htmlspecialchars($num1); ?>" required>
            </div>

            <div class="form-group">
                <label>Pilih Operator:</label>
                <div class="operator-group">
                    <button type="button" class="operator-btn <?php echo ($operator == '+') ? 'active' : ''; ?>" onclick="selectOperator('+')">+</button>
                    <button type="button" class="operator-btn <?php echo ($operator == '-') ? 'active' : ''; ?>" onclick="selectOperator('-')">−</button>
                    <button type="button" class="operator-btn <?php echo ($operator == '*') ? 'active' : ''; ?>" onclick="selectOperator('*')">×</button>
                    <button type="button" class="operator-btn <?php echo ($operator == '/') ? 'active' : ''; ?>" onclick="selectOperator('/')">÷</button>
                </div>
                <input type="hidden" id="operator" name="operator" value="<?php echo htmlspecialchars($operator); ?>">
            </div>

            <div class="form-group">
                <label for="num2">Angka Kedua:</label>
                <input type="number" id="num2" name="num2" step="any" value="<?php echo htmlspecialchars($num2); ?>" required>
            </div>

            <button type="submit" class="calculate-btn">🧮 Hitung</button>
        </form>

        <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
        <div class="result <?php echo $error ? 'error' : 'success'; ?>">
            <?php 
            if ($error) {
                echo $error;
            } else {
                $operatorSymbol = $operator;
                if ($operator == '*') $operatorSymbol = '×';
                if ($operator == '/') $operatorSymbol = '÷';
                if ($operator == '-') $operatorSymbol = '−';
                
                echo "{$num1} {$operatorSymbol} " . $_POST['num2'] . " = " . $result;
            }
            ?>
        </div>
        <?php endif; ?>

        <form method="GET" action="">
            <button type="submit" class="clear-btn">🗑️ Clear</button>
        </form>
    </div>

    <script>
        function selectOperator(op) {
            // Hapus kelas active dari semua button
            const buttons = document.querySelectorAll('.operator-btn');
            buttons.forEach(btn => btn.classList.remove('active'));
            
            // Tambah kelas active ke button yang dipilih
            event.target.classList.add('active');
            
            // Set nilai operator
            document.getElementById('operator').value = op;
        }

        // Auto-focus ke input pertama saat halaman dimuat
        window.onload = function() {
            document.getElementById('num1').focus();
        };

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                document.querySelector('.calculate-btn').click();
            } else if (e.key === 'Escape') {
                document.querySelector('.clear-btn').click();
            }
        });
    </script>
</body>
</html>
