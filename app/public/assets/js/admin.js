document.addEventListener('DOMContentLoaded', () => {
    const addUserForm = document.getElementById('addUserForm');
    const userTableBody = document.getElementById('userTableBody');
    const addUserResponse = document.getElementById('addUserResponse');

    // Add User
    addUserForm.addEventListener('submit', async (event) => {
        event.preventDefault();

        const formData = new FormData(addUserForm);

        try {
            const response = await fetch('/api/admin/addUser', {
                method: 'POST',
                body: formData,
            });

            const result = await response.json();

            if (response.ok) {
                addUserResponse.textContent = 'User added successfully.';
                addUserForm.reset();
                fetchUsers(); // Refresh the user table
            } else {
                addUserResponse.textContent = result.error || 'Failed to add user.';
            }
        } catch (error) {
            console.error('Error adding user:', error);
            addUserResponse.textContent = 'An unexpected error occurred.';
        }
    });

    // Fetch and Display Users
    async function fetchUsers() {
        try {
            const response = await fetch('/api/admin/users');
            const users = await response.json();

            userTableBody.innerHTML = ''; // Clear the table

            users.forEach((user) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${user.id}</td>
                    <td>${user.firstname}</td>
                    <td>${user.lastname}</td>
                    <td>${user.username}</td>
                    <td>${user.email}</td>
                    <td>${user.role || 'N/A'}</td>
                    <td>
                        <button class="delete-btn" data-id="${user.id}">Delete</button>
                    </td>
                `;
                userTableBody.appendChild(row);
            });

            // Attach event listeners to delete buttons
            const deleteButtons = document.querySelectorAll('.delete-btn');
            deleteButtons.forEach((button) => {
                button.addEventListener('click', async () => {
                    const userId = button.getAttribute('data-id');
                    await deleteUser(userId);
                });
            });
        } catch (error) {
            console.error('Error fetching users:', error);
        }
    }

    // Delete User
    async function deleteUser(userId) {
        try {
            const response = await fetch(`/api/admin/deleteUser/${userId}`, {
                method: 'POST',
            });

            const result = await response.json();

            if (response.ok) {
                alert('User deleted successfully.');
                fetchUsers(); // Refresh the user table
            } else {
                alert(result.error || 'Failed to delete user.');
            }
        } catch (error) {
            console.error('Error deleting user:', error);
            alert('An unexpected error occurred.');
        }
    }

    // Initialize
    fetchUsers();
});
