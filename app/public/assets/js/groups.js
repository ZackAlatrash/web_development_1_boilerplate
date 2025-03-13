const apiEndpoint = '/api/groups';

async function fetchGroups() {
    try {
        const response = await fetch(apiEndpoint);
        if (!response.ok) throw new Error('Failed to fetch groups');

        const groups = await response.json();
        const groupList = document.getElementById('groupList');
        groupList.innerHTML = ''; // Clear previous list

        groups.forEach(group => {
            const listItem = document.createElement('li');
            listItem.className = 'group-item';
            listItem.innerHTML = `
                <span>${group.name}</span>
                <div>
                    <button class="btn view-btn" onclick="viewGroup(${group.id})">View</button>
                    <button class="btn delete-btn" onclick="deleteGroup(${group.id})">Delete</button>
                </div>
            `;
            
            groupList.appendChild(listItem);
        });
    } catch (error) {
        console.error('Error fetching groups:', error);
    }
}

async function addGroup(event) {
    event.preventDefault();
    const groupName = document.getElementById('group_name').value;
    const groupDescription = document.getElementById('group_description').value;

    try {
        const response = await fetch(apiEndpoint, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ name: groupName, description: groupDescription})
            
        });

        if (!response.ok) throw new Error('Failed to create group');
        fetchGroups(); 
        document.getElementById('group_name').value = '';
        document.getElementById('group_description').value = '';
        document.getElementById('addGroupModal').style.display = 'none';
        
    } catch (error) {
        console.error('Error creating group:', error);
    }
}

async function deleteGroup(groupId) {
    try {
        const response = await fetch(`/api/groups/delete/${groupId}`, { method: 'DELETE' });
        if (!response.ok) throw new Error('Failed to delete group');
        fetchGroups(); 
    } catch (error) {
        console.error('Error deleting group:', error);
    }
}



function viewGroup(groupId) {
    window.location.href = `/group-details?group_id=${groupId}`;
}

const modal = document.getElementById('addGroupModal');
const addGroupButton = document.getElementById('addGroupButton');
const closeButton = document.querySelector('.close');

addGroupButton.onclick = () => modal.style.display = 'flex';
closeButton.onclick = () => modal.style.display = 'none';
window.onclick = (event) => { if (event.target === modal) modal.style.display = 'none'; };

document.getElementById('addGroupForm').addEventListener('submit', addGroup);
document.addEventListener('DOMContentLoaded', fetchGroups);
