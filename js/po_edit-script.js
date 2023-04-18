"use strict";

const buttonAddItem = document.querySelector(".button--insert__item");
const containerModalAddItem = document.querySelector(".container--modal");
const modalAddItem = document.querySelector(".modal--add__item");
const buttonCloseModal = document.querySelector(".close--modal");
const containerItemList = document.querySelector(".container--itemlist");
const inputSearch = document.querySelector(".input--search");
const tableItemTb = document.querySelector(".po__table");
const inputPoId = document.querySelector("#po_id");

const formatNumber = (string) => {
  const NumOptions = {
    style: "decimal",
    currency: "PHP",
    minimumFractionDigits: 2,
  };
  return new Intl.NumberFormat("en-US", NumOptions).format(string);
};

const fetchTableData = (tableType, container, renderFunction, input = "") => {
  fetch(`php/search${tableType}.php?q=${encodeURIComponent(input)}`)
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
                          <td class='qty'>${formatNumber(data.qty)}</td>
                          <td class='unit'>${data.unit_name}</td>
                          <td class='location'>${data.loc_name}</td>
                          <td class='cost'>${formatNumber(data.cost)}</td>
                    </tr>`
    );
  });
};

// Editing Table values
const rowEdit = function (e) {
  const target = e.target.closest(".td__edit");
  const itemName = target
    .closest("tr")
    .querySelector(".td__readonly--itemname");
  const productId = target
    .closest("tr")
    .querySelector(".td__readonly--productid");
  const qty = target.closest("tr").querySelector(".input__edit--qty");
  const cost = target.closest("tr").querySelector(".input__edit--cost");
  const discpercent = target
    .closest("tr")
    .querySelector(".input__edit--discpercent");
  const discount = target.closest("tr").querySelector(".input__edit--discount");
  const subtotal = target.closest("tr").querySelector(".input__edit--total");
  const tdTotalCost = target
    .closest("tr")
    .querySelector(".td__compute--totalcost");
  const tdDiscount = target
    .closest("tr")
    .querySelector(".td__compute--discount");
  const tdSubTotal = target
    .closest("tr")
    .querySelector(".td__compute--subtotal");

  const computeTotalCost = (qty, cost) => {
    return qty * cost;
  };
  const computeDiscountVal = (discpercent, totalCost) => {
    discount.value = totalCost * (discpercent / 100);
    return discount.value;
  };
  const computeSubTotal = (totalCost, DiscountVal) => {
    subtotal.value = totalCost - DiscountVal;
    return subtotal.value;
  };

  // Return if there's no target
  if (!target) return;

  // Function -- changing value data
  const changeValue = function (inputName, promptMessage) {
    let newValue = prompt(promptMessage);

    // Return if invalid input
    if (!newValue || newValue.includes(" ") || newValue === NaN) return;

    target.innerHTML = formatNumber(newValue);

    const targetInput = target
      .closest("tr")
      .querySelector(`.input__edit--${inputName}`);

    targetInput.value = newValue;

    const totalCost = computeTotalCost(qty.value, cost.value);
    const discountValue = computeDiscountVal(discpercent.value, totalCost);
    const subTotal = computeSubTotal(totalCost, discountValue);

    tdTotalCost.innerHTML = formatNumber(totalCost);
    tdDiscount.innerHTML = formatNumber(discountValue);
    tdSubTotal.innerHTML = formatNumber(subTotal);
  };

  if (target.classList.contains("td__edit--qty")) {
    changeValue("qty", "Enter New Qty-Order");
  }

  if (target.classList.contains("td__edit--cost")) {
    changeValue("cost", "Enter New Cost");
  }

  if (target.classList.contains("td__edit--discpercent")) {
    changeValue("discpercent", "Enter New Discount");
  }

  if (target.classList.contains("td__edit--delete")) {
    const confirmDelete = confirm(
      `ARE YOU SURE YOU WANT TO REMOVE THE FOLLOWING?\n\n${itemName.innerHTML}?`
    );

    if (!confirmDelete) return;

    fetch("php/po_edit-inc.php", {
      method: "POST", // or 'PUT'
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: `delete&productId=${productId.innerHTML}&poId=${inputPoId.value}`,
    }).then(() => location.reload());
  }
};

// Modal Display
const modalOpen = function (e) {
  e.preventDefault();
  containerModalAddItem.classList.add("modal--active");
  showData("php/searchitem.php", "", containerItemList);
};

const modalClose = function () {
  containerModalAddItem.classList.remove("modal--active");
};

const searchItem = function () {
  const queue = inputSearch.value;
  fetchTableData("item", containerItemList, renderItem, queue);
};

const hasDuplicate = function (productId, table) {
  const orderRow = table.querySelectorAll("tr");
  // There's no order in the table
  if (!orderRow.length) return false;

  let duplicate;
  orderRow.forEach((row) => {
    if (+row.children[0].innerHTML === productId) duplicate = true;
  });

  return duplicate;
};

// Function for selecting item and adding to table
const selectItem = function (e) {
  // Select Row
  const targetItem = e.target.closest("tr");

  // Get Values to add on Order List
  const itemCode = targetItem.querySelector(".item-code").innerHTML;
  const itemName = targetItem.querySelector(".item-name").innerHTML;
  const itemUnit = targetItem.querySelector(".unit").innerHTML;
  const itemCost = targetItem.querySelector(".cost").innerHTML;

  // Check for duplicate entries
  if (hasDuplicate(+itemCode, tableItemTb))
    return alert(`${itemName} is already added.`);

  const poQty = prompt("Enter Order Quantity");
  const poCost = prompt("Enter Cost");
  const poDis = prompt("Enter Discount in %");
  const itemDiscPercent = 0;
  const itemDiscVal = 0;
  const disval = poDis / 100;
  const totalCost = poQty * poCost;
  const subTotal = +totalCost - +itemDiscVal;

  // Insert selected values into table
  tableItemTb.querySelector("tbody").insertAdjacentHTML(
    "beforeend",
    `<tr>
    <td class='td__readonly td__readonly--productid'>${itemCode}</td>
    <td class='td__readonly td__readonly--itemname'>${itemName}</td>
    <td class='td__edit td__edit--qty'>${formatNumber(poQty)}</td>
    <td class="unit">${itemUnit}</td>
    <td class='td__edit td__edit--cost'>${formatNumber(poCost)}</td> 
    <td class='td__compute td__compute--totalcost'>${formatNumber(
      totalCost
    )}</td>
    <td class='td__edit td__edit--discpercent'>${formatNumber(
      poDis
    )}</td>
    <td class='td__compute td__compute--discount'>${formatNumber(
      disval
    )}</td>
    <td class='td__compute td__compute--subtotal'>${formatNumber(subTotal)}</td>
    <td class='td__edit td__edit--delete'>
    <i class='bi bi-x-circle' title='Delete'></i>
    </td>
    <input type='hidden' name='productId[]' value='${itemCode}'>
    <input type='hidden' name='qtyIn[]' value='${poQty}'  class='input__edit input__edit--qty'>
    <input type='hidden' name='itemCost[]' value='${poCost}' class='input__edit input__edit--cost'>
    <input type='hidden' name='itemDiscpercent[]' value='${poDis}' class='input__edit input__edit--discpercent'>
    <input type='hidden' name='itemDisamount[]' value='${disval}' class='input__edit input__edit--discount'>
    <input type='hidden' name='itemTotal[]' value='>${subTotal}' class='input__edit input__edit--total'>
    </tr>
    `
  );

  // Close the modal
  modalClose();
};

const showData = function (file, input, container) {
  // Create an XMLHttpRequest object
  const xhttp = new XMLHttpRequest();

  // Define a callback function
  xhttp.addEventListener("load", function () {
    const data = JSON.parse(this.responseText);
    showTableData(data, container);
  });

  // Send a request
  xhttp.open("POST", file + `?q=${input}`);
  xhttp.send();
};

const showTableData = (data, container) => {
  container.innerHTML = "";
  console.log(data);

  data.forEach((data, index) => {
    let row = `<tr class='product-data product${index}' data-id ='${data.product_id
      }'>
                    <td class='item-code'>${data.product_id.padStart(8, 0)}</td>
                    <td class='item-name'>${data.product_name}</td>
                    <td class='qty'>${formatNumber(data.qty)}</td>
                    <td class='unit'>${data.unit_name}</td>
                    <td class='location'>${data.loc_name}</td>
                    <td class='cost'>${formatNumber(data.cost)}</td>
              </tr>`;
    container.innerHTML += row;
  });
};

buttonAddItem.addEventListener("click", modalOpen);

buttonCloseModal.addEventListener("click", modalClose);

inputSearch.addEventListener("keyup", searchItem);

containerItemList.addEventListener("dblclick", selectItem);

tableItemTb.querySelector("tbody").addEventListener("click", rowEdit);
