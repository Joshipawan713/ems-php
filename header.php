<header class="top-header">
    <button class="toggle-sidebar" id="toggleSidebar">
        <i class="fas fa-bars"></i>
    </button>
    
    <div class="header-actions">
        <div class="notification-dropdown">
            <button class="notification-btn">
                <i class="fas fa-bell"></i>
                <span class="badge">3</span>
            </button>
            <div class="dropdown-menu dropdown-menu-end" id="notificationMenu">
                <div class="notification-item">
                    <div class="notification-title">New Employee Added</div>
                    <p class="mb-1">John Doe has been added to the Marketing department.</p>
                    <div class="notification-time">10 minutes ago</div>
                </div>
                <div class="notification-item">
                    <div class="notification-title">Payroll Processed</div>
                    <p class="mb-1">September payroll has been processed successfully.</p>
                    <div class="notification-time">2 hours ago</div>
                </div>
                <div class="notification-item">
                    <div class="notification-title">System Update</div>
                    <p class="mb-1">System maintenance scheduled for Sunday at 2 AM.</p>
                    <div class="notification-time">1 day ago</div>
                </div>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item text-center">
                    <i class="fas fa-bell me-2"></i>View All Notifications
                </a>
            </div>
        </div>
        
        <!-- User Profile -->
        <div class="user-dropdown">
            <button class="user-btn">
                <div class="user-info">
                    <div class="user-avatar">AD</div>
                    <div class="user-name d-none d-md-block">Admin User</div>
                    <i class="fas fa-chevron-down ms-2"></i>
                </div>
            </button>
            <div class="dropdown-menu dropdown-menu-end" id="userMenu">
                <div class="dropdown-header">
                    <h6>Admin User</h6>
                    <small>Administrator</small>
                </div>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-user me-2"></i>My Profile
                </a>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-cog me-2"></i>Account Settings
                </a>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-shield-alt me-2"></i>Security
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item text-danger">
                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                </a>
            </div>
        </div>
    </div>
</header>