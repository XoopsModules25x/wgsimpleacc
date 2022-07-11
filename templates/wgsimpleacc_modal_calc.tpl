<!-- Start Calculator -->
<style>
    .calculator {
        border: 1px solid #ccc;
        border-radius: 5px;
        width: 100%;
    }
    .calculator-screen {
        width: 100%;
        font-size: 5rem;
        height: 80px;
        border: none;
        background-color: #252525;
        color: #fff;
        text-align: right;
        padding-right: 20px;
        padding-left: 10px;
    }
    button {
        height: 60px;
        font-size: 24px !important;
    }
    .equal-sign {
        height: 100%;
        grid-area: 2 / 4 / 6 / 5;
    }
    .equal-sign:hover {
        background-color: #4e9ed4;
    }
    .calculator-keys {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        grid-gap: 20px;
        padding: 20px;
    }
</style>

<!-- Start code for calc modal -->
<div class="clear"></div>
<div class="modal fade" id="calcModal" tabindex="-1" role="dialog" aria-labelledby="calcModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="calcModalLabel"><{$smarty.const._MA_WGSIMPLEACC_CALC}></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="<{$smarty.const._CLOSE}>">
                    <span class="btn btn-danger" aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="modal-body" class="modal-body">
                <div class="calculator">
                    <input id="calc-screen" type="text" class="calculator-screen" value="" disabled />
                    <div class="calculator-keys">
                        <button type="button" class="btn btn-warning operator" value="+">+</button>
                        <button type="button" class="btn btn-warning operator" value="-">-</button>
                        <button type="button" class="btn btn-warning operator" value="*">&times;</button>
                        <button type="button" class="btn btn-warning operator" value="/">&divide;</button>
                        <button type="button" class="btn btn-primary digit" value="7">7</button>
                        <button type="button" class="btn btn-primary digit" value="8">8</button>
                        <button type="button" class="btn btn-primary digit" value="9">9</button>
                        <button type="button" class="btn btn-primary digit" value="4">4</button>
                        <button type="button" class="btn btn-primary digit" value="5">5</button>
                        <button type="button" class="btn btn-primary digit" value="6">6</button>
                        <button type="button" class="btn btn-primary digit" value="1">1</button>
                        <button type="button" class="btn btn-primary digit" value="2">2</button>
                        <button type="button" class="btn btn-primary digit" value="3">3</button>
                        <button type="button" class="btn btn-primary digit" value="0">0</button>
                        <button type="button" class="btn btn-primary decimal" value="."><{$sepComma}></button>
                        <button type="button" class="btn btn-danger all-clear" value="all-clear">AC</button>
                        <button type="button" class="btn btn-warning equal-sign operator" value="=">=</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="btnApplyResult" type="button" class="btn btn-secondary btn-success" data-dismiss="modal"><{$smarty.const._MA_WGSIMPLEACC_CALC_APPLY}></button>
            </div>
        </div>
    </div>
</div>

<script>
    const calculator = {
        displayValue: '0',
        firstOperand: null,
        waitingForSecondOperand: false,
        operator: null,
    };

    //Manage Operators
    const performCalculation = {
        '+': (firstOperand, secondOperand) => firstOperand + secondOperand,
        '-': (firstOperand, secondOperand) => firstOperand - secondOperand,
        '*': (firstOperand, secondOperand) => firstOperand * secondOperand,
        '/': (firstOperand, secondOperand) => firstOperand / secondOperand,
        '=': (firstOperand, secondOperand) => secondOperand
    };

    function inputDigit(digit) {
        const {
            displayValue,
            waitingForSecondOperand
        } = calculator;

        if (waitingForSecondOperand === true) {
            calculator.displayValue = digit;
            calculator.waitingForSecondOperand = false;
        } else {
            calculator.displayValue = displayValue === '0' ? digit : displayValue + digit;
        }

        console.log(calculator);
    }

    function inputDecimal(dot) {
        // If the `displayValue` does not contain a decimal point
        if (!calculator.displayValue.includes(dot)) {
            // Append the decimal point
            calculator.displayValue += dot;
        }
    }

    function handleOperator(nextOperator) {
        const {
            firstOperand,
            displayValue,
            operator
        } = calculator
        const inputValue = parseFloat(displayValue);

        if (operator && calculator.waitingForSecondOperand) {
            calculator.operator = nextOperator;
            console.log(calculator);
            return;
        }

        if (firstOperand == null) {
            calculator.firstOperand = inputValue;
        } else if (operator) {
            const currentValue = firstOperand || 0;
            const result = performCalculation[operator](currentValue, inputValue);

            calculator.displayValue = String(result.toFixed(2));
            calculator.firstOperand = result;
        }

        calculator.waitingForSecondOperand = true;
        calculator.operator = nextOperator;
        console.log(calculator);
    }

    function updateDisplay() {
        const display = document.querySelector('.calculator-screen');
        display.value = calculator.displayValue;
    }
    function resetCalculator() {
        calculator.displayValue = '0';
        calculator.firstOperand = null;
        calculator.secondOperand = null;
        calculator.currentValue = 0;
        calculator.waitingForSecondOperand = false;
    }

    updateDisplay();

    //code for button clicks
    const keys = document.querySelector('.calculator-keys');
    keys.addEventListener('click', (event) => {
        const {
            target
        } = event;
        if (!target.matches('button')) {
            return;
        }
        if (target.classList.contains('operator')) {
            handleOperator(target.value);
            updateDisplay();
            return;
        }
        if (target.classList.contains('decimal')) {
            inputDecimal(target.value);
            updateDisplay();
            return;
        }
        if (target.classList.contains('all-clear')) {
            resetCalculator();
            updateDisplay();
            return;
        }
        inputDigit(target.value);
        updateDisplay();
    });

    //code for keydown events
    document.getElementById("calcModal").addEventListener('keydown', function(event) {
        var key = event.key.toString();

        if (key == '<{$sepComma}>') {
            inputDecimal('.');
            updateDisplay();
            return;
        }
        if (key == '+' || key == '-' || key == '/' || key == '*') {
            handleOperator(event.key);
            updateDisplay();
            return;
        }
        if (key == 'Enter') {
            handleOperator('=');
            updateDisplay();
            return;
        }
        if (key == 'Delete') {
            resetCalculator();
            updateDisplay();
            return;
        }
        if (key == '0' || key == '1' || key == '2' || key == '3' || key == '4' || key == '5' || key == '6' || key == '7' || key == '8' || key == '9') {
            //alculator.waitingForSecondOperand = false;
            inputDigit(event.key);
            updateDisplay();
            return;
        }
        if (key == '<{$sepThousand}>') {
            //ignore thousands
            return;
        }
        //alert($key);
    }, true);

    //code for applying result to field of calling form
    $(function () {
        $("#btnApplyResult").click(function () {
            const display = document.querySelector('.calculator-screen');
            $result = display.value;
            $result = $result.replace(".", "<{$sepComma}>");
            document.getElementById("tra_amount").value = $result;
        });
    });
</script>
<!-- End code for calc modal -->