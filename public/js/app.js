// Configuration globale
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Configuration CSRF
let token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}

// Gestion des requêtes AJAX
window.handleAjaxError = function(error) {
    if (error.response) {
        // La requête a été faite et le serveur a répondu avec un code d'état
        console.error('Error data:', error.response.data);
        console.error('Error status:', error.response.status);
        console.error('Error headers:', error.response.headers);
    } else if (error.request) {
        // La requête a été faite mais aucune réponse n'a été reçue
        console.error('Error request:', error.request);
    } else {
        // Une erreur s'est produite lors de la configuration de la requête
        console.error('Error message:', error.message);
    }
    console.error('Error config:', error.config);
};

// Configuration des intercepteurs Axios
axios.interceptors.response.use(
    response => response,
    error => {
        handleAjaxError(error);
        return Promise.reject(error);
    }
);

// Initialisation des composants Bootstrap
document.addEventListener('DOMContentLoaded', () => {
    // Activation des tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Activation des popovers
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });

    // Gestion du formulaire de recherche de vols
    document.addEventListener('DOMContentLoaded', () => {
        const searchForm = document.querySelector('.flight-search-form');
        if (searchForm) {
            searchForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                const formData = new FormData(searchForm);
                try {
                    const response = await axios.post('/api/flights/search', formData);
                    // Traitement des résultats
                    updateSearchResults(response.data);
                } catch (error) {
                    handleAjaxError(error);
                }
            });
        }
    });

    // Fonction de mise à jour des résultats de recherche
    function updateSearchResults(data) {
        const resultsContainer = document.querySelector('.search-results');
        if (resultsContainer && data.flights) {
            resultsContainer.innerHTML = data.flights.map(flight => `
                <div class="flight-card">
                    <div class="flight-info">
                        <h3>${flight.departure} → ${flight.destination}</h3>
                        <p>Date: ${flight.departure_date}</p>
                        <p>Prix: ${flight.price}€</p>
                    </div>
                    <a href="/flights/${flight.id}" class="btn-details">Détails</a>
                </div>
            `).join('');
        }
    }

    // Animation du scroll
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Gestion des notifications
    window.showNotification = function(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.innerHTML = `
            <div class="notification-content">
                <p>${message}</p>
                <button class="notification-close">&times;</button>
            </div>
        `;
        document.body.appendChild(notification);
    
        setTimeout(() => {
            notification.remove();
        }, 5000);
    
        notification.querySelector('.notification-close').addEventListener('click', () => {
            notification.remove();
        });
    };
});
