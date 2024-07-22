document.getElementById('applicationForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const formData = new FormData();
    formData.append('name', document.getElementById('name').value);
    formData.append('application_id', document.getElementById('applicationSelect').value);
    formData.append('email', document.getElementById('email').value);

    fetch('submit_application.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert('Application submitted!');
        document.getElementById('applicationForm').reset();
    });
});
