<template>
    <div class="chatbot">
      <div class="conversation">
        <DataView
          v-model="chatMessages"
          layout="list"
          :item-template="messageTemplate"
        />
      </div>
      <div class="input">
        <InputText
          v-model="userInput"
          @keydown.enter="sendMessage"
          placeholder="Escribe un mensaje..."
        />
      </div>
    </div>
  </template>

  <script>
  export default {
    data() {
      return {
        chatMessages: [],
        userInput: "",
      };
    },
    methods: {
      sendMessage() {
        const userMessage = this.userInput;
        this.chatMessages.push({ text: userMessage, type: "user" });

        // Lógica para enviar el mensaje al chatbot y obtener la respuesta
        // Puedes utilizar una librería externa aquí o implementar tu propia lógica.
        // Por ejemplo:
        // const botResponse = myChatbotLibrary.getResponse(userMessage);

        // this.chatMessages.push({ text: botResponse, type: "bot" });

        // Limpia el campo de entrada
        this.userInput = "";
      },
      messageTemplate(message) {
        return `<div class="${message.type}">${message.text}</div>`;
      },
    },
  };
  </script>

  <style scoped>
  /* Estilos del chatbot */
  .chatbot {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background-color: #fff;
    border: 1px solid #ccc;
    width: 300px;
    height: 400px;
  }
  .conversation {
    height: 80%;
    overflow-y: scroll;
  }
  .input {
    margin-top: 10px;
  }
  .user {
    text-align: right;
    background-color: #e5e5ea;
    padding: 5px;
  }
  .bot {
    text-align: left;
    background-color: #f0f0f5;
    padding: 5px;
  }
  </style>
