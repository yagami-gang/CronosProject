
<!-- CSRF Token -->
@csrf

<div id="chat-widget" class="fixed right-1 bottom-4 z-50 sm:bottom-7 sm:right-7">
    <!-- Chat toggle button -->
    <button id="chat-toggle" class="flex justify-center items-center w-14 h-14 text-white bg-blue-600 rounded-full shadow-lg transition-all duration-300 hover:bg-blue-700 sm:w-16 sm:h-16 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
        <i class="text-xl fas fa-comments sm:text-2xl"></i>
        <span class="sr-only">Ouvrir le chat</span>
    </button>

    <!-- Chat window -->
    <div id="chat-window" class="hidden bg-white rounded-lg shadow-xl overflow-hidden w-[calc(100vw-2rem)] sm:w-96 h-[80vh] sm:h-[70vh] md:h-[80vh] max-h-[700px] flex flex-col transition-all duration-300 fixed bottom-20 right-0 sm:right-4 sm:bottom-20 md:right-4 md:bottom-7">
        <!-- Chat header -->
        <div class="flex justify-between items-center p-4 text-white bg-blue-600">
            <div class="flex items-center">
                <i class="mr-2 fas fa-robot"></i>
                <h3 class="font-medium">Assistant Virtuel</h3>
            </div>
            <button id="chat-close" class="text-white hover:text-blue-200 focus:outline-none">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Chat messages -->
        <div id="chat-messages" class="overflow-y-auto flex-1 p-4 space-y-4">
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
        <div class="p-3 bg-gray-50 border-t sm:p-4">
            <form id="chat-form" class="flex gap-1 sm:gap-2">
                <input type="text" id="chat-input"
                       class="flex-1 px-3 py-2 text-sm rounded-l-lg border sm:px-4 sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       placeholder="Tapez votre message..."
                       aria-label="Votre message">
                <button type="submit"
                        class="px-3 py-2 text-white bg-blue-600 rounded-r-lg transition-colors hover:bg-blue-700 sm:px-4 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
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
