# Voice Assistant

An Arabic voice assistant built with JavaScript, PHP, Web Speech API, and Gemini API.

## Live Demo

[Open the Voice Assistant](https://tala.free.je/c/)

## Project Overview

This project is a web-based voice assistant that allows the user to speak through the microphone. The browser converts Arabic speech into text, sends the text to a PHP backend, and the backend communicates with the Gemini API to generate a response.

The assistant then displays the response in the chat and can read it aloud.

## Features

- Arabic speech-to-text using the Web Speech API.
- Microphone button for voice input.
- Sends recognized speech to the PHP backend.
- Gemini API integration for generating responses.
- Displays user and assistant messages in a chat interface.
- Text-to-speech for assistant responses.
- PHP error handling for invalid requests and API failures.
- API key stored securely on the server.

## Technologies Used

- HTML
- CSS
- JavaScript
- PHP
- Web Speech API
- Gemini API
- InfinityFree

## Project Structure

```text
Voice-Assistant/
├── .htaccess
├── README.md
├── app.js
├── index.html
├── style.css
└── api/
    └── assistant.php
The user opens the website.
The user presses the microphone button.
The browser requests microphone access.
The Web Speech API recognizes the Arabic speech and converts it to text.
JavaScript sends the text to api/assistant.php using a POST request.
The PHP backend receives the prompt.
PHP sends the prompt to the Gemini API.
Gemini generates the response.
PHP returns the response as JSON.
JavaScript displays the response in the chat.
The browser reads the response using text-to-speech.
Problem Solved

During development, the voice assistant was not returning a response from Gemini.

The application initially used the Gemini model:

gemini-2.5-flash

When the request reached the Gemini API, the API returned an error indicating that this model was no longer available to new users and recommended updating the code to a newer model.

To identify the actual cause of the problem, error handling was added to the PHP backend. This allowed the application to display the HTTP status and the error returned by the Gemini API instead of showing only a generic error message.

The model was then updated to:

gemini-3.6-flash

After this change, the PHP backend successfully communicated with Gemini and the voice assistant returned responses correctly.

Error Handling

The PHP backend checks for:

Missing config.php
Invalid HTTP request methods
Empty prompts
Missing Gemini API keys
Failed cURL connections
HTTP errors returned by Gemini
Unexpected Gemini API responses

These checks helped identify the actual cause of the API problem during development.

Backend

The main backend endpoint is:

api/assistant.php

It receives the user's prompt through a POST request and sends it to the Gemini API.

The Gemini API key is stored in config.php on the server instead of being exposed in the frontend JavaScript.

Deployment

The project was deployed using InfinityFree.

The live version is available here:

Open the Voice Assistant

Security

The Gemini API key should not be placed directly inside app.js or any other frontend file.

The real config.php containing the API key should remain on the server and should not be committed to a public GitHub repository.

Final Result

The final version successfully:

Recognizes Arabic speech.
Converts speech into text.
Sends the text to the PHP backend.
Communicates with the Gemini API.
Displays the generated response.
Reads the response aloud using text-to-speech.

The project currently uses the gemini-3.6-flash model.
















