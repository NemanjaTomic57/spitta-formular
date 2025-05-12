document.addEventListener('DOMContentLoaded', () => {
    // Dropdown Event Listener
    const ddButton = document.querySelector('.dd-button');
    const ddMenu = document.querySelector('.dd-menu');

    ddButton.addEventListener('click', () => {
        ddMenu.classList.toggle('show');
    });

    ddMenu.querySelectorAll('div').forEach(option => {
        option.addEventListener('click', () => {
            ddButton.textContent = option.textContent;
            ddMenu.classList.remove('show');
            document.getElementById('anrede-hidden').value = option.textContent;

            inputs.anrede = option.textContent;
            updatePreview();
        });
    });

    document.addEventListener('click', (e) => {
        if (!ddButton.contains(e.target) && !ddMenu.contains(e.target)) {
            ddMenu.classList.remove('show');
        }
    });
    
    // Live-Vorschau
    const preview = document.getElementById('preview')
    const inputs = {
        anrede: '',
        vorname: '',
        nachname: '',
        email: '',
        message: ''
    }
    
    document.getElementById('vorname').addEventListener('input', (e) => {
        inputs.vorname = e.target.value;
        updatePreview();
    });

    document.getElementById('nachname').addEventListener('input', (e) => {
        inputs.nachname = e.target.value;
        updatePreview();
    });

    document.getElementById('email').addEventListener('input', (e) => {
        inputs.email = e.target.value;
        updatePreview();
    });

    document.getElementById('message').addEventListener('input', (e) => {
        inputs.message = e.target.value;
        updatePreview();
    });

    function updatePreview() {
        const { anrede, vorname, nachname, email, message } = inputs;
        console.log('Updating preview ...')
        if (vorname || nachname || email || message) {
            preview.innerHTML = `
                <h3 class='vorschau'>Live-Vorschau:</h3>
                <p><strong>${anrede} ${vorname} ${nachname}</strong> – <em>${email}</em> schreibt:</p>
                <blockquote>„${message}“</blockquote>
            `;
        } else {
            preview.innerHTML = `<h3>Live-Vorschau:</h3>`;
        }
    }
})