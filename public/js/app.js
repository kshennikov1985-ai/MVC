// Простой helper для AJAX-запросов к роутеру MVC.
async function apiRequest(path, options = {}) {
    const res = await fetch(path, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Content-Type': 'application/json',
            ...(options.headers || {}),
        },
        ...options,
    });
    return res.json();
}

// --- Поиск пользователей: /user/search/q/<значение> ---
const searchBtn = document.getElementById('search-btn');
if (searchBtn) {
    searchBtn.addEventListener('click', async () => {
        const q = document.getElementById('search-input').value.trim();
        const resultBox = document.getElementById('search-result');

        const data = await apiRequest(`/user/search/q/${encodeURIComponent(q)}`);

        if (!data.ok) {
            resultBox.textContent = 'Ошибка запроса';
            return;
        }

        resultBox.innerHTML = data.items
            .map(u => `<div class="bg-white rounded-3 p-3 mb-2 text-dark shadow-sm">
                            <strong>${u.name}</strong><br>
                            <span class="text-muted small">${u.email}</span>
                        </div>`)
            .join('') || '<div class="bg-white rounded-3 p-3 text-dark">Ничего не найдено</div>';
    });
}

// --- Создание пользователя: POST /user/create ---
const createForm = document.getElementById('create-form');
if (createForm) {
    createForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(createForm);
        const payload = Object.fromEntries(formData.entries());

        const data = await apiRequest('/user/create', {
            method: 'POST',
            body: JSON.stringify(payload),
        });

        if (data.ok) {
            location.reload();
        } else {
            alert(data.error || 'Ошибка сохранения');
        }
    });
}
