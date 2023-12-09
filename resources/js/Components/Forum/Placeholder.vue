<script setup></script>


<template>
    <div class="placeholder-card-container">
      <div>
        <div class="placeholder-img"></div>
      </div>
      <div class="right">
        <div class="placeholder-text"></div>
        <div class="placeholder-body"></div>
        </div>
      </div>
</template>

<style scoped>
    body {
      background-color: #aaa;
      display: grid;
      height: 100vh;
      place-items: center;
    }

    .placeholder-card-container {
        width: 100%;
      display: flex;
      justify-content: center;
      align-items: top;
      gap: 1em;
      background-color: white;
      height: 10rem;
      border-radius: 12px;
      padding: 2.1em 1em;
    }
    .placeholder-img {
      width: 50px;
      height: 50px;
      background-color: #ccc;
      border-radius: 50%;
      animation: pulse .60s infinite alternate;
    }
    .placeholder-card-container .right {
      flex: 1;
    }
    .placeholder-text {
      width: 100%;
      height: 20px;
      background-color: #ccc;
      border-radius: 4rem;
      animation: pulse .60s infinite alternate;
    }
    .placeholder-body {
      width: 100%;
      height: 90%;
      background-color: #ccc;
      border-radius: 4px;
      margin-top: 12px;
      animation: pulse .70s infinite alternate;
    }

    @keyframes pulse {
      0% {
        opacity: 1;
      }
      100% {
        opacity: .5;
      }
    }

</style>

