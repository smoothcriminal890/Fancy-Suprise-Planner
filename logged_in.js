fetch('logged_in.php')
  .then(res => res.json())
  .then(data => {
    if (!data.error) {
      document.getElementById('user-name').textContent = data.name;
      document.getElementById('user-email').textContent = data.email;
    } else {
      window.location.href = 'login.html';
    }
  })
  .catch(err => console.error('Error fetching user info:', err));