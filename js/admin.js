// admin.js - функции для админ-панели
document.addEventListener('DOMContentLoaded', function() {
    initImagePreview();
    initAdminForms();
});

// Предпросмотр изображения перед загрузкой
function initImagePreview() {
    const imageInput = document.getElementById('image');
    if (imageInput) {
        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Проверяем размер файла
                if (file.size > 5 * 1024 * 1024) {
                    alert('Размер изображения не должен превышать 5MB');
                    this.value = '';
                    return;
                }
                
                // Проверяем тип файла
                const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Разрешены только изображения в форматах JPG, PNG, GIF, WEBP');
                    this.value = '';
                    return;
                }
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Создаем элемент для предпросмотра
                    let preview = document.getElementById('image-preview');
                    if (!preview) {
                        preview = document.createElement('div');
                        preview.id = 'image-preview';
                        preview.style.marginTop = '10px';
                        preview.style.textAlign = 'center';
                        imageInput.parentNode.appendChild(preview);
                    }
                    preview.innerHTML = `
                        <div style="margin-bottom: 10px;">
                            <strong>Предпросмотр:</strong>
                        </div>
                        <img src="${e.target.result}" 
                             style="max-width: 300px; max-height: 200px; border-radius: 5px; border: 2px solid #ddd;">
                    `;
                };
                reader.readAsDataURL(file);
            }
        });
    }
}

// Инициализация форм админ-панели
function initAdminForms() {
    const forms = document.querySelectorAll('form[enctype="multipart/form-data"]');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const fileInput = this.querySelector('input[type="file"]');
            if (fileInput && fileInput.files.length > 0) {
                const file = fileInput.files[0];
                
                // Проверка размера файла
                if (file.size > 5 * 1024 * 1024) {
                    e.preventDefault();
                    alert('Размер изображения не должен превышать 5MB');
                    return;
                }
                
                // Проверка типа файла
                const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                if (!allowedTypes.includes(file.type)) {
                    e.preventDefault();
                    alert('Разрешены только изображения в форматах JPG, PNG, GIF, WEBP');
                    return;
                }
            }
            
            // Показываем индикатор загрузки
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Загрузка...';
                submitBtn.disabled = true;
            }
        });
    });
}

// Подтверждение удаления
function confirmDelete(message = 'Вы уверены, что хотите удалить эту работу?') {
    return confirm(message);
}

// Управление модальными окнами для админ-панели
function openAdminModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden';
    }
}

function closeAdminModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
}