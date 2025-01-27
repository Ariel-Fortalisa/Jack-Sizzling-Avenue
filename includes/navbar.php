<link rel="stylesheet" href="./css/sidebar.css">
<!-- Navbar -->
<nav class="navbar navbar-dark bg-dark shadow-sm">
    <div id="side-btn-div">
        <button class="navbar-toggler border-0" type="button" id="sidebar-btn">
            <i class="navbar-toggler-icon"></i>
        </button>
    </div>
</nav>

<!-- Sidebar -->
<div id="sidebar" class="sidebar bg-dark shadow">
    <div class="list-group" style="height: 90%; position: relative">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-tachometer-alt"></i>
                <span class="nav-text">Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-store"></i>
                <span class="nav-text">Point of Sale</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-chart-line"></i>
                <span class="nav-text">Reports</span>
            </a>
        </li>
    </ul>
    </div>
</div>


    <script>
// Get sidebar and toggle button elements
const sidebar = document.getElementById('sidebar');
const sidebarBtn = document.getElementById('sidebar-btn');

// Toggle sidebar expand/collapse when burger button is clicked
sidebarBtn.addEventListener('click', function() {
    sidebar.classList.toggle('expanded');
});

// Collapse sidebar if it is clicked (optional if you want to allow sidebar clicks to toggle it)
sidebar.addEventListener('click', function() {
    sidebar.classList.toggle('expanded');
});
</script>



