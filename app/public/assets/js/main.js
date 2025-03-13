// Define the API endpoint
const apiEndpoint = '/api/subjects';

// Fetch the subjects
fetch(apiEndpoint)
  .then(response =>  response.json())
  .then(data => {
    const subjectList = document.getElementById('subjectList');
    subjectList.innerHTML = ''; // Clear the list before adding new items

    // Loop through the subjects and add them to the list
    data.forEach(subject => {
      const listItem = document.createElement('li');
      listItem.textContent = subject.name; // Assuming 'name' is a field in your subject data
      subjectList.appendChild(listItem);
    });
  })
