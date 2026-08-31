

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.data('filePicker', () => {
    let selectedFiles = [];

    return {
        files: [],

        addFiles(event) {
            const newFiles = Array.from(event.target.files);

            newFiles.forEach((file) => {
                const alreadyAdded = selectedFiles.some(
                    (existing) =>
                        existing.name === file.name &&
                        existing.size === file.size &&
                        existing.lastModified === file.lastModified,
                );

                if (!alreadyAdded) {
                    selectedFiles.push(file);
                }
            });

            this.updateDisplay();
            this.syncInput();
        },

        removeFile(index) {
            selectedFiles.splice(index, 1);

            this.updateDisplay();
            this.syncInput();
        },

        updateDisplay() {
            this.files = selectedFiles.map((file) => ({
                name: file.name,
                size: file.size,
                lastModified: file.lastModified,
            }));
        },

        syncInput() {
            const dataTransfer = new DataTransfer();

            selectedFiles.forEach((file) => {
                dataTransfer.items.add(file);
            });

            this.$refs.fileInput.files = dataTransfer.files;
        },
    };
});

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

            button.setAttribute('aria-pressed', data.voted ? 'true' : 'false');
        } finally {
            button.disabled = false;
        }
    });
});
