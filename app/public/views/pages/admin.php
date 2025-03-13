<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../../assets/css/admin_styles.css">
</head>
<body>
    <div class="admin-container">
        <!-- Header Section -->
        <header class="admin-header">
            <h1>Admin Panel</h1>
            <!-- Logout Button -->
            <button id="logoutButton" class="logout-btn">Logout</button>
        </header>

        <!-- Add User Form -->
        <div class="add-user-form">
            <h2>Add New User</h2>
            <form id="addUserForm">
                <input type="text" name="firstname" placeholder="First Name" required>
                <input type="text" name="lastname" placeholder="Last Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <select name="role" required>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
                <button type="submit">Add User</button>
            </form>
            <p id="addUserResponse"></p>
        </div>

        <!-- User List -->
        <div class="user-list">
            <h2>All Users</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="userTableBody"></tbody>
            </table>
        </div>
    </div>

    <script src="../../assets/js/admin.js"></script>

    <!-- Logout Functionality -->
    <script>
        document.getElementById('logoutButton').addEventListener('click', () => {
            if (confirm('Are you sure you want to logout?')) {
                window.location.href = '/logout'; // Redirect to the logout route
            }
        });
    </script>
</body>
</html>
