<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Simple Online Calculator Example</title>

    <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"></script>
    <script src="main.js"></script>
    <link rel="stylesheet" href="style.css">

</head>

<div class="jquery-script-clear"></div>


    <div class="calc-container">
        <div class="calc-row">
            <button id="clear" value="">AC</button>
            <div class="calc-screen"></div>
        </div>
        <div class="calc-row">
            <button class="digit" value="7">7</button>
            <button class="digit" value="8">8</button>
            <button class="digit" value="9">9</button>
            <button class="operation" id="/">/</button>
        </div>
        <div class="calc-row">
            <button class="digit" value="4">4</button>
            <button class="digit" value="5">5</button>
            <button class="digit" value="6">6</button>
            <button class="operation" id="-">-</button>
        </div>
        <div class="calc-row">
            <button class="digit" value="1">1</button>
            <button class="digit" value="2">2</button>
            <button class="digit" value="3">3</button>
            <button class="operation" id="+">+</button>
        </div>
        <div class="calc-row">
            <button class="digit" value="0">0</button>
            <button class="decPoint" value=".">.</button>
            <button class="equal" id="eql">=</button>
            <button class="operation" id="*">*</button>
        </div>
    </div>

</body>
</html>
