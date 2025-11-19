function initAuth() {
    initLoginForm();
    initRegistrationForm();
    initPasswordRecovery();
    initModals();
    initPasswordToggle();
    initPhoneMask();
    checkURLMessages();
}

function initLoginForm() {
    const loginForm = document.getElementById('loginForm');
    
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const phone = document.getElementById('phone').value;
            const password = document.getElementById('password').value;
            const rememberMe = document.getElementById('rememberMe').checked;
            
            // Очищаем предыдущие ошибки
            clearErrors();
            
            // Проверяем, что поля не пустые
            if (!phone.trim() || !password.trim()) {
                showError('Пожалуйста, заполните все поля');
                return;
            }
            
            // Проверяем валидность телефона
            if (!validatePhone(phone)) {
                showError('Введите корректный номер телефона (10 цифр)');
                return;
            }
            
            // Проверяем длину пароля
            if (password.length < 6) {
                showError('Пароль должен содержать минимум 6 символов');
                return;
            }
            
            // Пытаемся войти
            simulateLogin(phone, password, rememberMe);
        });
    }
}

function showError(message) {
    const errorDiv = document.getElementById('errorMessage');
    if (errorDiv) {
        errorDiv.textContent = message;
        errorDiv.style.display = 'block';
        
        // Автоматически скрываем ошибку через 5 секунд
        setTimeout(() => {
            errorDiv.style.display = 'none';
        }, 5000);
    }
}

function clearErrors() {
    const errorDiv = document.getElementById('errorMessage');
    if (errorDiv) {
        errorDiv.style.display = 'none';
    }
    
    // Очищаем ошибки полей
    const errorFields = document.querySelectorAll('.error');
    errorFields.forEach(field => {
        field.classList.remove('error');
    });
    
    const errorMessages = document.querySelectorAll('.field-error');
    errorMessages.forEach(message => {
        message.remove();
    });
}

function simulateLogin(phone, password, rememberMe) {
    const cleanPhone = getCleanPhone(phone);
    
    // Проверяем тестовые данные
    if (cleanPhone === '9166482542' && password === 'qwerty22') {
        showError(''); // Очищаем ошибки
        showMessage('Выполняется вход...', 'success');
        
        setTimeout(() => {
            if (rememberMe) {
                localStorage.setItem('userPhone', cleanPhone);
            }
            
            sessionStorage.setItem('isLoggedIn', 'true');
            sessionStorage.setItem('userPhone', cleanPhone);
            
            showMessage('Вход выполнен успешно!', 'success');
            
            setTimeout(() => {
                window.location.href = 'profile.php';
            }, 1500);
        }, 1000);
    } else {
        showError('Такого пользователя не существует. Проверьте номер телефона и пароль.');
        
        // Добавляем визуальное выделение неверных полей
        document.getElementById('phone').classList.add('error');
        document.getElementById('password').classList.add('error');
    }
}

function initRegistrationForm() {
    const registerForm = document.getElementById('registerForm');
    const registerBtn = document.getElementById('registerBtn');
    
    if (registerBtn) {
        registerBtn.addEventListener('click', function() {
            openModal('registerModal');
        });
    }
    
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const name = document.getElementById('regName').value;
            const phone = document.getElementById('regPhone').value;
            const email = document.getElementById('regEmail').value;
            const password = document.getElementById('regPassword').value;
            const confirmPassword = document.getElementById('regConfirmPassword').value;
            const agreeTerms = document.getElementById('agreeTerms').checked;
            
            if (validateRegistrationForm(name, phone, email, password, confirmPassword, agreeTerms)) {
                simulateRegistration(name, phone, email, password);
            }
        });
    }
}

function initPasswordRecovery() {
    const forgotPasswordForm = document.getElementById('forgotPasswordForm');
    const forgotPasswordLinks = document.querySelectorAll('.forgot-password');
    
    forgotPasswordLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            openModal('forgotPasswordModal');
        });
    });
    
    if (forgotPasswordForm) {
        forgotPasswordForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const phone = document.getElementById('recoveryPhone').value;
            
            if (validatePhone(phone)) {
                simulatePasswordRecovery(phone);
            } else {
                showMessage('Введите корректный номер телефона', 'error');
            }
        });
    }
}

function initModals() {
    const modals = document.querySelectorAll('.modal');
    const closeButtons = document.querySelectorAll('.close-modal');
    
    closeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const modal = this.closest('.modal');
            closeModal(modal);
        });
    });
    
    modals.forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal(this);
            }
        });
    });
    
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            modals.forEach(modal => {
                if (modal.style.display === 'block') {
                    closeModal(modal);
                }
            });
        }
    });
}

function initPasswordToggle() {
    const toggleButtons = document.querySelectorAll('.toggle-password');
    
    toggleButtons.forEach(button => {
        button.addEventListener('click', function() {
            const input = this.parentElement.querySelector('input');
            const icon = this.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });
}

function initPhoneMask() {
    const phoneInputs = document.querySelectorAll('input[type="tel"]');
    
    phoneInputs.forEach(input => {
        input.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            
            if (value.length > 10) {
                value = value.substring(0, 10);
            }
            
            let formattedValue = '';
            if (value.length > 0) {
                formattedValue = '(' + value.substring(0, 3);
                
                if (value.length > 3) {
                    formattedValue += ') ' + value.substring(3, 6);
                }
                
                if (value.length > 6) {
                    formattedValue += '-' + value.substring(6, 8);
                }
                
                if (value.length > 8) {
                    formattedValue += '-' + value.substring(8, 10);
                }
            }
            
            e.target.value = formattedValue;
        });
        
        input.addEventListener('keydown', function(e) {
            if (e.key === 'Backspace' || e.key === 'Delete') {
                setTimeout(() => {
                    let value = this.value.replace(/\D/g, '');
                    if (value.length > 0) {
                        let formattedValue = '(' + value.substring(0, 3);
                        
                        if (value.length > 3) {
                            formattedValue += ') ' + value.substring(3, 6);
                        }
                        
                        if (value.length > 6) {
                            formattedValue += '-' + value.substring(6, 8);
                        }
                        
                        if (value.length > 8) {
                            formattedValue += '-' + value.substring(8, 10);
                        }
                        
                        this.value = formattedValue;
                    } else {
                        this.value = '';
                    }
                }, 0);
            }
        });
    });
}

function validateRegistrationForm(name, phone, email, password, confirmPassword, agreeTerms) {
    clearFieldErrors();
    
    let isValid = true;
    
    if (name.trim().length < 2) {
        showFieldError('regName', 'Введите корректное имя и фамилию (минимум 2 символа)');
        isValid = false;
    }
    
    if (!validatePhone(phone)) {
        showFieldError('regPhone', 'Введите корректный номер телефона (10 цифр)');
        isValid = false;
    }
    
    if (!validateEmail(email)) {
        showFieldError('regEmail', 'Введите корректный email адрес');
        isValid = false;
    }
    
    if (password.length < 6) {
        showFieldError('regPassword', 'Пароль должен содержать минимум 6 символов');
        isValid = false;
    }
    
    if (password !== confirmPassword) {
        showFieldError('regConfirmPassword', 'Пароли не совпадают');
        isValid = false;
    }
    
    if (!agreeTerms) {
        showFieldError('agreeTermsLabel', 'Необходимо согласие с правилами обработки данных');
        isValid = false;
    }
    
    return isValid;
}

function validatePhone(phone) {
    const cleanPhone = getCleanPhone(phone);
    return cleanPhone.length === 10;
}

function validateEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function getCleanPhone(phone) {
    return phone.replace(/\D/g, '');
}

function showFieldError(fieldId, message) {
    const field = document.getElementById(fieldId);
    if (field) {
        field.classList.add('error');
        
        let errorElement = field.parentElement.querySelector('.field-error');
        if (!errorElement) {
            errorElement = document.createElement('div');
            errorElement.className = 'field-error';
            field.parentElement.appendChild(errorElement);
        }
        errorElement.textContent = message;
    }
}

function clearFieldErrors() {
    const errorFields = document.querySelectorAll('.error');
    errorFields.forEach(field => {
        field.classList.remove('error');
    });
    
    const errorMessages = document.querySelectorAll('.field-error');
    errorMessages.forEach(message => {
        message.remove();
    });
}

function simulateRegistration(name, phone, email, password) {
    const cleanPhone = getCleanPhone(phone);
    showMessage('Регистрация выполняется...', 'success');
    
    setTimeout(() => {
        const userData = {
            name: name,
            phone: cleanPhone,
            email: email,
            registrationDate: new Date().toISOString()
        };
        
        localStorage.setItem('userData', JSON.stringify(userData));
        
        closeModal(document.getElementById('registerModal'));
        showMessage('Регистрация завершена успешно!', 'success');
        
        setTimeout(() => {
            window.location.href = 'login.php?message=registered';
        }, 1500);
    }, 1500);
}

function simulatePasswordRecovery(phone) {
    const cleanPhone = getCleanPhone(phone);
    showMessage('Отправка инструкций по восстановлению...', 'success');
    
    setTimeout(() => {
        closeModal(document.getElementById('forgotPasswordModal'));
        showMessage(`Инструкции по восстановлению пароля отправлены на номер +7${cleanPhone}`, 'success');
    }, 1000);
}

function showMessage(text, type) {
    const existingMessage = document.querySelector('.message');
    if (existingMessage) {
        existingMessage.remove();
    }
    
    // Скрываем ошибку при показе успешного сообщения
    if (type === 'success') {
        clearErrors();
    }
    
    const message = document.createElement('div');
    message.className = `message ${type}`;
    message.textContent = text;
    
    const form = document.querySelector('.auth-form-single form') || document.querySelector('.modal-content form');
    if (form) {
        form.insertBefore(message, form.firstChild);
    }
    
    setTimeout(() => {
        if (message.parentElement) {
            message.remove();
        }
    }, 5000);
}

function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden';
    }
}

function closeModal(modal) {
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
        
        const form = modal.querySelector('form');
        if (form) {
            form.reset();
        }
        
        const message = modal.querySelector('.message');
        if (message) {
            message.remove();
        }
        
        clearFieldErrors();
    }
}

function checkURLMessages() {
    const urlParams = new URLSearchParams(window.location.search);
    const message = urlParams.get('message');
    
    if (message === 'registered') {
        showMessage('Регистрация завершена успешно! Теперь вы можете войти.', 'success');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    initAuth();
});