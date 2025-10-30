<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>AHHAM - AI Assistant</title>
    
    <!-- Fonts -->
    <link rel="dpreconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom AHHAM Styles -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Figtree', sans-serif;
            background: linear-gradient(135deg, #0c0c0c 0%, #1a1a2e 50%, #16213e 100%);
            min-height: 100vh;
            overflow-x: hidden;
        }
        
        .ahham-container {
            min-height: 100vh;
            position: relative;
            overflow: hidden;
        }
        
        .neural-network-bg {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(120, 219, 255, 0.2) 0%, transparent 50%);
            animation: neuralPulse 4s ease-in-out infinite;
        }
        
        @keyframes neuralPulse {
            0%, 100% { opacity: 0.3; }
            50% { opacity: 0.6; }
        }
        
        .ahham-header {
            text-align: center;
            padding: 2rem 1rem;
            position: relative;
            z-index: 2;
        }
        
        .ahham-title h1 {
            font-size: 3rem;
            font-weight: 900;
            background: linear-gradient(45deg, #00d4ff, #ff00ff, #00ff88);
            background-size: 300% 300%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: gradientShift 3s ease infinite;
            margin-bottom: 0.5rem;
            text-shadow: 0 0 30px rgba(0, 212, 255, 0.5);
        }
        
        .glitch {
            position: relative;
        }
        
        .glitch::before,
        .glitch::after {
            content: attr(data-text);
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
        
        .glitch::before {
            animation: glitch-1 0.5s infinite;
            color: #ff00ff;
            z-index: -1;
        }
        
        .glitch::after {
            animation: glitch-2 0.5s infinite;
            color: #00ffff;
            z-index: -2;
        }
        
        @keyframes glitch-1 {
            0%, 14%, 15%, 49%, 50%, 99%, 100% { transform: translate(0); }
            15%, 49% { transform: translate(-2px, 2px); }
        }
        
        @keyframes glitch-2 {
            0%, 20%, 21%, 62%, 63%, 99%, 100% { transform: translate(0); }
            21%, 62% { transform: translate(2px, -2px); }
        }
        
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .subtitle {
            color: #a0a0a0;
            font-size: 1.2rem;
            margin-bottom: 1rem;
        }
        
        .status-indicator {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            color: #00ff88;
            font-weight: 500;
        }
        
        .pulse-dot {
            width: 8px;
            height: 8px;
            background: #00ff88;
            border-radius: 50%;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.2); opacity: 0.7; }
            100% { transform: scale(1); opacity: 1; }
        }
        
        .chat-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem;
            position: relative;
            z-index: 2;
        }
        
        .chat-messages {
            max-height: 400px;
            overflow-y: auto;
            margin-bottom: 1rem;
            padding: 1rem;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .message {
            display: flex;
            margin-bottom: 1.5rem;
            animation: messageSlide 0.3s ease-out;
        }
        
        @keyframes messageSlide {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .user-message {
            flex-direction: row-reverse;
        }
        
        .message-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 1rem;
            flex-shrink: 0;
        }
        
        .ai-avatar {
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, #00d4ff, #ff00ff);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            box-shadow: 0 0 20px rgba(0, 212, 255, 0.5);
        }
        
        .user-avatar {
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, #667eea, #764ba2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
        }
        
        .message-content {
            flex: 1;
            max-width: 70%;
        }
        
        .message-bubble {
            background: rgba(255, 255, 255, 0.1);
            padding: 1rem 1.5rem;
            border-radius: 20px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
        }
        
        .bot-message .message-bubble {
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.2), rgba(255, 0, 255, 0.2));
            border: 1px solid rgba(0, 212, 255, 0.3);
        }
        
        .user-message .message-bubble {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.2), rgba(118, 75, 162, 0.2));
            border: 1px solid rgba(102, 126, 234, 0.3);
        }
        
        .message-bubble p {
            margin: 0;
            color: #ffffff;
            line-height: 1.5;
        }
        
        .message-time {
            font-size: 0.8rem;
            color: #a0a0a0;
            margin-top: 0.5rem;
            text-align: right;
        }
        
        .typing {
            background: rgba(255, 255, 255, 0.1) !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
        }
        
        .typing-dots {
            display: flex;
            gap: 4px;
            align-items: center;
        }
        
        .typing-dots span {
            width: 8px;
            height: 8px;
            background: #00d4ff;
            border-radius: 50%;
            animation: typingDot 1.4s infinite ease-in-out;
        }
        
        .typing-dots span:nth-child(1) { animation-delay: -0.32s; }
        .typing-dots span:nth-child(2) { animation-delay: -0.16s; }
        
        @keyframes typingDot {
            0%, 80%, 100% { transform: scale(0.8); opacity: 0.5; }
            40% { transform: scale(1); opacity: 1; }
        }
        
        .chat-input-container {
            padding: 1rem 2rem 2rem;
            background: rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
        }
        
        .input-wrapper {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
            align-items: center;
        }
        
        .chat-input {
            flex: 1;
            padding: 1rem 1.5rem;
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 25px;
            background: rgba(255, 255, 255, 0.05);
            color: white;
            font-size: 1rem;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }
        
        .chat-input:focus {
            outline: none;
            border-color: #00d4ff;
            box-shadow: 0 0 20px rgba(0, 212, 255, 0.3);
            background: rgba(255, 255, 255, 0.1);
        }
        
        .chat-input::placeholder {
            color: #a0a0a0;
        }
        
        .send-button {
            width: 50px;
            height: 50px;
            border: none;
            border-radius: 50%;
            background: linear-gradient(45deg, #00d4ff, #ff00ff);
            color: white;
            font-size: 1.2rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .send-button:hover {
            transform: scale(1.1);
            box-shadow: 0 0 20px rgba(0, 212, 255, 0.5);
        }
        
        .quick-actions {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            justify-content: center;
        }
        
        .quick-btn {
            padding: 0.5rem 1rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.05);
            color: #a0a0a0;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .quick-btn:hover {
            background: rgba(0, 212, 255, 0.2);
            border-color: #00d4ff;
            color: #00d4ff;
            transform: translateY(-2px);
        }
        
        /* Scrollbar Styling */
        .chat-messages::-webkit-scrollbar {
            width: 6px;
        }
        
        .chat-messages::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 3px;
        }
        
        .chat-messages::-webkit-scrollbar-thumb {
            background: linear-gradient(45deg, #00d4ff, #ff00ff);
            border-radius: 3px;
        }
        
        .chat-messages::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(45deg, #00b8e6, #e600e6);
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .ahham-title h1 {
                font-size: 2rem;
            }
            
            .chat-container {
                padding: 1rem;
            }
            
            .message-content {
                max-width: 85%;
            }
            
            .quick-actions {
                flex-direction: column;
                align-items: center;
            }
            
            .quick-btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="ahham-container">
        <!-- Animated Background -->
        <div class="neural-network-bg"></div>
        
        <!-- Header -->
        <div class="ahham-header">
            <div class="ahham-title">
                <h1 class="glitch" data-text="AHHAM">AHHAM</h1>
                <p class="subtitle">Your AI CRM Assistant</p>
                <div class="status-indicator">
                    <span class="pulse-dot"></span>
                    <span>Online & Ready</span>
                </div>
            </div>
        </div>

        <!-- Chat Interface -->
        <div class="chat-container">
            <div class="chat-messages" id="chatMessages">
                <!-- Welcome message -->
                <div class="message bot-message">
                    <div class="message-avatar">
                        <div class="ai-avatar">
                            <i class="fas fa-robot"></i>
                        </div>
                    </div>
                    <div class="message-content">
                        <div class="message-bubble">
                            <p>Hello! I'm AHHAM, your AI assistant. I'm here to help you with your CRM tasks, answer questions, and provide intelligent insights. How can I assist you today?</p>
                        </div>
                        <div class="message-time">{{ now()->format('H:i') }}</div>
                    </div>
                </div>
            </div>

            <!-- Typing indicator -->
            <div class="typing-indicator" id="typingIndicator" style="display: none;">
                <div class="message bot-message">
                    <div class="message-avatar">
                        <div class="ai-avatar">
                            <i class="fas fa-robot"></i>
                        </div>
                    </div>
                    <div class="message-content">
                        <div class="message-bubble typing">
                            <div class="typing-dots">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Input Area -->
        <div class="chat-input-container">
            <div class="input-wrapper">
                <input type="text" 
                       id="messageInput" 
                       class="chat-input" 
                       placeholder="Ask AHHAM anything about your CRM..."
                       autocomplete="off">
                <button class="send-button" id="sendButton">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
            <div class="quick-actions">
                <button class="quick-btn" data-message="Show me today's tasks">
                    <i class="fas fa-tasks"></i>
                    Today's Tasks
                </button>
                <button class="quick-btn" data-message="What are my upcoming meetings?">
                    <i class="fas fa-calendar"></i>
                    Meetings
                </button>
                <button class="quick-btn" data-message="Show employee statistics">
                    <i class="fas fa-chart-bar"></i>
                    Analytics
                </button>
                <button class="quick-btn" data-message="Help me with reports">
                    <i class="fas fa-file-alt"></i>
                    Reports
                </button>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const messageInput = document.getElementById('messageInput');
            const sendButton = document.getElementById('sendButton');
            const chatMessages = document.getElementById('chatMessages');
            const typingIndicator = document.getElementById('typingIndicator');
            const quickButtons = document.querySelectorAll('.quick-btn');

            // Send message function
            function sendMessage(message) {
                if (!message.trim()) return;

                // Add user message to chat
                addMessage(message, 'user');
                
                // Show typing indicator
                showTypingIndicator();
                
                // Clear input
                messageInput.value = '';
                
                // Send to server
                console.log('Sending message to:', '{{ route("ahham.chat") }}');
                console.log('Message:', message);
                
                fetch('{{ route("ahham.chat") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ message: message })
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    console.log('Response headers:', response.headers);
                    return response.json();
                })
                .then(data => {
                    console.log('Response data:', data);
                    hideTypingIndicator();
                    if (data.success) {
                        addMessage(data.message, 'bot');
                    } else {
                        addMessage('Error: ' + (data.message || 'Unknown error'), 'bot');
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    hideTypingIndicator();
                    addMessage('Sorry, I encountered an error. Please try again.', 'bot');
                });
            }

            // Add message to chat
            function addMessage(message, type) {
                const messageDiv = document.createElement('div');
                messageDiv.className = `message ${type}-message`;
                
                const avatar = type === 'bot' ? 
                    '<div class="ai-avatar"><i class="fas fa-robot"></i></div>' :
                    '<div class="user-avatar"><i class="fas fa-user"></i></div>';
                
                const time = new Date().toLocaleTimeString('en-US', { 
                    hour12: false, 
                    hour: '2-digit', 
                    minute: '2-digit' 
                });
                
                messageDiv.innerHTML = `
                    <div class="message-avatar">
                        ${avatar}
                    </div>
                    <div class="message-content">
                        <div class="message-bubble">
                            <p>${message}</p>
                        </div>
                        <div class="message-time">${time}</div>
                    </div>
                `;
                
                chatMessages.appendChild(messageDiv);
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }

            // Show typing indicator
            function showTypingIndicator() {
                typingIndicator.style.display = 'block';
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }

            // Hide typing indicator
            function hideTypingIndicator() {
                typingIndicator.style.display = 'none';
            }

            // Event listeners
            sendButton.addEventListener('click', () => {
                sendMessage(messageInput.value);
            });

            messageInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    sendMessage(messageInput.value);
                }
            });

            // Quick action buttons
            quickButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const message = button.getAttribute('data-message');
                    sendMessage(message);
                });
            });

            // Auto-focus input
            messageInput.focus();
        });
    </script>
</body>
</html>

