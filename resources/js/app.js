

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
document.querySelectorAll('.vote-button').forEach((button) => {
    button.addEventListener('click', async () => {
        button.disabled = true;

        try {
            const response = await fetch(button.dataset.url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute('content'),
                    Accept: 'application/json',
                },
            });

            if (!response.ok) {
                return;
            }

            const data = await response.json();

            button.querySelector('.vote-count').textContent = data.count;

            button.classList.toggle('font-bold', data.voted);
        } finally {
            button.disabled = false;
        }
    });
});