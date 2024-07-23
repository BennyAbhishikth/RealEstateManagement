document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('signupForm').addEventListener('submit', function (e) {
        e.preventDefault();
        var form = e.target;
        var formData = new FormData(form);
        fetch('../Model/signup.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // alert('Signup successful!');
                // form.reset();
                alert('Signup successful! Please fill in your additional details.');
                window.location.href = 'details.html?user_id=' + data.user_id;
            } else {
                document.getElementById('signupError').innerText = data.message;
            }
        })
        .catch(error => console.error('Error:', error));
    });
});
