import formatNumber from './helpers.js';

function getTotalQty() {
  const inputQty = document.querySelectorAll('.input--qty');

  const qtyArr = [];

  inputQty.forEach((el) => {
    qtyArr.push(el.closest('tr').querySelector('.input--qty').value);
  });

  const totalQty = qtyArr
    .map((subtotal) => Number(subtotal.replace(',', '')))
    .reduce((prev, curr) => prev + curr);

  return totalQty;
}

function updateGrandTotal() {
  const tableTotal = document.querySelectorAll('.lbl--table__total');
  const lblGrandTotal = document.querySelector('.lbl--grand__total');
  const total = [];

  tableTotal.forEach((el) => {
    total.push(el.innerText);
  });

  const grandTotal = total
    .map((subtotal) => Number(subtotal.replaceAll(',', '')))
    .reduce((prev, curr) => prev + curr);

  lblGrandTotal.innerText = '₱ ' + formatNumber(grandTotal);
}

function updateTableSubtotal(target) {
  const lblRowSubtotal = target
    .closest('.table__container')
    .querySelectorAll('.label--subtotal');

  const lblTableSubtotal = target
    .closest('.table__container')
    .querySelector('.lbl--table__total');

  const total = [];
  lblRowSubtotal.forEach((el) => {
    total.push(el.innerText);
  });

  const subtotal = total
    .map((subtotal) => Number(subtotal.replaceAll(',', '')))
    .reduce((prev, curr) => prev + curr);

  lblTableSubtotal.innerText = formatNumber(subtotal);
}

function updateRowSubtotal(target) {
  const lblUnitPrice = target.closest('tr').querySelector('.label--price');
  const lblSubTotal = target.closest('tr').querySelector('.label--subtotal');
  const inputQty = target.closest('tr').querySelector('.input--qty');

  const newValue =
    Number(lblUnitPrice.innerText.replace(',', '')) * Number(inputQty.value);

  lblSubTotal.innerText = formatNumber(newValue);

  updateTableSubtotal(target);
}

function update(target) {
  updateRowSubtotal(target);
  updateGrandTotal();
}

function editQty(e) {
  const target = e.target;
  const newValue = Math.round(target.value);
  if (Number(newValue) > Number(target.max)) {
    target.value = target.max;
    update(target);
    return alert(`You can't input number higher than ${target.max}`);
  }

  if (Number(newValue) < Number(target.min)) {
    target.value = target.min;
    update(target);
    return alert(`You can't input number lower than ${target.min}`);
  }

  target.value = newValue;

  update(target);
}

function init() {
  const inputQty = document.querySelectorAll('.input--qty');

  updateGrandTotal();

  inputQty.forEach((element) => {
    element.addEventListener('change', editQty);
  });
}

init();
