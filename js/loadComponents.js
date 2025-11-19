document.addEventListener('DOMContentLoaded', function() {
    const isLoginPage = window.location.pathname.includes('login.html') || 
                       document.getElementById('loginSection');
    
    if (isLoginPage) {
        loadLoginPage();
    } else {
        loadMainPage();
    }
});

function loadMainPage() {
    const components = [
        { id: 'header', file: 'partials/header.html' },
        { id: 'hero', file: 'partials/hero.html' },
        { id: 'about', file: 'partials/about.html' },
        { id: 'services', file: 'partials/services.html' },
        { id: 'portfolio', file: 'partials/portfolio.html' },
        { id: 'team', file: 'partials/team.html' },
        { id: 'testimonials', file: 'partials/testimonials.html' },
        { id: 'contact', file: 'partials/contact.html' },
        { id: 'footer', file: 'partials/footer.html' }
    ];

    components.forEach(component => {
        fetch(component.file)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.text();
            })
            .then(data => {
                document.getElementById(component.id).innerHTML = data;
                if (component.id === 'header') {
                    initAuthHeader();
                }
            })
            .catch(error => {
                console.error('Error loading component:', component.file, error);
            });
    });
}

function loadLoginPage() {
    const components = [
        { id: 'header', file: 'partials/header.html' },
        { id: 'loginSection', file: 'partials/login-component.html' },
        { id: 'footer', file: 'partials/footer.html' }
    ];

    components.forEach(component => {
        fetch(component.file)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.text();
            })
            .then(data => {
                const element = document.getElementById(component.id);
                if (element) {
                    element.innerHTML = data;
                }
                
                if (component.id === 'header') {
                    initAuthHeader();
                }
                if (component.id === 'loginSection') {
                    setTimeout(initAuth, 100);
                }
            })
            .catch(error => {
                console.error('Error loading component:', component.file, error);
            });
    });
}

function initAuthHeader() {
    const isLoggedIn = sessionStorage.getItem('isLoggedIn');
    const userPhone = sessionStorage.getItem('userPhone');
    const authSection = document.getElementById('authSection');
    
    if (authSection) {
        if (isLoggedIn && userPhone) {
            authSection.innerHTML = `
                <div class="user-menu">
                    <a href="#" id="logoutBtn" class="logout-link">Выйти</a>
                </div>
            `;
            
            document.getElementById('logoutBtn').addEventListener('click', function(e) {
                e.preventDefault();
                sessionStorage.removeItem('isLoggedIn');
                sessionStorage.removeItem('userPhone');
                localStorage.removeItem('userPhone');
                window.location.href = 'index.html';
            });
        } else {
            authSection.innerHTML = `
                <a href="login.html" class="auth-link">
                    <i class="fas fa-user"></i>
                    <span>Войти</span>
                </a>
            `;
        }
    }
}