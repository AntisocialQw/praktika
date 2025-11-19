<section class="auth-section">
    <div class="container" style="display: flex; justify-content: center; align-items: center; min-height: 100vh;">
        <div class="auth-form-single" style="width: 100%; max-width: 400px; padding: 20px;">
            <h2 style="text-align: center; margin-bottom: 20px;">Вход в личный кабинет</h2>
            
            <!-- Блок для отображения ошибок -->
            <div id="errorMessage" class="error-message" style="display: none;"></div>
            
            <form id="loginForm">
                <div class="form-group">
                    <label for="phone">Номер телефона</label>
                    <div class="phone-input">
                        <span class="phone-prefix">+7</span>
                        <input type="tel" id="phone" class="form-control" placeholder="(999) 999-99-99" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="password">Пароль</label>
                    <div class="password-input">
                        <input type="password" id="password" class="form-control" placeholder="Введите пароль" required>
                        <button type="button" class="toggle-password" id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                
                <div class="form-options">
                    <label class="checkbox-label">
                        <input type="checkbox" id="rememberMe">
                        <span class="checkmark"></span>
                        Запомнить меня
                    </label>
                    <a href="#forgot-password" class="forgot-password">Забыли пароль?</a>
                </div>
                
                <button type="submit" class="btn btn-full">Войти</button>
                
                <div class="auth-divider">
                    <span>или</span>
                </div>
                
                <button type="button" class="btn btn-outline btn-full" id="registerBtn">
                    Создать аккаунт
                </button>
            </form>
        </div>
    </div>
</section>

<!-- Модальное окно восстановления пароля -->
<div id="forgotPasswordModal" class="modal">
    <div class="modal-content" style="max-width: 400px;">
        <span class="close-modal">&times;</span>
        <h2>Восстановление пароля</h2>
        <form id="forgotPasswordForm">
            <div class="form-group">
                <label for="recoveryPhone">Номер телефона</label>
                <div class="phone-input">
                    <span class="phone-prefix">+7</span>
                    <input type="tel" id="recoveryPhone" class="form-control" placeholder="(999) 999-99-99" required>
                </div>
            </div>
            <button type="submit" class="btn">Восстановить пароль</button>
        </form>
    </div>
</div>

<!-- Модальное окно регистрации -->
<div id="registerModal" class="modal">
    <div class="modal-content" style="max-width: 400px;">
        <span class="close-modal">&times;</span>
        <h2>Регистрация</h2>
        <form id="registerForm">
            <div class="form-group">
                <label for="regName">Имя и фамилия</label>
                <input type="text" id="regName" class="form-control" placeholder="Введите ваше имя и фамилию" required>
            </div>
            
            <div class="form-group">
                <label for="regPhone">Номер телефона</label>
                <div class="phone-input">
                    <span class="phone-prefix">+7</span>
                    <input type="tel" id="regPhone" class="form-control" placeholder="(999) 999-99-99" required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="regEmail">Email</label>
                <input type="email" id="regEmail" class="form-control" placeholder="example@mail.ru" required>
            </div>
            
            <div class="form-group">
                <label for="regPassword">Пароль</label>
                <div class="password-input">
                    <input type="password" id="regPassword" class="form-control" placeholder="Минимум 6 символов" required minlength="6">
                    <button type="button" class="toggle-password">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>
            
            <div class="form-group">
                <label for="regConfirmPassword">Подтвердите пароль</label>
                <div class="password-input">
                    <input type="password" id="regConfirmPassword" class="form-control" placeholder="Повторите пароль" required minlength="6">
                    <button type="button" class="toggle-password">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>
            
            <div class="form-group">
                <label class="checkbox-label" id="agreeTermsLabel">
                    <input type="checkbox" id="agreeTerms" required>
                    <span class="checkmark"></span>
                    Я соглашаюсь с <a href="#" class="link">правилами обработки персональных данных</a>
                </label>
            </div>
            
            <button type="submit" class="btn btn-full">Зарегистрироваться</button>
        </form>
    </div>
</div>