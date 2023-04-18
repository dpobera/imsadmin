"use strict";

const inputJoSearch = document.querySelector(".jo__modal--input__search");
const tblJoModal = document.querySelector(".jo__modal--table");
const joModalClose = document.querySelector(".jo__modal--close");
const joModal = document.querySelector(".jo__modal");
const inputJoNumber = document.querySelector("#jonumber");

// Render data on JO table when Searched
const renderJoTable = function (data, tbody) {
  tbody.innerHTML = "";
  data.forEach((data) => {
    tbody.insertAdjacentHTML(
      "beforeend",
      `<tr>
    <td class='jo__modal--td__jonumber'>${data.jo_no}</td>
    <td>${data.customers_name}</td>
    <td>${data.jo_date}</td>
    </tr>`
    );
  });
};

// Get data from PHP file
const searchJo = function () {
  const joSearch = this.value;
  console.log(joSearch);

  fetch("php/jo_modal-inc.php", {
    method: "POST", // or 'PUT'
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `joSearch=${joSearch}`,
  })
    .then((res) => {
      // console.log(res.text());
      return res.json();
    })
    .then((data) => {
      renderJoTable(data, tblJoModal.querySelector("tbody"));
    });
};

// Remove active modal
const closeJoModal = function () {
  joModal.classList.remove("jo__modal--active");
};

// Select Jo number
const selectJo = function (e) {
  const targetRow = e.target.closest("tr");
  const targetJoNumber = targetRow.querySelector(".jo__modal--td__jonumber");

  // Fetch customer details
  fetch(`php/jo_modal-inc.php?selectCustomer&joNo=${targetJoNumber.innerHTML}`)
    .then((res) => res.json())
    .then((data) => {
      // Put data on Customer Details
      const [customerData] = data;
      console.log(customerData.jo_id);

      // Render customer details
      inputCustomerId.value = customerData.customers_id.padStart(8, 0);
      inputCustomerName.value = customerData.customers_name.toUpperCase();
      inputCustomerAddress.value = customerData.customers_address;
      inputCustomerContact.value = customerData.customers_contact;

      // Fetch Order details
      return fetch(
        `php/jo_modal-inc.php?selectOrders&joNo=${targetJoNumber.innerHTML}&joId=${customerData.jo_id}`
      );
    })
    .then((res) => res.json())
    .then((data) => {
      //JO input
      inputJoNumber.value = data[0].jo_no;
      transaction.joId = data[0].jo_id;

      data.forEach((product, index) => {
        const totalGross = product.jo_product_qty * product.jo_product_price;
        qtyHistory.push(product.jo_product_qty);
        containerOrderList.insertAdjacentHTML(
          "beforeend",
          `<tr>
          <td class="item-code">${product.product_id.padStart(8, 0)}</td>
          <td class="item-description">${product.product_name}</td>
          <td class="td__locked price">${formatNumber(
            product.jo_product_price
          )}</td>
          <td class="${product.jo_product_qty > 0 ? "td__edit" : "td__locked"
          } qty">${product.jo_product_qty}</td>
          <td class="unit">${product.unit_name}</td>
          <td class="td__locked discount">0.00</td>
          <td class="total">${formatNumber(totalGross)}</td>
          <td class="td__locked delete">X</td>
        </tr>`
        );

        // Add to Summary Gross Amount, Qty,
        const prevGross = removeComma(smryGross.value);
        const prevQty = removeComma(smryQty.value);
        const prevNetSales = removeComma(smryNetSales.value);

        smryGross.value = formatNumber(+prevGross + +totalGross);
        smryQty.value = formatNumber(+prevQty + +product.jo_product_qty);
        smryNetSales.value = formatNumber(+prevNetSales + +totalGross);

        computeTax();

        // Add default value of item to the Label
        smryLabelPayable.textContent = `${smryNetSales.value} PHP`;
      });
    });

  btnSearchCustomer.setAttribute("disabled", "");
  closeJoModal();
};

// Search Event
inputJoSearch.addEventListener("keyup", searchJo.bind(inputJoSearch));
// Close modal event
joModalClose.addEventListener("click", closeJoModal);
// Event for Selecting JO
tblJoModal.addEventListener("dblclick", selectJo);
