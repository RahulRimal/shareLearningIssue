
const form = document.querySelector("#chat-form"),
inputField = form.querySelector("#chat-box-input"),
sendBtn = form.querySelector("button"),
chatMessageBox = document.querySelector("#chat-content-area");
const sender = document.getElementById('senderId').value;
const receiver = document.getElementById('receiverId').value;


$(document).ready(function()
{
  if(window.location.pathname === '/sabaikoBooks/post.php')
  {
    // showChatSystem();
    // showChatHead();
  }
  else
  {
    hideChatSystem();
  }

});


$(document).ready(function()
{
  hideChatSystem();
});


$(document).ready(function(){

  $('.hideChatBox').click(function(){
    hideChatBox()
    setTimeout(showChatHead(), 500);
  });

  $('.closeChatBox').click(function(){
    hideChatBox();
    hideChatHead();
    setTimeout(hideChatSystem(), 1000);
  });

  $('#openChatSystem').click(function(){
    showChatSystem();
  });

});


// Show/Hide Chatbox starts here

function showChatSystem()
{
  chatSystem = document.getElementById('chat-system');

  chatSystem.classList.remove('d-none');
  if(!chatSystem.classList.contains('d-block'))
  {
    chatSystem.classList.add('d-block');
  }

  showChatBox();

}

function hideChatSystem()
{

  hideChatBox();
  hideChatHead()

  chatSystem = document.getElementById('chat-system');

  chatSystem.classList.remove('d-block');
  chatSystem.classList.add('d-none');
}

function hideChatBox()
{
  chatBox = document.getElementById('chat-box');
  chatBox.style.height = 0;
}

function showChatBox()
{
  chatBox = document.getElementById('chat-box');
  chatBox.style.height = '400px';
  hideChatHead();
}

function hideChatHead()
{
  chatHead = document.getElementById('chat-head');
  chatHead.classList.remove('d-block');
  chatHead.classList.add('d-none');
}

function showChatHead()
{
  chatHead = document.getElementById('chat-head');
  chatHead.classList.remove('d-none');
  chatHead.classList.add('d-block');
  hideChatBox();
}

function closeChatBox(){

    hideChatBox();
    hideChatHead();

}

// Show/Hide Chatbox ends here



// Chat box starts here

// const form = document.querySelector("#chat-form"),
// inputField = form.querySelector("#chat-box-input"),
// sendBtn = form.querySelector("button"),
// chatMessageBox = document.querySelector("#chat-content-area");
// const sender = document.getElementById('senderId').value;
// const receiver = document.getElementById('receiverId').value;

form.onsubmit = (e)=>{
    e.preventDefault();
}

inputField.focus();
inputField.onkeyup = ()=>{
    if(inputField.value != ""){
        sendBtn.classList.add("active");
    }else{
        sendBtn.classList.remove("active");
    }
}

// Send message starts here

sendBtn.onclick = ()=>{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "chat.php", true);
    $.post('chat.php', {
        sender: sender,
        receiver: receiver,
        message: inputField.value
    } , function(data, status){
        inputField.value = '';
        console.log(data);
        chatMessageBox.innerHTML = data;
        scrollToBottom();
    });
    let formData = new FormData(form);
    xhr.send(formData);
}
chatMessageBox.onmouseenter = ()=>{
    chatMessageBox.classList.add("active");
}

chatMessageBox.onmouseleave = ()=>{
    chatMessageBox.classList.remove("active");
}


// Send message ends here


// Receive message starts here

setInterval(() =>{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "chat.php", true);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
            let data = xhr.response;
            chatMessageBox.innerHTML = data;
            if(!chatMessageBox.classList.contains("active")){
                scrollToBottom();
              }
          }
      }
      else
      {
        chatMessageBox.innerHTML = '<div style="margin-top: 25%;"><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div></div>';
      }
    }
    
    // xhr.onprogress = ()=>{
    //     chatMessageBox.innerHTML = '<div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>';
    //   }
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("sender_id="+sender+"&receiver_id="+receiver);
}, 3000);

function scrollToBottom(){
    chatMessageBox.scrollTop = chatMessageBox.scrollHeight;
  }

  
  // Receive message ends here


  // Chat box ends here
  