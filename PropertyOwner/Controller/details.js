document.addEventListener('DOMContentLoaded', function () {
    const urlParams = new URLSearchParams(window.location.search);
    const userId = urlParams.get('user_id');

    if (!userId) {
        alert('User ID is missing.');
        window.location.href = 'login.html'; 
        return;
    }

    document.getElementById('detailsForm').addEventListener('submit', function (e) {
        e.preventDefault();
        var form = e.target;
        var formData = new FormData(form);
        formData.append('user_id', userId);

        fetch('../Model/details.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Details submitted successfully!');
                window.location.href = 'dashboard.html';
            } else {
                document.getElementById('detailsError').innerText = data.message;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('detailsError').innerText = 'An error occurred. Please try again.';
        });
    });
});
