<form id="contactForm" class="form" autocomplete="off">
  <div class="control">
    <h1>Contact administrator</h1>
  </div>

  <div class="control block-cube block-input">
    <input name="title" id="title" type="text" placeholder="Message title" required />
    <div class="bg-top"><div class="bg-inner"></div></div>
    <div class="bg-right"><div class="bg-inner"></div></div>
    <div class="bg"><div class="bg-inner"></div></div>
  </div>

  <div class="control block-cube block-input">
    <textarea name="message" id="message" placeholder="Your message" required></textarea>
    <div class="bg-top"><div class="bg-inner"></div></div>
    <div class="bg-right"><div class="bg-inner"></div></div>
    <div class="bg"><div class="bg-inner"></div></div>
  </div>

  <br>

  <button type="button" id="sendBtn" class="btn block-cube block-cube-hover">
    <div class="bg-top"><div class="bg-inner"></div></div>
    <div class="bg-right"><div class="bg-inner"></div></div>
    <div class="bg"><div class="bg-inner"></div></div>
    <div class="text">Send</div>
  </button>

  <div id="response" class="mt-2"></div>
</form>








































<style>
    textarea {
    resize: none;
    width: 100%;
    height: 120px;
    background: transparent;
    border: none;
    color: white;
    font-size: 16px;
    padding: 10px;
    outline: none;
    font-family: inherit;
    }

.block-input textarea {
  box-sizing: border-box;
}

body {
  background: #1a1a1a;
  color: white;
  font-family: monospace;
}

h1 {
  text-align: center;
  margin-bottom: 20px;
}


.block-cube {
  position: relative;
  margin: 20px auto;
  max-width: 500px;
}

.block-input input,
.block-input textarea {
  width: 100%;
  background: transparent;
  border: none;
  font-size: 18px;
  padding: 15px;
  z-index: 2;
  position: relative;
  color: white;
}





</style>
