document.addEventListener('DOMContentLoaded', function() {
    const chatToggle = document.getElementById('chat-toggle');
    const chatWindow = document.getElementById('chat-window');
    const chatClose = document.getElementById('chat-close');
    const chatForm = document.getElementById('chat-form');
    const chatInput = document.getElementById('chat-input');
    const chatMessages = document.getElementById('chat-messages');

    // Afficher/masquer la fenêtre de chat
    chatToggle.addEventListener('click', function() {
        chatWindow.classList.toggle('hidden');
    });

    // Fermer la fenêtre de chat
    chatClose.addEventListener('click', function() {
        chatWindow.classList.add('hidden');
    });

    // Envoyer un message
    chatForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const message = chatInput.value.trim();
        if (!message) return;

        // Afficher le message de l'utilisateur
        addMessage('user', message);
        chatInput.value = '';

        // Afficher un indicateur de chargement
        const loadingId = 'loading-' + Date.now();
        addMessage('bot', '<div id="' + loadingId + '" class="typing-indicator"><span></span><span></span><span></span></div>', true);

        try {
            // Envoyer le message à l'API
            const response = await fetch('/api/v1/openrouter/chat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                },
                body: JSON.stringify({ message: message })
            });

            const data = await response.json();
            
            // Supprimer l'indicateur de chargement
            const loadingElement = document.getElementById(loadingId);
            if (loadingElement) {
                loadingElement.remove();
            }

            if (data.success) {
                // Afficher la réponse du bot
                addMessage('bot', data.response);
            } else {
                addMessage('bot', 'Désolé, une erreur est survenue. Veuillez réessayer.');
            }
        } catch (error) {
            console.error('Erreur:', error);
            const loadingElement = document.getElementById(loadingId);
            if (loadingElement) {
                loadingElement.remove();
            }
            addMessage('bot', 'Désolé, le service de chat est temporairement indisponible.');
        }
    });

    // Fonction pour ajouter un message au chat
    function addMessage(sender, message, isHtml = false) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `chat-message ${sender} mb-3`;
        
        const messageContent = document.createElement('div');
        messageContent.className = sender === 'user' 
            ? 'bg-blue-100 text-blue-900 rounded-lg p-3 ml-auto max-w-xs' 
            : 'bg-gray-100 text-gray-900 rounded-lg p-3 mr-auto max-w-xs';
        
        if (isHtml) {
            messageContent.innerHTML = message;
        } else {
            messageContent.textContent = message;
        }
        
        messageDiv.appendChild(messageContent);
        chatMessages.appendChild(messageDiv);
        
        // Faire défiler vers le bas
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
});
