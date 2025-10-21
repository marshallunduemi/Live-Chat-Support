<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Chat Support</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

       

        .chat-button {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            background: #dc2626;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 20px rgba(220, 38, 38, 0.4);
            transition: all 0.3s;
            z-index: 1000;
        }

        .chat-button:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 30px rgba(220, 38, 38, 0.6);
        }

        .chat-button svg {
            width: 30px;
            height: 30px;
            fill: white;
        }

        .chat-container {
            position: fixed;
            bottom: 100px;
            right: 30px;
            width: 380px;
            height: 600px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            display: none;
            flex-direction: column;
            overflow: hidden;
            z-index: 999;
            animation: slideUp 0.3s ease-out;
        }

        .chat-container.active {
            display: flex;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .chat-header {
            background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);
            color: white;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .chat-header-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .agent-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .agent-details h3 {
            font-size: 16px;
            margin-bottom: 2px;
        }

        .agent-status {
            font-size: 12px;
            opacity: 0.9;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            background: #4ade80;
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        .close-btn {
            background: none;
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
            padding: 5px;
            line-height: 1;
            transition: transform 0.2s;
        }

        .close-btn:hover {
            transform: rotate(90deg);
        }

        .chat-messages {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            background: #f9fafb;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .message {
            display: flex;
            gap: 10px;
            animation: fadeIn 0.3s;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .message.user {
            flex-direction: row-reverse;
        }

        .message-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: #dc2626;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            flex-shrink: 0;
        }

        .message.user .message-avatar {
            background: #6b7280;
        }

        .message-content {
            max-width: 70%;
        }

        .message-bubble {
            background: white;
            padding: 12px 16px;
            border-radius: 18px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            word-wrap: break-word;
        }

        .message.user .message-bubble {
            background: #dc2626;
            color: white;
        }

        .message-time {
            font-size: 11px;
            color: #9ca3af;
            margin-top: 4px;
            padding: 0 8px;
        }

        .typing-indicator {
            display: flex;
            gap: 10px;
            padding: 12px 16px;
            background: white;
            border-radius: 18px;
            width: fit-content;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .typing-indicator span {
            width: 8px;
            height: 8px;
            background: #d1d5db;
            border-radius: 50%;
            animation: typing 1.4s infinite;
        }

        .typing-indicator span:nth-child(2) {
            animation-delay: 0.2s;
        }

        .typing-indicator span:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes typing {
            0%, 60%, 100% {
                transform: translateY(0);
            }
            30% {
                transform: translateY(-10px);
            }
        }

        .quick-replies {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 8px;
        }

        .quick-reply-btn {
            background: white;
            border: 1px solid #e5e7eb;
            padding: 8px 14px;
            border-radius: 20px;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .quick-reply-btn:hover {
            background: #f3f4f6;
            border-color: #dc2626;
            color: #dc2626;
        }

        .chat-input-area {
            padding: 20px;
            background: white;
            border-top: 1px solid #e5e7eb;
        }

        .chat-input-wrapper {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .chat-input {
            flex: 1;
            padding: 12px 16px;
            border: 1px solid #e5e7eb;
            border-radius: 25px;
            font-size: 14px;
            outline: none;
            transition: all 0.2s;
        }

        .chat-input:focus {
            border-color: #dc2626;
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
        }

        .send-btn {
            width: 45px;
            height: 45px;
            background: #dc2626;
            border: none;
            border-radius: 50%;
            color: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .send-btn:hover {
            background: #b91c1c;
            transform: scale(1.05);
        }

        .send-btn:disabled {
            background: #d1d5db;
            cursor: not-allowed;
            transform: scale(1);
        }

        @media (max-width: 768px) {
            .chat-container {
                width: calc(100% - 20px);
                height: calc(100vh - 120px);
                right: 10px;
                bottom: 90px;
            }

            .chat-button {
                right: 20px;
                bottom: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="chat-button" onclick="toggleChat()">
        <svg viewBox="0 0 24 24">
            <path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H6l-2 2V4h16v12z"/>
        </svg>
    </div>

    <div class="chat-container" id="chatContainer">
        <div class="chat-header">
            <div class="chat-header-info">
                <div class="agent-avatar">👋</div>
                <div class="agent-details">
                    <h3>Customer Support</h3>
                    <div class="agent-status">
                        <span class="status-dot"></span>
                        Online now
                    </div>
                </div>
            </div>
            <button class="close-btn" onclick="toggleChat()">×</button>
        </div>

        <div class="chat-messages" id="chatMessages">
            <div class="message">
                <div class="message-avatar">🤖</div>
                <div class="message-content">
                    <div class="message-bubble">
                        Hi there! 👋 Welcome to our support chat. How can we help you today?
                    </div>
                    <div class="message-time">Just now</div>
                    <div class="quick-replies">
                        <button class="quick-reply-btn" onclick="sendQuickReply('Track my order')">Track my order</button>
                        <button class="quick-reply-btn" onclick="sendQuickReply('Return request')">Return request</button>
                        <button class="quick-reply-btn" onclick="sendQuickReply('Payment issue')">Payment issue</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="chat-input-area">
            <div class="chat-input-wrapper">
                <input 
                    type="text" 
                    class="chat-input" 
                    id="messageInput" 
                    placeholder="Type your message..."
                    onkeypress="handleKeyPress(event)"
                >
                <button class="send-btn" onclick="sendMessage()" id="sendBtn">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="22" y1="2" x2="11" y2="13"></line>
                        <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <script>
        let messageCount = 0;

        function toggleChat() {
            const container = document.getElementById('chatContainer');
            container.classList.toggle('active');
            if (container.classList.contains('active')) {
                document.getElementById('messageInput').focus();
            }
        }

        function handleKeyPress(event) {
            if (event.key === 'Enter') {
                sendMessage();
            }
        }

        function sendMessage() {
            const input = document.getElementById('messageInput');
            const message = input.value.trim();
            
            if (message === '') return;
            
            addMessage(message, 'user');
            input.value = '';
            
            showTypingIndicator();
            setTimeout(() => {
                removeTypingIndicator();
                addBotResponse(message);
            }, 1500);
        }

        function sendQuickReply(message) {
            addMessage(message, 'user');
            showTypingIndicator();
            setTimeout(() => {
                removeTypingIndicator();
                addBotResponse(message);
            }, 1500);
        }

        function addMessage(text, sender) {
            const messagesContainer = document.getElementById('chatMessages');
            const time = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            
            const messageDiv = document.createElement('div');
            messageDiv.className = `message ${sender}`;
            messageDiv.innerHTML = `
                <div class="message-avatar">${sender === 'user' ? '👤' : '🤖'}</div>
                <div class="message-content">
                    <div class="message-bubble">${text}</div>
                    <div class="message-time">${time}</div>
                </div>
            `;
            
            messagesContainer.appendChild(messageDiv);
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
            messageCount++;
        }

        function showTypingIndicator() {
            const messagesContainer = document.getElementById('chatMessages');
            const typingDiv = document.createElement('div');
            typingDiv.className = 'message';
            typingDiv.id = 'typingIndicator';
            typingDiv.innerHTML = `
                <div class="message-avatar">🤖</div>
                <div class="message-content">
                    <div class="typing-indicator">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            `;
            messagesContainer.appendChild(typingDiv);
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        function removeTypingIndicator() {
            const indicator = document.getElementById('typingIndicator');
            if (indicator) {
                indicator.remove();
            }
        }

        function addBotResponse(userMessage) {
            const lowerMessage = userMessage.toLowerCase();
            let response = '';

            if (lowerMessage.includes('track') || lowerMessage.includes('order')) {
                 // Extract possible order number (e.g. "order 12345")
    const match = userMessage.match(/\b\d{4,}\b/); // any 4+ digit number
    if (match) {
      const orderNumber = match[0];
      response = "Please wait... checking order #" + orderNumber + " 🕒";
      addMessage(response, 'bot');

      fetch('bot.track_order.php?order_no=' + orderNumber)
        .then(res => res.json())
        .then(data => {
          if (data.status === 'success') {
            addMessage(
              `📦 Order #${data.order_no}\nStatus: ${data.status_text}\nDate: ${data.order_date}\nAmount: ₦${data.amount}\nShipping: ${data.shipping_status}`,
              'bot'
            );
          } else {
            addMessage("❌ Sorry, no order found with that number.", 'bot');
          }
        })
        .catch(() => addMessage("⚠️ Unable to fetch order details right now.", 'bot'));
      return;
    } else {
      response = "I'd be happy to help you track your order! Please provide your order number. 📦";
    }
              //  response = "I'd be happy to help you track your order! Please provide your order number and I'll look that up for you right away. 📦";
            } else if (lowerMessage.includes('ORDER') || lowerMessage.includes('order')) {
                response = "Please wait....";
            } else if (lowerMessage.includes('return')) {
                response = "Our return process is simple! You can initiate a return within 30 days of purchase. Would you like me to guide you through the process?";
            } else if (lowerMessage.includes('payment') || lowerMessage.includes('billing')) {
                response = "I can help with payment issues. Could you please describe the specific problem you're experiencing with your payment?";
            } else if (lowerMessage.includes('shipping')) {
                response = "We offer standard (5-7 days) and express (2-3 days) shipping. Which option would you like to know more about?";
            } else if (lowerMessage.includes('hello') || lowerMessage.includes('hi')) {
                response = "Hello! How can I assist you today? 😊";
            } else if (lowerMessage.includes('thank')) {
                response = "You're welcome! Is there anything else I can help you with?";
            } else {
                response = "Thank you for your message! A customer service representative will assist you shortly. In the meantime, is there anything specific I can help clarify?";
            }

            addMessage(response, 'bot');
        }
    </script>
</body>
</html>
