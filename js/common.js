window.addEventListener("load", function () {
    var signup_form = document.getElementById("signup-form");
    signup_form.addEventListener("submit", function (event) {
        var XHR = new XMLHttpRequest();
        var form_data = new FormData(signup_form);

        // On success
        XHR.addEventListener("load", signup_success);

        // On error
        XHR.addEventListener("error", on_error);

        // Set up request
        XHR.open("POST", "api/signup_submit.php");

        // Form data is sent with request
        XHR.send(form_data);

        document.getElementById("loading").style.display = 'block';
        event.preventDefault();
    });

    var login_form = document.getElementById("login-form");
    login_form.addEventListener("submit", function (event) {
        var XHR = new XMLHttpRequest();
        var form_data = new FormData(login_form);

        // On success
        XHR.addEventListener("load", login_success);

        // On error
        XHR.addEventListener("error", on_error);

        // Set up request
        XHR.open("POST", "api/login_submit.php");

        // Form data is sent with request
        XHR.send(form_data);

        document.getElementById("loading").style.display = 'block';
        event.preventDefault();
    });
});

var signup_success = function (event) {
    document.getElementById("loading").style.display = 'none';

    var response = JSON.parse(event.target.responseText);
    if (response.success) {
        alert(response.message);
        window.location.href = "index.php";
    } else {
        alert(response.message);
    }
};

var login_success = function (event) {
    document.getElementById("loading").style.display = 'none';

    var response = JSON.parse(event.target.responseText);
    if (response.success) {
        location.reload();
    } else {
        alert(response.message);
    }
};

var on_error = function (event) {
    document.getElementById("loading").style.display = 'none';

    alert('Oops! Something went wrong.');
};


const toggle = document.getElementById('theme-toggle');
const currentTheme = localStorage.getItem('theme');

if (currentTheme === 'dark') {
    document.body.classList.add('dark-theme');
    toggle.checked = true;
} else {
    document.body.classList.add('light-theme');
}

toggle.addEventListener('change', () => {
    if (toggle.checked) {
        document.body.classList.remove('light-theme');
        document.body.classList.add('dark-theme');
        localStorage.setItem('theme', 'dark');
    } else {
        document.body.classList.remove('dark-theme');
        document.body.classList.add('light-theme');
        localStorage.setItem('theme', 'light');
    }
});
document.addEventListener("DOMContentLoaded", function () {
    const toggleSwitch = document.getElementById('theme-toggle-switch');
    const themeLabel = document.getElementById('theme-label');

    function applyTheme(theme) {
        if (theme === 'dark') {
            document.body.classList.add('dark-theme');
            document.body.classList.remove('light-theme');
            if (toggleSwitch) toggleSwitch.classList.add('active');
            if (themeLabel) themeLabel.textContent = 'Light Mode';
        } else {
            document.body.classList.add('light-theme');
            document.body.classList.remove('dark-theme');
            if (toggleSwitch) toggleSwitch.classList.remove('active');
            if (themeLabel) themeLabel.textContent = 'Dark Mode';
        }
    }

    const savedTheme = localStorage.getItem('theme') || 'light';
    applyTheme(savedTheme);

    if (toggleSwitch) {
        toggleSwitch.addEventListener('click', () => {
            const isDark = toggleSwitch.classList.contains('active');
            const newTheme = isDark ? 'light' : 'dark';
            applyTheme(newTheme);
            localStorage.setItem('theme', newTheme);
        });
    }
});

document.querySelector('.theme-toggle-switch').addEventListener('focus', function(e) {
    this.style.outline = 'none';
    this.style.boxShadow = 'none';
});

$('.theme-toggle-switch').focus(function() {
    $(this).css({'outline': 'none', 'box-shadow': 'none'});
});