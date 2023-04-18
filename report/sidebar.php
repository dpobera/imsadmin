<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light bg-gradient sidebar collapse" style="overflow-y: visible; overflow-x:hidden">
    <div class="position-sticky pt-3">
        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-1 mb-1 text-dark">
            <span> <i class="bi bi-person-fill-check text-dark"></i> Welcome, <?php echo $_SESSION["empName"]; ?>
                <a href="logout.php" data-bs-toggle="tooltip" data-bs-placement="right" title="Sign-Out" style="text-decoration: none;">&emsp;</a></span>
            <a class="link-secondary" href="#" aria-label="Add a new report">
                <span data-feather="plus-circle"></span>
            </a>
        </h6>
        <hr style="color: #B2B2B1;">
        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
            <span style="font-weight: bold;letter-spacing:2px"><i class="bi bi-boxes"></i> Inventory</span>
            <a class="link-secondary" href="#" aria-label="Add a new report">
                <span data-feather="plus-circle"></span>
            </a>
        </h6>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="../index.php">
                    <span data-feather="home">Job-Order</span>

                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../itemlist-index.php">
                    <span data-feather="file">Itemlist</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../stin-index.php">
                    <span data-feather="shopping-cart">Stock Inventory IN</span>

                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../stout-index.php">
                    <span data-feather="users">Stock Inventory OUT</span>

                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../ep-index.php">
                    <span data-feather="bar-chart-2">Exit Pass</span>

                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../po-index.php">
                    <span data-feather="layers">Purchase Order</span>

                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../rt-index.php">
                    <span data-feather="layers">Return Slip</span>

                </a>
            </li>

        </ul>
        <hr style="color: #B2B2B1;">
        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-3 mb-1 text-muted">
            <span style="font-weight: bold;letter-spacing:2px"><i class="bi bi-globe"></i> Online Sales Platform</span>
            <a class="link-secondary" href="#" aria-label="Add a new report">
                <span data-feather="plus-circle"></span>
            </a>
        </h6>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="../shopee-index.php">
                    <span data-feather="home">Online Sales</span>
                </a>
            </li>
            <!-- <li class="nav-item">
                <a class="nav-link" aria-current="page" href="lazada-index.php">
                    <span data-feather="home">Lazada</span>

                </a>
            </li> -->
        </ul>
        <hr style="color: #B2B2B1;">
        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-3 mb-1 text-muted">
            <span style="font-weight: bold;letter-spacing:2px"><i class="bi bi-receipt"></i> Receipts</span>
            <a class="link-secondary" href="#" aria-label="Add a new report">
                <span data-feather="plus-circle"></span>
            </a>
        </h6>
        <ul class="nav flex-column mb-2">
            <li class="nav-item">
                <a class="nav-link" href="../receipt_dr-index.php">
                    <span data-feather="file-text">Delivery Receipt</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../receipt_si-index.php">
                    <span data-feather="file-text">Sales Invoice</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../receipt_or-index.php">
                    <span data-feather="file-text">Official Receipt</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../ol-utilities.php?ol_set=-----------------&submit=&setAmount=0&fcTotal=0&grandTot=0&addTot=0">
                    <span data-feather="file-text">Shopee OR</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="../ol-utilities_lazada_or.php?ol_set=----------&submit=&setAmount=0&fcTotal=0&grandTot=0&addTot=0">
                    <span data-feather="file-text">Lazada OR</span>
                </a>
            </li>
        </ul>
        <hr style="color: #B2B2B1;">
        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-3 mb-1 text-muted">
            <span style="font-weight: bold;letter-spacing:2px"><i class="bi bi-gear"></i> Tools & Components</span>
            <a class="link-secondary" href="#" aria-label="Add a new report">
                <span data-feather="plus-circle"></span>
            </a>
        </h6>
        <ul class="nav flex-column mb-2">


            <li class="nav-item">
                <a class="nav-link" href="../sup-index.php">
                    <span data-feather="file-text">Supplier</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../cust-index.php">
                    <span data-feather="file-text">Customer</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../class-index.php">
                    <span data-feather="file-text">Classification</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../dept-index.php">
                    <span data-feather="file-text">Department</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../unit-index.php">
                    <span data-feather="file-text">Unit</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../loc-index.php">
                    <span data-feather="file-text">Location</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../emp-index.php">
                    <span data-feather="file-text">Employee</span>
                </a>
            </li>
        </ul>
        <hr style="color: #B2B2B1;">
        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
            <span style="font-weight: bold;letter-spacing:2px"><i class="bi bi-boxes"></i> Reports</span>
            <a class="link-secondary" href="#" aria-label="Add a new report">
                <span data-feather="plus-circle"></span>
            </a>
        </h6>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="../inv_report.php?dept_id=23">
                    <span data-feather="home">Detailed Inventory</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="../inv_report_summary.php?dept_id=23&date1=&date2=">
                    <span data-feather="home">Summary Inventory</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="stin_report.php?date1=&date2=&deptType=">
                    <span data-feather="home">Stock-IN Reports</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="#">
                    <span data-feather="home">Stock-OUT Reports</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="srr_select.php">
                    <span data-feather="home">SRR</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="sales-report.php?date1=&date2=">
                    <span data-feather="home">Sales Report</span>
                </a>
            </li>
            <br>
            <br>
        </ul>
    </div>
</nav>