// Sidebar Toggle JavaScript
document.addEventListener('DOMContentLoaded', function() {
    createToggleButton();
});

function createToggleButton() {
    const sidebarBtn = document.createElement('button');
    sidebarBtn.className = 'sidebar-toggle-btn';
    sidebarBtn.onclick = toggleSidebar;
    document.body.appendChild(sidebarBtn);
    
    const headerBtn = document.createElement('button');
    headerBtn.className = 'header-toggle-btn';
    headerBtn.onclick = toggleHeader;
    headerBtn.innerHTML = '<i class="fas fa-chevron-up"></i>';
    document.body.appendChild(headerBtn);
    
    updateButtonIcon();
}

function updateButtonIcon() {
    const sidebarBtn = document.querySelector('.sidebar-toggle-btn');
    const headerBtn = document.querySelector('.header-toggle-btn');
    const isSidebarCollapsed = document.body.classList.contains('sidebar-collapsed');
    const isHeaderCollapsed = document.body.classList.contains('header-collapsed');
    
    if (isSidebarCollapsed) {
        sidebarBtn.innerHTML = '<i class="fas fa-chevron-right"></i>';
    } else {
        sidebarBtn.innerHTML = '<i class="fas fa-chevron-left"></i>';
    }
    
    if (isHeaderCollapsed) {
        headerBtn.innerHTML = '<i class="fas fa-chevron-down"></i>';
    } else {
        headerBtn.innerHTML = '<i class="fas fa-chevron-up"></i>';
    }
}

function toggleSidebar() {
    const sidebar = document.getElementById('adminSidebar');
    const body = document.body;
    
    if (body.classList.contains('sidebar-collapsed')) {
        sidebar.classList.remove('collapsed');
        body.classList.remove('sidebar-collapsed');
        localStorage.setItem('sidebar-collapsed', 'false');
    } else {
        sidebar.classList.add('collapsed');
        body.classList.add('sidebar-collapsed');
        localStorage.setItem('sidebar-collapsed', 'true');
    }
    
    updateButtonIcon();
}

function toggleHeader() {
    const body = document.body;
    
    if (body.classList.contains('header-collapsed')) {
        body.classList.remove('header-collapsed');
        localStorage.setItem('header-collapsed', 'false');
    } else {
        body.classList.add('header-collapsed');
        localStorage.setItem('header-collapsed', 'true');
    }
    
    updateButtonIcon();
}