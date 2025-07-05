
<!-- CSRF Token -->
@csrf

<div id="chat-widget" class="fixed bottom-4 right-4 sm:bottom-7 sm:right-7 z-50">
    <!-- Chat toggle button -->
    <button id="chat-toggle" class="bg-blue-600 hover:bg-blue-700 text-white rounded-full w-14 h-14 sm:w-16 sm:h-16 flex items-center justify-center shadow-lg transition-all duration-300 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
        <i class="fas fa-comments text-xl sm:text-2xl"></i>
        <span class="sr-only">Ouvrir le chat</span>
    </button>
    
    <!-- Chat window -->
    <div id="chat-window" class="hidden bg-white rounded-lg shadow-xl overflow-hidden w-[calc(100vw-2rem)] sm:w-96 h-[80vh] sm:h-[70vh] md:h-[80vh] max-h-[700px] flex flex-col transition-all duration-300 fixed bottom-20 right-0 sm:right-4 sm:bottom-20 md:right-4 md:bottom-7">
        <!-- Chat header -->
        <div class="bg-blue-600 text-white p-4 flex justify-between items-center">
            <div class="flex items-center">
                <i class="fas fa-robot mr-2"></i>
                <h3 class="font-medium">Assistant Virtuel</h3>
            </div>
            <button id="chat-close" class="text-white hover:text-blue-200 focus:outline-none">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <!-- Chat messages -->
        <div id="chat-messages" class="flex-1 overflow-y-auto p-4 space-y-4">
            <div class="chat-message bot">
                <div class="bg-gray-100 rounded-lg p-3 inline-block max-w-[85%] sm:max-w-xs">
                    <p>Bonjour ! Je suis votre assistant virtuel. Comment puis-je vous aider aujourd'hui ?</p>
                </div>
            </div>
            <div class="chat-message bot">
                <div class="bg-gray-100 rounded-lg p-3 inline-block max-w-[85%] sm:max-w-xs">
                    <p>Vous pouvez me demander des informations sur votre réservation, l'état d'un vol, ou les retards éventuels.</p>
                </div>
            </div>
        </div>
        
        <!-- Chat input -->
        <div class="border-t p-3 sm:p-4 bg-gray-50">
            <form id="chat-form" class="flex gap-1 sm:gap-2">
                <input type="text" id="chat-input" 
                       class="flex-1 border rounded-l-lg px-3 sm:px-4 py-2 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                       placeholder="Tapez votre message..."
                       aria-label="Votre message">
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white rounded-r-lg px-3 sm:px-4 py-2 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                        aria-label="Envoyer le message">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script src="{{ asset('js/chat.js') }}" defer></script>
@endpush