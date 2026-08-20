# Voice Assistant

An Arabic voice assistant built with JavaScript, PHP, Web Speech API, and Gemini API.

## Live Demo

[Open the Voice Assistant](https://tala.free.je/c/)

## Project Overview

This project is a web-based Arabic voice assistant that allows the user to communicate using voice input. The browser converts Arabic speech into text using the Web Speech API, then JavaScript sends the text to a PHP backend. The PHP backend communicates with the Gemini API and returns the generated response to the frontend.

The assistant displays the conversation in a chat interface and can read the generated response aloud using text-to-speech.

## Features

- Arabic speech-to-text using the Web Speech API.
- Microphone button for voice input.
- Sends recognized speech to the PHP backend.
- Gemini API integration for generating responses.
- Displays user and assistant messages in a chat interface.
- Text-to-speech for assistant responses.
- PHP error handling for invalid requests and API failures.
- API key handled on the server side.

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
```

## How It Works

1. The user opens the website.
2. The user presses the microphone button.
3. The browser requests microphone access.
4. The Web Speech API recognizes the Arabic speech and converts it to text.
5. JavaScript sends the text to `api/assistant.php` using a POST request.
6. The PHP backend receives the prompt.
7. PHP sends the prompt to the Gemini API.
8. Gemini generates a response.
9. PHP returns the response as JSON.
10. JavaScript displays the response in the chat.
11. The browser reads the response using text-to-speech.

## Problem Solved

During the development of the project, the voice assistant was unable to receive a response from the Gemini API.

The problem was investigated by adding error handling to the PHP backend so that the API response and HTTP status could be identified instead of displaying only a generic error message.

The error response showed that the Gemini model originally used by the project:

`gemini-2.5-flash`

was no longer available for new users. The API response recommended updating the code to use a newer model.

The PHP backend was therefore updated to use:

`gemini-3.6-flash`

After updating the model name, the request was successfully processed and the assistant was able to receive and display responses from Gemini.

## Error Handling

The PHP backend includes checks for:

- Invalid HTTP request methods
- Empty prompts
- Missing Gemini API keys
- cURL connection failures
- HTTP errors returned by Gemini
- Unexpected Gemini API responses

These error-handling checks were also used to identify the Gemini model availability issue during development.

## Backend

The main backend endpoint is:

`api/assistant.php`

It receives the user's prompt through a POST request and sends it to the Gemini API.

The Gemini API key is handled on the server side rather than being exposed in the frontend JavaScript.

## Deployment

The project was deployed using InfinityFree.

The live version is available here:

[Open the Voice Assistant](https://tala.free.je/c/)

## Security

The Gemini API key should not be placed directly inside `app.js` or any other frontend file.

The actual `config.php` containing the API key should remain on the server and should not be committed to a public GitHub repository.

## Result

The main issue in the project was identified as a Gemini API model availability error rather than a problem with the microphone or speech recognition functionality.

Updating the Gemini model used by the PHP backend resolved the API error and restored the communication between the voice assistant and Gemini.

The project now uses the `gemini-3.6-flash` model.
