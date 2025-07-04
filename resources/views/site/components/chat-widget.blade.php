
<!-- CSRF Token -->
@csrf

<div id="chat-widget" class="fixed bottom-7 right-20 z-50">
    <!-- Chat toggle button -->
    <button id="chat-toggle" class="bg-blue-600 hover:bg-blue-700 text-white rounded-full p-4 shadow-lg transition-all duration-300 flex items-center justify-center">
        <i class="fas fa-comments text-xl"></i>
    </button>
    
    <!-- Chat window -->
    <div id="chat-window" class="hidden bg-white rounded-lg shadow-xl overflow-hidden w-80 h-96 flex flex-col transition-all duration-300">
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
                <div class="bg-gray-100 rounded-lg p-3 inline-block max-w-xs">
                    <p>Bonjour ! Je suis votre assistant virtuel. Comment puis-je vous aider aujourd'hui ?</p>
                </div>
            </div>
            <div class="chat-message bot">
                <div class="bg-gray-100 rounded-lg p-3 inline-block max-w-xs">
                    <p>Vous pouvez me demander des informations sur votre réservation, l'état d'un vol, ou les retards éventuels.</p>
                </div>
            </div>
        </div>
        
        <!-- Chat input -->
        <div class="border-t p-4">
            <form id="chat-form" class="flex">
                <input type="text" id="chat-input" class="flex-1 border rounded-l-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Tapez votre message...">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white rounded-r-lg px-4 py-2 transition-colors">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script src="{{ asset('js/chat.js') }}" defer></script>
@endpush