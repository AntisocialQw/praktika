// main.js - главный JavaScript файл
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(initApp, 100);
});

function initApp() {
    initPortfolioFilter();
    initSmoothScroll();
    initContactForm();
    initScrollEffects();
    initAdminFeatures();
}

function initPortfolioFilter() {
    const filterBtns = document.querySelectorAll('.filter-btn');
    const portfolioItems = document.querySelectorAll('.portfolio-item');
    
    if (filterBtns.length === 0) {
        console.log('Кнопки фильтра не найдены');
        return;
    }
    
    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            filterBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            
            const filter = btn.getAttribute('data-filter');
            
            portfolioItems.forEach(item => {
                if (filter === 'all' || item.getAttribute('data-category') === filter) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
}

function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 80,
                    behavior: 'smooth'
                });
            }
        });
    });
}

function initContactForm() {
    const contactForm = document.getElementById('contactForm');
    
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Спасибо за вашу заявку! Мы свяжемся с вами в ближайшее время.');
            contactForm.reset();
        });
    } else {
        console.log('Форма не найдена');
    }
}

function initScrollEffects() {
    window.addEventListener('scroll', () => {
        const header = document.querySelector('header');
        if (header) {
            if (window.scrollY > 100) {
                header.style.boxShadow = '0 4px 10px rgba(0, 0, 0, 0.1)';
            } else {
                header.style.boxShadow = '0 4px 6px rgba(0, 0, 0, 0.1)';
            }
        }
    });
}

// Новые функции для админ-панели
function initAdminFeatures() {
    // Проверяем, находимся ли мы на странице админ-панели
    const isAdminPage = window.location.pathname.includes('control.php') || 
                       window.location.pathname.includes('portfolio_manager.php');
    
    if (isAdminPage) {
        // Загружаем admin.js динамически
        const script = document.createElement('script');
        script.src = 'js/admin.js';
        document.head.appendChild(script);
    }
}