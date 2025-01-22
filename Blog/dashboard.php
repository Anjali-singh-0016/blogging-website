
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - BlogVault</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="./CSS/dashboard.css">
</head>
<body>
    <!-- Navigation Bar -->
    <header class="dashboard-header">
        <div class="navbar">
            <div class="navbar-logo">
                <img src="assests/blog-solid.png" alt="Logo" class="logo">
                <h1>BlogVault</h1>
            </div>
            <div class="navbar-actions">
                <a href="profile_settings.php" class="profile-link">
                    <i class="fas fa-user"></i> Profile
                </a>
                <a href="logout.php" class="logout-link">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
    </header>
    <!-- Dashboard Body -->
    <div class="dashboard-body">
        <!-- Sidebar -->
        <aside class="sidebar">
            <ul>
                <li><a href="#" data-target="overview.php">Dashboard Overview</a></li>
                <li><a href="#" data-target="view_blog.php">View Blogs</a></li>
                <li><a href="#" data-target="create_blog.php">Create Blog</a></li>
                <li><a href="#" data-target="manage_categories.php">Manage Categories</a></li>
                <li><a href="#" data-target="comments.php">Comments</a></li>
                <li><a href="#" data-target="analytics.php">Analytics</a></li>
                <li><a href="#" data-target="drafts.php">Drafts</a></li>
                <li><a href="#" data-target="profile_settings.php">Profile Settings</a></li>
                <li><a href="#" data-target="account_settings.php">Account Settings</a></li>
                <li><a href="#" data-target="help-support.php">Help & Support</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </aside>


        <!-- Main Content -->
        <main class="main-content">
            <div id="content-area">
                <h2>Welcome to BlogVault Dashboard</h2>
                <p>Select an option from the sidebar to get started.</p>
            </div>
        </main>
    </div>

    <script src="./JS/dashboard.js"></script>
</body>
</html>
