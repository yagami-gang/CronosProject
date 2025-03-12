// Configuration globale
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Configuration CSRF
let token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}

// Gestion des alertes
document.addEventListener('DOMContentLoaded', function() {
    // Faire disparaître les alertes après 5 secondes
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    });

    // Animation du menu déroulant utilisateur
    const userMenuButton = document.querySelector('.user-menu-button');
    const userMenu = document.querySelector('.user-menu');
    
    if (userMenuButton && userMenu) {
        userMenuButton.addEventListener('click', () => {
            userMenu.classList.toggle('hidden');
        });

        // Fermer le menu si on clique en dehors
        document.addEventListener('click', (event) => {
            if (!userMenuButton.contains(event.target) && !userMenu.contains(event.target)) {
                userMenu.classList.add('hidden');
            }
        });
    }

    // Validation des formulaires
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(event) {
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('border-red-500');
                    
                    // Créer un message d'erreur s'il n'existe pas déjà
                    if (!field.nextElementSibling?.classList.contains('error-message')) {
                        const errorMessage = document.createElement('p');
                        errorMessage.className = 'text-red-500 text-sm mt-1 error-message';
                        errorMessage.textContent = 'Ce champ est requis';
                        field.parentNode.insertBefore(errorMessage, field.nextSibling);
                    }
                } else {
                    field.classList.remove('border-red-500');
                    const errorMessage = field.nextElementSibling;
                    if (errorMessage?.classList.contains('error-message')) {
                        errorMessage.remove();
                    }
                }
            });

            if (!isValid) {
                event.preventDefault();
            }
        });
    });

    // Animation des cartes de vol
    const flightCards = document.querySelectorAll('.flight-card');
    flightCards.forEach(card => {
        card.addEventListener('mouseenter', () => {
            card.classList.add('transform', 'scale-105', 'shadow-lg');
        });

        card.addEventListener('mouseleave', () => {
            card.classList.remove('transform', 'scale-105', 'shadow-lg');
        });
    });

    // Gestion du datepicker pour les dates de vol
    const datePickers = document.querySelectorAll('input[type="date"]');
    datePickers.forEach(picker => {
        // Définir la date minimale à aujourd'hui
        const today = new Date().toISOString().split('T')[0];
        picker.setAttribute('min', today);
    });
});

// Fonction pour formater les prix
function formatPrice(price) {
    return new Intl.NumberFormat('fr-FR', {
        style: 'currency',
        currency: 'XAF'
    }).format(price);
}

// Fonction pour valider les numéros de téléphone
function validatePhone(phone) {
    const phoneRegex = /^(\+237|237)?[2368]\d{8}$/;
    return phoneRegex.test(phone);
}

// Fonction pour valider les emails
function validateEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}
