var num1 = null; 
var num2 = null; 
var operator = null;
var total = 0;
var screenDisplay = '';
var numPeriod = 0;


$(document).ready(function() {
  $('#calc-clear').on('click', function () {
    reset()
    displayScreen(total);
  });

  $('.digit').on('click', function (e) { 
    handleDigit(e);
  });

  $('.decPoint').on('click', function (e) {
    // Only add the decimal point if there is none present
    if (numPeriod == 0) {
      handleDigit(e);
      numPeriod++;
    }
  })

  $('.operation').on('click', function (e) {
    if (num1 == null) {
      return;
    } else if (num2 == null) {
      operator = e.target.id;
      displayScreen(num1 + operator);
      console.log({num1, operator, num2, total})
    } else {
      /* If both num1 and num2 are full, then push the 
      existing value to num1 and save the operator */
      num1 = compute(num1, num2);
      operator = e.target.id;
      num2 = null;
      displayScreen(num1 + operator);
      // console.log({num1, operator, num2, total})
    }
  });

  $('.equal').on('click', function (e) {
    if (num1) {
      if (!operator) {
        total = num1;
        displayScreen(num1);
        // console.log({num1, operator, num2, total})
        return;
      }
    }

    total = compute(num1, num2);
    displayScreen(total);

    operator = null;
    num1 = total;
    num2 = null;
  });
});

function compute(stringA, stringB) {
  let a = parseFloat(stringA);
  let b = parseFloat(stringB);

  switch (operator) {
    case "/":
      return (a / b).toFixed(2);
    case "-":
      return (a - b).toFixed(2);
    case "+":
      return (a + b).toFixed(2);
    case "*":
      return (a * b).toFixed(2);
    default:
      break;
  }
}

function displayScreen(text) {
  $('.calc-screen').text(text);
  screenDisplay = text.toString();
}

function handleDigit(e) {
  if (num1 == null) {
    num1 = e.target.value;
    displayScreen(num1);
    // console.log({num1, operator, num2, total})
  } else if (operator == null) {
      num1 += e.target.value;
      displayScreen(num1);
      // console.log({num1, operator, num2, total})
  } else {
    if (num2 == null) {
      num2 = e.target.value;
      displayScreen(num1 + operator + num2);
      // console.log({num1, operator, num2, total})
    } else {
      num2 += e.target.value;
      displayScreen(num1 + operator + num2);
      // console.log({num1, operator, num2, total})
    }
  }
}

function reset() {
  num1 = null;
  num2 = null;
  operator = null;
  total = 0;
  numPeriod = 0;
}