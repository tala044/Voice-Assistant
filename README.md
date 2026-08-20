Voice Assistant
An Arabic voice assistant built with JavaScript, PHP, Web Speech API,
and Gemini API.
Live Demo
Open the Voice Assistant
Project Overview
This project is a web-based voice assistant that allows the user to
speak through the microphone. The browser converts the Arabic speech
into text, sends the text to a PHP backend, and the backend communicates
with the Gemini API to generate a response.
The assistant then displays the response in the chat and can read it
aloud.
Features
Arabic speech-to-text using the Web Speech API.
Microphone button for voice input.
Sends recognized speech to the PHP backend.
Gemini API integration for generating responses.
Displays user and assistant messages in a chat interface.
Text-to-speech for assistant responses.
PHP error handling for invalid requests and API failures.
API key kept on the server side through `config.php`.
Technologies Used
HTML
CSS
JavaScript
PHP
Web Speech API
Gemini API
InfinityFree
Project Structure
``` text
Voice-Assistant/
├── .htaccess
├── README.md
├── app.js
├── index.html
├── style.css
└── api/
    └── assistant.php
```
> `config.php` is used on the server to store the Gemini API key and
> should not be uploaded publicly when it contains the real API key.
How It Works
The user opens the website.
The user presses the microphone button.
The browser requests microphone access.
The Web Speech API recognizes the Arabic speech and converts it to
text.
JavaScript sends the text to `api/assistant.php` using a POST
request.
The PHP backend receives the prompt.
PHP sends the prompt to the Gemini API.
Gemini generates the response.
PHP returns the response as JSON.
JavaScript displays the response in the chat.
The browser can read the response using text-to-speech.
Problem Solved
During development, the voice assistant was not returning a response
from Gemini.
The application initially used the following Gemini model:
``` text
gemini-2.5-flash
```
When the request reached the Gemini API, the API returned an error
indicating that this model was no longer available to new users and
recommended updating the code to a newer model.
The problem was identified by adding error handling to the PHP backend.
This allowed the actual Gemini API response and HTTP status to be
returned instead of showing only a generic failure message.
The model was then updated to:
``` text
gemini-3.6-flash
```
After this change, the PHP backend successfully communicated with Gemini
and the assistant returned responses correctly.
Error Handling Added
The PHP backend checks for:
Missing `config.php`.
Invalid HTTP request methods.
Empty prompts.
Missing Gemini API keys.
Failed cURL connections.
HTTP errors returned by Gemini.
Unexpected Gemini API responses.
These checks made it possible to identify the real cause of the problem
during development.
Backend
The main backend endpoint is:
``` text
api/assistant.php
```
It receives the user's prompt through a POST request and sends it to
Gemini.
The Gemini API key is stored in `config.php` on the server instead of
being exposed in the frontend JavaScript.
Deployment
The project was deployed using InfinityFree.
The live version is available here:
https://tala.free.je/c/
Security
The Gemini API key should never be placed directly inside `app.js` or
another frontend file.
The real `config.php` containing the API key should remain on the server
and should not be committed to a public GitHub repository.
Notes
The project uses the Gemini model:
``` text
gemini-3.6-flash
```
The final version successfully recognizes Arabic speech, sends the text
to the PHP backend, communicates with Gemini, and displays the generated
response.
