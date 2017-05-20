# A-Message-Board-using-PHP-and-MySQL

There are two PHP scrips 
 - login.php 
 - board.php. 
 
The login.php script generates a form that has two text windows for username and password and a "Login" button. The board.php has a "Logout" button, a textarea to write a message, a "New Post" button, and a list of messages. The board script prints all the messages in the database as a flat list ordered by date/time (newest first, oldest last). Note: messages should not be organized based on their replyto attributes. For each posted message, it prints:

- The message ID.
- The username and the fullname of the person who posted the message.
- The date and time when this message was posted.
- If this is a reply to a message, the ID of this message.
- The message text.
- A button "Reply" to reply to this message.

The program flow is as follows:

- From the login script, if the user enters a wrong username/password and pushes "Login", it should go to the login script again. 
- If the user enters a correct username/password and pushes "Login", it should go to the board script. 
- From the board script, if the user pushes "Logout", it should logout and go to the login script. 
- The board script must always make sure that only authorized used (users who have logged-in properly) can view and post messages. 
- From the board script, if the user fills out the textarea and pushes the "New Post" button, it will insert the new message in the database (with null replyto attribute) and will go to the board script again. 
- If the user fills out the textarea and pushes the "Reply" button, it will insert the message in the database -- but this time you need to set the replyto value, and will go to the board script again.
