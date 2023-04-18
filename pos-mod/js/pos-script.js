"use strict";

// OBJECTS
const transaction = {
  joId: 0,
  customerId: 0,
  transactionId: 0,
  transDate: "",
};

const order = {
  productId: [],
  qty: [],
  discount: [],
  price: [],
  total: 0,
};

const paymentId = [];

const payment = {
  type: 1,
  id: 0,
  tendered: 0,
  balance: 0,
  change: 0,
  status: 0,
};

const online = {
  platform: "",
  reference: "",
  paymentDate: "",
};

const cheque = {
  bank: "",
  chequeNumber: "",
  chequeDate: "",
};

const NumOptions = {
  style: "decimal",
  currency: "PHP",
  minimumFractionDigits: 2,
};

const qtyHistory = [];

// ELEMENTS

// Nav
const nav = document.querySelector(".nav-bar");
const navOptions = document.querySelectorAll(".nav__button");
const tabPayment = document.querySelector(".nav__button--payment");
const tabPos = document.querySelector(".nav__button--pos");

// Tab Content
const tabContent = document.querySelectorAll(".tab__content");

//---------------------------POS ELEMENTS---------------------------------

//customers
const inputCustomerId = document.querySelector("#customerId");
const inputCustomerName = document.querySelector("#customerName");
const inputCustomerAddress = document.querySelector("#customerAddress");
const inputCustomerContact = document.querySelector("#customerContact");
const btnSearchCustomer = document.querySelector(".btn-search_customer");
const containerCustomerList = document.querySelector("#customer-list");
const inputSearchCustomer = document.querySelector("#searchCustomer");
const rowCustomerList = document.querySelector("tr.customer-data");

//modal
const modalCustomer = document.querySelector("#customerModal");
const btnCustomerClose = document.querySelector(".customer__modal--close");
const btnNewCustomer = document.querySelector(".button--new__customer");

//transaction
const inputTransNumber = document.querySelector("#transactionNumber");

//product table
const inputSearchProduct = document.querySelector(".input-search_item");
const containerProductList = document.querySelector(".product-list");

//order table
const containerOrderList = document.querySelector(".container-order-list");
const btnDeleteRow = document.querySelector(".delete");

//summary
const containerSummary = document.querySelector(".fieldset-summary");
const labelSubtotal = document.querySelector(".subtotal-value").children[0];
const labelGrossAmount = document.querySelector(".gross_amount-value")
  .children[0];
const labelTotalQty = document.querySelector(".total_qty-value").children[0];
const labelTaxAmount = document.querySelector(".tax-value").children[0];
const labelNetSales = document.querySelector(".netsales-value").children[0];
const labelDiscount = document.querySelector(".disc_amount-value").children[0];
const smryLabelPayable = document.querySelector(".label-total_payable");
const smryDiscount = containerSummary.querySelector(
  ".input__summary--discount"
);
const smryQty = containerSummary.querySelector(".input__summary--qty");
const smryGross = containerSummary.querySelector(".input__summary--gross");
const smrySubtotal = containerSummary.querySelector(
  ".input__summary--subtotal"
);
const smryTax = containerSummary.querySelector(".input__summary--tax");
const smryNetSales = containerSummary.querySelector(
  ".input__summary--netsales"
);

//buttons
const btnSaveTransaction = document.querySelector(".btn-save");

//--------------------------- PAYMENT ELEMENTS ---------------------------------

const containPendingTrans = document.querySelector(".transaction-list");
const tblTransaction = document.querySelector(".tbl-transaction");
const btnPaymentType = document.querySelector(".button-pay-option");
const rowOptions = document.querySelector(".options");
const modalPayment = document.querySelector("#payment-modal");
const paymentModalClose = document.querySelector(".payment__modal--close");
const labelPaymentBalance = document.querySelector(".payment-balance");
const btnSavePayment = document.querySelector(".button__save--payment");
const inputPaymentTendered = document.querySelector(".payment-tendered");
const inputPaymentChange = document.querySelector(".payment-change");
const labelChangeBalance = document.querySelector(".change-balance");
const inputTransSearch = document.querySelector(".pending__payments--search");

//radio button
const containerPayOption = document.querySelector(".container-radio-button");
const radioCash = document.querySelector("input#cash");
const radioOnline = document.querySelector("input#online");
const radioCheque = document.querySelector("input#cheque");
const fieldsetOnline = document.querySelector("fieldset.online-details");
const fieldsetBank = document.querySelector("fieldset.bank-details");
const radioPaymentType = document.querySelectorAll(".radio--payment-type");

// Payment Inputs Fields
const selectOnlinePlatform = document.querySelector("#onlinePlatform");
const onlineTransactionDate = document.querySelector(".transaction-date");
const onlineReferenceNumber = document.querySelector(".reference-number");
const selectBankName = document.querySelector("#bankName");
const inputChequeDate = document.querySelector(".cheque-date");
const inputChequeNumber = document.querySelector(".cheque-number");

// ---------------------------------- FUNCTION ---------------------------------
const fetchTableData = (tableType, container, renderFunction, input = "") => {
  fetch(`php/search-${tableType}.php?q=${encodeURIComponent(input)}`)
    .then((response) => {
      return response.json();
    })
    .then((data) => {
      renderFunction(data, container);
    })
    .catch(() => {
      container.innerHTML = "";
    });
};

const openCustModal = function () {
  modalCustomer.classList.add("modal--active");

  fetchTableData("customer", containerCustomerList, renderCustomer);
};

const closeCustModal = function () {
  const selectedData = document.querySelector(".customer-data.selected");

  modalCustomer.classList.remove("modal--active");

  if (!selectedData) return;

  inputCustomerId.value = selectedData.children[0].innerHTML;
  inputCustomerName.value = selectedData.children[1].innerHTML;
  inputCustomerContact.value = selectedData.children[3].innerHTML;
  inputCustomerAddress.value = selectedData.children[2].innerHTML;
};

// Open Add Customer Tab
const addNewCustomer = function (e) {
  e.preventDefault();

  window.open(
    "../utilities/bo_customer.php",
    "Add Customer",
    "toolbar=no,location=no,width=1500,height=1000,scrollbars=yes"
  );
};

const renderCustomer = function (data, container) {
  container.innerHTML = "";
  data.forEach((data, index) => {
    container.insertAdjacentHTML(
      "beforeend",
      `<tr class='customer-data' id='customer${index}'>
            <td>${data.customers_id.padStart(8, 0)}</td>
            <td>${data.customers_name}</td>
            <td>${data.customers_address}</td>
            <td>${data.customers_contact}</td>
            </tr>`
    );
  });
};

const renderItem = function (data, container) {
  container.innerHTML = "";
  data.forEach((data, index) => {
    container.insertAdjacentHTML(
      "beforeend",
      `<tr class='product-data product${index}'>
                          <td class='item-code'>${data.product_id.padStart(
        8,
        0
      )}</td>
                          <td class='item-name'>${data.product_name}</td>
                          <td class='price'>${(+data.price).toFixed(2)}</td>
                          <td class='qty'>${data.qty}</td>
                          <td class='unit'>${data.unit_name}</td>
                          <td class='location'>${data.loc_name}</td>
                    </tr>`
    );
  });
};

// Update total
const updateRowTotal = (rowIndex) => {
  const targetRow = containerOrderList.rows[rowIndex - 1];

  const rowTotal = targetRow.querySelector(".total");
  const newRowGross =
    +removeComma(targetRow.querySelector(".price").innerHTML) *
    +removeComma(targetRow.querySelector(".qty").innerHTML);
  console.log(newRowGross);
  const prevTotal = rowTotal.innerHTML;
  const rowPrice = removeComma(targetRow.querySelector(".price").innerHTML);
  const rowDiscount = removeComma(
    targetRow.querySelector(".discount").innerHTML
  );
  const rowQty = removeComma(targetRow.querySelector(".qty").innerHTML);

  const newTotal = rowPrice * rowQty - rowDiscount;
  rowTotal.innerHTML = formatNumber(newTotal);

  return [newTotal, prevTotal, newRowGross];
};

const editOrder = function (e, selector) {
  if (selector === "delete") return deleteOrder(e);

  const target = e.target.closest("tr").querySelector(`.${selector}`);

  const targetIndex = e.target.closest("tr").rowIndex;
  const targetRow = containerOrderList.rows[targetIndex - 1];
  const prevRowGross =
    +removeComma(targetRow.querySelector(".price").innerHTML) *
    +removeComma(targetRow.querySelector(".qty").innerHTML);

  console.log(prevRowGross);
  const prevValue = removeComma(target.innerHTML);
  let newValue = prompt("Enter New Value");

  if (
    !newValue ||
    newValue === "null" ||
    newValue.includes(" ") ||
    isNaN(newValue)
  )
    return;

  console.log(qtyHistory, targetIndex);
  if (selector == "qty")
    if (+newValue > +qtyHistory[targetIndex - 1])
      return alert(
        `Value cannot exceed job order quantity!\nMaximum Quantity: ${qtyHistory[targetIndex - 1]
        }`
      );

  target.innerHTML = formatNumber(newValue);

  return [
    selector,
    prevValue,
    newValue,
    prevRowGross,
    ...updateRowTotal(targetIndex),
  ];
};

const deleteOrder = function (e) {
  const target = e.target.closest("tr");
  const targetQty = target.querySelector(".qty");
  const targetDiscount = target.querySelector(".discount");
  const targetPrice = target.querySelector(".price");
  const targetTotal = target.querySelector(".total");
  const totalItemGross =
    +removeComma(targetPrice.innerHTML) * +removeComma(targetQty.innerHTML);

  // Subtract Qty, Discount, and Total from summary
  const newSmryQty =
    +removeComma(smryQty.value) - +removeComma(targetQty.innerHTML);
  const newSmryDiscount = subtractNFormat(
    smryDiscount.value,
    targetDiscount.innerHTML
  );
  const newSmryGross = +removeComma(smryGross.value) - +totalItemGross;
  const newNetSales = subtractNFormat(
    smryNetSales.value,
    targetTotal.innerHTML
  );

  // Display Value
  smryQty.value = formatNumber(newSmryQty);
  smryDiscount.value = newSmryDiscount;
  smryGross.value = formatNumber(newSmryGross);
  smryNetSales.value = newNetSales;
  smryLabelPayable.textContent = `${smryNetSales.value}  PHP`;

  computeTax();

  // Remove row
  target.remove();
};

const computeTax = function () {
  const totalGross = +removeComma(smryGross.value);
  const subTotal = totalGross / 1.12;
  const totalTax = totalGross - subTotal;

  smrySubtotal.value = formatNumber(subTotal.toFixed(2));
  smryTax.value = formatNumber(totalTax.toFixed(2));
};

// Update the summary based
const updateSummary = function ([
  selector,
  prevValue,
  newValue,
  prevRowGross,
  newTotal,
  prevTotal,
  newRowGross,
]) {
  let newQtyVal,
    prevQtyVal,
    prevGrossVal,
    newDiscountVal,
    prevDiscountVal,
    newRowTotal,
    newPriceVal,
    prevNetVal;

  const updateNetVal = function () {
    prevNetVal = removeComma(smryNetSales.value); // 0
    newRowTotal = newTotal - removeComma(prevTotal); // 23 - 0 = 0
    smryNetSales.value = formatNumber(+prevNetVal + +newRowTotal);
  };

  const updateGross = function () {
    // Gross formula : Gross amount * qty
    const newGrossVal = newRowGross - prevRowGross;
    const prevGrossVal = +removeComma(smryGross.value);

    smryGross.value = formatNumber(+prevGrossVal + +newGrossVal);
  };

  switch (selector) {
    case "qty":
      // Add newValue to qty summary
      newQtyVal = removeComma(newValue) - removeComma(prevValue);
      prevQtyVal = removeComma(smryQty.value);

      smryQty.value = formatNumber(+prevQtyVal + newQtyVal);

      updateGross();
      updateNetVal();
      computeTax();
      break;
    case "price":
      updateGross();
      updateNetVal();
      computeTax();

      break;
    case "discount":
      // Add newValue to discount summary
      newDiscountVal = removeComma(newValue) - removeComma(prevValue);
      prevDiscountVal = removeComma(smryDiscount.value);

      smryDiscount.value = formatNumber(+prevDiscountVal + newDiscountVal);
      updateGross();

      updateNetVal();
      computeTax();

      break;
    default:
      break;
  }

  smryLabelPayable.textContent = `${smryNetSales.value}  PHP`;
};

const hasDuplicateOrder = function (productId) {
  console.log(productId);
  const orderRow = containerOrderList.querySelectorAll("tr");
  // There's no order in the table
  if (!orderRow.length) return false;

  let duplicate;
  orderRow.forEach((row) => {
    if (+row.children[0].innerHTML === productId) duplicate = true;
  });

  return duplicate;
};

const orderCancel = function (orderId) {
  // Pop up Message for confirmation
  const confirmAction = confirm(
    `You are about to DELETE Transaction Number ${orderId.padStart(8, 0)}. 
    ARE YOU SURE?`
  );

  // Change order Status into cancelled
  if (confirmAction) {
    // const update = new XMLHttpRequest();
    // update.open("POST", "php/order-cancel.php");
    // update.setRequestHeader(
    //   "Content-type",
    //   "application/x-www-form-urlencoded"
    // );
    // update.send(`orderId=${orderId}`);

    fetch("php/order-cancel.php", {
      method: "POST", // or 'PUT'
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: `orderId=${orderId}`,
    })
      .then((res) => {
        return res.text();
      })
      .then((data) => {
        alert(data);
        location.reload();
      });
  }
};

const orderPay = function (orderId, rowIndex, balance) {
  order.orderId = +orderId;
  payment.id = paymentId[rowIndex];
  inputPaymentTendered.value = "";
  inputPaymentChange.value = "";
  labelChangeBalance.textContent = "Change:";
  modalPayment.style.display = "block";
  labelPaymentBalance.value = formatNumber(balance.replaceAll(",", ""));
  inputPaymentTendered.focus();
};

// Check if Row already have DR number
const checkDrNumber = async function (orderId) {
  const res = await fetch(`php/check-dr.php?checkDr&orderId=${orderId}`);
  const data = await res.text();

  return data;
};

// Get DR number from users
const getDrNumber = async function (orderId) {
  const drStatus = await checkDrNumber(orderId);
  if (drStatus != "0") return orderView(orderId);

  let drNumber = 0;

  while (!drNumber || !drNumber.match(/^[0-9]/)) {
    drNumber = prompt("Enter DR Number: ");
    if (!drNumber || !drNumber.match(/^[0-9]/)) alert("Invalid Format");
  }

  // Save Data to Database
  const res = await fetch(
    `php/save-dr.php?saveDr&drNumber=${drNumber}&orderId=${orderId}`
  );
  const data = await res.text();

  orderView(data);
};

const orderView = function (orderId) {
  window.open(`php/viewdr2.php?printPOS&id=${+orderId}`);
};

const savePayment = function (e) {
  e.preventDefault();
  payment.tendered = Number(inputPaymentTendered.value.replace(",", ""));
  payment.balance = Number(inputPaymentChange.value.replace(",", ""));
  payment.date = new Date().toISOString();

  if (!payment.tendered) {
    alert("Invalid tendered amount!");
    return;
  }

  // Online Details
  online.platform = +selectOnlinePlatform.value;
  online.reference = onlineReferenceNumber.value;
  online.paymentDate = onlineTransactionDate.value;

  // Checque Details
  cheque.bank = selectBankName.value;
  cheque.chequeDate = inputChequeDate.value;
  cheque.chequeNumber = inputChequeNumber.value;

  const save = new XMLHttpRequest();
  const paymentJSON = { ...payment, ...order, ...online, ...cheque };

  save.onload = function () {
    const paymentDetails = JSON.parse(this.responseText);
    console.log(paymentDetails);
    alert(
      `Payment Reference: PR-${paymentDetails.order_payment_id.padStart(8, 0)}`
    );

    location.reload();
  };

  save.open("POST", "php/save-payment.php");
  save.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  save.send(`json=${JSON.stringify(paymentJSON)}`);

  console.log(JSON.stringify(paymentJSON));
  console.log(paymentJSON);
  alert("Payment Saved!");
};

//initialization
const init = function () {
  getTransNumber();

  containerOrderList.innerHTML = "";

  document.querySelector("#transactionDate").value = getCurrDate();

  fetchTableData("product", containerProductList, renderItem);
};

const getTransNumber = function () {
  const xhttp = new XMLHttpRequest();

  xhttp.onload = function () {
    const data = JSON.parse(this.responseText);

    inputTransNumber.value = `${Number(data.order_id) + 1}`.padStart(10, 0);
  };

  xhttp.open("GET", "php/auto-order-id.php");
  xhttp.send();
};

const getCurrDate = function () {
  const currDate = new Date();
  return currDate.toDateString();
};

const selectRow = function (target) {
  // Remove selected
  const checkSelected = document.querySelectorAll("tr.customer-data");
  checkSelected.forEach((row) => {
    row.classList.remove("selected");
  });

  // Add selected
  const selectedRow = target.closest("tr");
  selectedRow.classList.add("selected");
};

//remove comma and convert string to number
const removeComma = (string) => (+string.replaceAll(",", "")).toFixed(2);

const formatNumber = (string) =>
  new Intl.NumberFormat("en-US", NumOptions).format(string);

//request data from database
const showPaymentData = function (file, input, container) {
  // Create an XMLHttpRequest object
  const xhttp = new XMLHttpRequest();

  // Define a callback function
  xhttp.onload = function () {
    const data = JSON.parse(this.responseText);
    showPendingPayments(data, container);
  };

  // Send a request
  xhttp.open("POST", file);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send(`q=${input}`);
};

const subtractNFormat = function (n1, n2) {
  const diff = +removeComma(n1) - +removeComma(n2);

  return formatNumber(diff);
};

//show requested data from database on table
const showPendingPayments = (data, container) => {
  container.innerHTML = "";

  data.forEach((data) => {
    paymentId.push(data.order_payment_id);
    const transDate = new Date(data.pos_date).toLocaleString();
    let row = `<tr>
                          <td class="transaction-number">${data.order_id.padStart(
      8,
      0
    )}</td>
                          <td class="customer-name">${data.customers_name}</td>
                          <td class="total">${formatNumber(data.total)}</td>
                          <td class="balance">${formatNumber(
      data.order_payment_balance
    )}</td>
                          <td class="date">${transDate}</td>
                          <td class="table__options">
                          <span class="table__option table__option--pay">PAY</span>|
                       
                          <span class="table__option table__option--view">VIEW</span>
                          </td>

                    </tr>`;
    container.innerHTML += row;
  });
};

//disable inputs
const disablePaymentGroup = (group) => {
  switch (group) {
    case "online":
      document.querySelector("#onlinePlatform").setAttribute("disabled", "");
      document.querySelector(".transaction-date").setAttribute("disabled", "");
      document.querySelector(".reference-number").setAttribute("disabled", "");
      fieldsetOnline.style.opacity = 0.5;
      break;
    case "cheque":
      document.querySelector("#bankName").setAttribute("disabled", "");
      document.querySelector(".cheque-date").setAttribute("disabled", "");
      document.querySelector(".cheque-number").setAttribute("disabled", "");
      fieldsetBank.style.opacity = 0.5;
  }
};

//enable inputs
const enablePaymentGroup = (group) => {
  switch (group) {
    case "online":
      document.querySelector("#onlinePlatform").removeAttribute("disabled");
      document.querySelector(".transaction-date").removeAttribute("disabled");
      document.querySelector(".reference-number").removeAttribute("disabled");
      fieldsetOnline.style.opacity = 1;

      break;
    case "cheque":
      document.querySelector("#bankName").removeAttribute("disabled");
      document.querySelector(".cheque-date").removeAttribute("disabled");
      document.querySelector(".cheque-number").removeAttribute("disabled");
      fieldsetBank.style.opacity = 1;
  }
};

// ---------------------------------- POS EVENTS / DECLARATIONS ---------------------------------

//initialization
init();

// EVENTS

// Nav Options
nav.addEventListener("click", function (e) {
  const clicked = e.target.closest(".nav__button");

  if (!clicked) return;

  // Remove Active
  navOptions.forEach((el) => el.classList.remove("nav__button--active"));
  tabContent.forEach((el) => el.classList.remove("tab__content--active"));

  // Active Tab Button
  clicked.classList.add("nav__button--active");

  // Active Content
  document
    .querySelector(`.tab__content--${clicked.dataset.tab}`)
    .classList.add("tab__content--active");
});

//show customer modal on btn click
btnSearchCustomer.addEventListener("click", openCustModal);

//close customer modal
btnCustomerClose.addEventListener("click", function () {
  closeCustModal();
});

//search customer on customer modal
inputSearchCustomer.addEventListener("keyup", function () {
  fetchTableData("customer", containerCustomerList, renderCustomer, this.value);
});

//select customer from customer modal
containerCustomerList.addEventListener("click", function (e) {
  const target = e.target;
  selectRow(target);
});

//add customer details to customer form on key press (Enter)
document.addEventListener("keyup", function (e) {
  if (e.key === "Enter") closeCustModal();
});

btnNewCustomer.addEventListener("click", addNewCustomer);

//search product from product table
inputSearchProduct.addEventListener("keyup", function () {
  fetchTableData("product", containerProductList, renderItem, this.value);
});

//add product to order list
containerProductList.addEventListener("dblclick", function (e) {
  // Select Row
  const targetItem = e.target.closest("tr");
  // Get Values to add on Order List
  const itemCode = targetItem.querySelector(".item-code").innerHTML;
  const price = targetItem.querySelector(".price").innerHTML;
  const itemName = targetItem.querySelector(".item-name").innerHTML;
  const unit = targetItem.querySelector(".unit").innerHTML;
  // Get values to add automatically to summary

  // console.log(selectedItemCode, selectedItemName, selectedPrice, selectedUnit);

  if (hasDuplicateOrder(+itemCode))
    return alert(`${itemName} is already added.`);

  containerOrderList.insertAdjacentHTML(
    "beforeend",
    `<tr>
    <td class="item-code">${itemCode}</td>
    <td class="item-description">${itemName}</td>
    <td class="td__edit price">${formatNumber(price)}</td>
    <td class="td__edit qty">1</td>
    <td class="unit">${unit}</td>
    <td class="td__edit discount">0.00</td>
    <td class="total">${formatNumber(price)}</td>
    <td class="delete">X</td>
  </tr>`
  );

  // Add to Summary Gross Amount, Qty,
  const prevGross = removeComma(smryGross.value);
  const prevQty = removeComma(smryQty.value);
  const prevNetSales = removeComma(smryNetSales.value);

  smryGross.value = formatNumber(+prevGross + +price);
  smryQty.value = formatNumber(+prevQty + 1);
  smryNetSales.value = formatNumber(+prevNetSales + +price);

  computeTax();

  // Add default value of item to the Label
  smryLabelPayable.textContent = `${smryNetSales.value} PHP`;
});

//click events inside order list
containerOrderList.addEventListener("click", function (e) {
  // const selectedEdit = e.target.className;
  const selectedEdit = e.target.classList;

  // Reject edit if TD has "td__locked" Class name
  if (selectedEdit.contains("td__locked")) return;

  if (selectedEdit.contains("qty")) updateSummary(editOrder(e, "qty"));
  if (selectedEdit.contains("discount"))
    updateSummary(editOrder(e, "discount"));
  if (selectedEdit.contains("price")) updateSummary(editOrder(e, "price"));
  if (selectedEdit.contains("delete")) editOrder(e, "delete");
});

//save button
btnSaveTransaction.addEventListener("click", function (e) {
  e.preventDefault();
  e.stopPropagation();

  //customer is empty
  if (!inputCustomerId.value) return alert("Invalid Customer Details");

  //order list is empty
  if (!containerOrderList.children.length) return alert("No orders selected");

  //add to objects
  transaction.customerId = +inputCustomerId.value;
  transaction.transactionId = +inputTransNumber.value;
  transaction.transDate = new Date().toISOString();
  order.total = +removeComma(smryNetSales.value);

  const orderRow = containerOrderList.querySelectorAll("tr");

  orderRow.forEach((element) => {
    order.productId.push(+element.children[0].innerHTML);
    order.qty.push(+removeComma(element.children[3].innerHTML));
    order.discount.push(+removeComma(element.children[5].innerHTML));
    order.price.push(+removeComma(element.children[2].innerHTML));
  });

  const saveJSON = { ...transaction, ...order };

  // const save = new XMLHttpRequest();
  // save.open("POST", "php/save-transaction.php");
  // save.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  // save.send(`json=${JSON.stringify(saveJSON)}`);
  // console.log(JSON.stringify(saveJSON));
  // console.log(saveJSON);

  fetch("php/save-transaction.php", {
    method: "POST", // or 'PUT'
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `json=${JSON.stringify(saveJSON)}`,
  });

  alert("Transaction Saved");

  location.reload();
});

// --------------------- PAYMENT EVENTS / DECLARATIONS ------------------------

showPaymentData("php/pending-payments.php", "", containPendingTrans);

// Nav Options
nav.addEventListener("click", function (e) {
  const clicked = e.target;
  if (clicked.classList.contains("nav--button-pos")) {
    window.open("../index.html");
  }
});

inputTransSearch.addEventListener("keyup", function () {
  fetchTableData(
    "pending_payments",
    containPendingTrans,
    showPendingPayments,
    this.value
  );
});

containPendingTrans.addEventListener("click", function (e) {
  e.preventDefault();
  const clickedOpt = e.target;
  const balance = e.target.closest("tr").children[3].innerHTML;
  const orderId = e.target.closest("tr").children[0].innerHTML;
  const rowIndex = e.target.closest("tr").rowIndex - 1;

  if (clickedOpt.classList.contains("table__option--pay")) {
    orderPay(orderId, rowIndex, balance);
  }

  if (clickedOpt.classList.contains("table__option--cancel")) {
    orderCancel(orderId);
  }

  if (clickedOpt.classList.contains("table__option--view")) {
    getDrNumber(orderId);
    // orderView(orderId);
  }
});

paymentModalClose.addEventListener("click", function () {
  modalPayment.style.display = "none";
});

// Input Amount Tendered Function
inputPaymentTendered.addEventListener("keyup", function () {
  const change =
    labelPaymentBalance.value.replaceAll(",", "") -
    inputPaymentTendered.value.replaceAll(",", "");

  inputPaymentChange.value = formatNumber(change);

  if (change > 0) {
    labelChangeBalance.textContent = "New Balance:";
    payment.status = 1;
  } else {
    labelChangeBalance.textContent = "Change:";
  }
});

//clear payment tender on click
inputPaymentTendered.addEventListener("focusin", function () {
  inputPaymentTendered.value = "";

  //update change value
  labelChangeBalance.textContent = "New Balance:";
  inputPaymentChange.value = "";
});

//focus out on payment tender input
inputPaymentTendered.addEventListener("focusout", function () {
  if (inputPaymentTendered.value) {
    inputPaymentTendered.value = new Intl.NumberFormat(
      "en-US",
      NumOptions
    ).format(removeComma(inputPaymentTendered.value));
  }

  console.log(inputPaymentTendered.value);
});

//radio button event
containerPayOption.addEventListener("change", function (e) {
  switch (e.target.id) {
    case "online":
      //enable input for online payments
      console.log("online selected");
      enablePaymentGroup("online");
      disablePaymentGroup("cheque");
      payment.type = 2;
      selectOnlinePlatform.focus();
      break;
    case "cheque":
      //enable input for cheque payments
      console.log("check selected");
      disablePaymentGroup("online");
      enablePaymentGroup("cheque");
      payment.type = 3;
      selectBankName.focus();
      break;
    default:
      //disable both online and cheque inputs
      console.log("cash selected");
      disablePaymentGroup("online");
      disablePaymentGroup("cheque");
      payment.type = 1;
      inputPaymentTendered.focus();

      break;
  }
});

containerPayOption.addEventListener("mouseover", function (e) {
  if (e.target.classList.contains("label--payment-type")) {
    e.target.style.color = "blue";
  }
});

containerPayOption.addEventListener("mouseout", function (e) {
  if (e.target.classList.contains("label--payment-type")) {
    e.target.style.color = "black";
  }
});

//save Button
btnSavePayment.addEventListener("click", savePayment);
