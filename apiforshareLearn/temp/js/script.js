// function showDropdownMenu(dropToggler) {
//   toggler = document.getElementById(dropToggler.id);
//   menu = toggler.nextElementSibling;
//   menu.classList.add("show");
// }

// function hideDropdownMenu(dropToggler) {
//   toggler = document.getElementById(dropToggler.id);
//   menu = toggler.nextElementSibling;
//   if (menu.classList.contains("show")) {
//     menu.classList.remove("show");
//   }
// }

// function showDateInHTMLCalender()
// {
//     calender = document.getElementsByClassName('htmlCalender');
//     todayDate = Date.now();
//     console.log(todayDate);
// }

// Show-Hide Add posts forms tabs starts here

function showHideFormTabs(thisButton) {
  buyFormButton = document.getElementById("buy-form-button");
  sellFormButton = document.getElementById("sell-form-button");

  sellTitle = "Sell Your Book";
  buyTitle = "Buy A Book";

  sellForm = document.getElementById("addOnSaleForm");
  buyForm = document.getElementById("addBuyingForm");

  formTitle = document.getElementById("sell-buy-form-title");

  if (thisButton === buyFormButton) {
    if (thisButton.classList.contains("sell-buy-button-inactive")) {
      thisButton.classList.toggle("sell-buy-button-inactive");
      thisButton.classList.toggle("sell-buy-button-active");

      sellFormButton.classList.toggle("sell-buy-button-inactive");
      sellFormButton.classList.toggle("sell-buy-button-active");

      formTitle.innerText = buyTitle;

      if(buyForm.classList.contains('d-none'))
      {
        buyForm.classList.add("d-block");
        buyForm.classList.remove("d-none");
        sellForm.classList.remove("d-block");
        sellForm.classList.add("d-none");
      }
      
    }
  } else {
    if (thisButton.classList.contains("sell-buy-button-inactive")) {
      thisButton.classList.toggle("sell-buy-button-inactive");
      thisButton.classList.toggle("sell-buy-button-active");

      buyFormButton.classList.toggle("sell-buy-button-inactive");
      buyFormButton.classList.toggle("sell-buy-button-active");

      formTitle.innerText = sellTitle;

      if(sellForm.classList.contains('d-none'))
      {
        sellForm.classList.add("d-block");
        sellForm.classList.remove("d-none");
        buyForm.classList.remove("d-block");
        buyForm.classList.add("d-none");
      }
    }
  }
}

// Show-Hide Add posts forms tabs ends here

// LightSlider Section for add-post-pics Starts here

$(document).ready(function () {
  $("#sellBookPostPics").lightSlider({
    item: 3,
    autoWidth: true,
    slideMove: 1, // slidemove will be 1 if loop is true
    slideMargin: 10,

    addClass: "",
    mode: "slide",
    useCSS: true,
    cssEasing: "ease", //'cubic-bezier(0.25, 0, 0.25, 1)',//
    easing: "linear", //'for jquery animation',////

    speed: 400, //ms'
    auto: false,
    loop: true,
    slideEndAnimation: true,
    pause: 2000,

    keyPress: false,
    controls: true,
    prevHtml: "",
    nextHtml: "",

    rtl: false,
    adaptiveHeight: false,

    vertical: false,
    verticalHeight: 500,
    vThumbWidth: 100,

    thumbItem: 10,
    pager: true,
    gallery: false,
    galleryMargin: 5,
    thumbMargin: 5,
    currentPagerPosition: "middle",

    enableTouch: true,
    enableDrag: true,
    freeMove: true,
    swipeThreshold: 40,

    responsive: [],

    onBeforeStart: function (el) {},
    onSliderLoad: function (el) {
      $("#sellBookPostPics").removeClass("cs-hidden");
    },
    onBeforeSlide: function (el) {},
    onAfterSlide: function (el) {},
    onBeforeNextSlide: function (el) {},
    onBeforePrevSlide: function (el) {},
  });
});

// LightSlider Section for add-post-pics ends here



// Chatbox Starts here 

function hideChatBox()
{
  chatBox = document.getElementById('chat-box');
  chatBox.style.height = 0;
  showChatHead();
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
}

$(document).ready(function()
{
  hideChatBox();
  // showChatHead();
});

// Chatbox ends here
