# Live-Chat-Inc-REST-Chats
This is a very simple class to help create, send, monitor, and close chats within the Live Chat Inc system.

----

How to use?

Include this file in to your PHP file and create the object.

$chat = new LiveChatInc($license_id, $group_id, $chat_id, $secured_session_id);

To create a new chat use:

$chat->createChat("This is a hidden welcome message for staff","Customer Name","customer@email.com");

To send a new chat message from user to staff use:

$chat->sendChat("This is the new message");

To enquire about new messages from staff use:

$chat->getPendingChats($last_msg_id);

To end a chat use:

$chat->closeChat();
