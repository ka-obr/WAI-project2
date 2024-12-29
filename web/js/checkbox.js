document.addEventListener('DOMContentLoaded', function() {
    const rememberForm = document.getElementById('remember-form');
    if (rememberForm) {
        rememberForm.addEventListener('submit', function(event) {
            const checkboxes = document.querySelectorAll('input[name="selected_images[]"]:checked');
            checkboxes.forEach(checkbox => {
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'selected_images[]';
                hiddenInput.value = checkbox.value;
                this.appendChild(hiddenInput);
            });
        });
    }
});