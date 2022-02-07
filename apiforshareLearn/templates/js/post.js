


// Post wishlist starts here

function addToWishlist(user, post, textArea) {

    var iconArea = textArea.parentElement.parentElement.getElementsByClassName('fa-shopping-basket');

    var alertArea = textArea.offsetParent.getElementsByClassName('post-alert-area')[0];

    const replacingElement = document.createElement('a');

    replacingElement.innerHTML = '<p class="remove-from-wishist text-center" style="color: var(--primary-color);" onclick="removeFromWishlist(' + user + ',' + post + ', this)">Remove from Wishlist</p>';


    $.post('wishlisted.php',
        {
            // postBeingWishlisted: true,
            wishlistingUser: user,
            wishlistingPost: post,
        }, function (data, status) {

            textArea.parentElement.parentElement.replaceChild(replacingElement, textArea.parentElement);

            iconArea[0].classList.add('fa-close');
            iconArea[0].classList.remove('fa-shopping-basket');
            $('#left-sidebar-wishlisted-count').text(data);
            $('#right-sidebar-wishlisted-count').text(data);


            $(alertArea).append('<div class="custom-alert alert-success temp-alert text-center" style="text-decoration: white; font-size: 15px; font-weight: 600; height: 25px; line-height: 25px;">Added to Wishlist</div>').slideDown(1000).delay(8000).slideUp(500, function () {
                $('.temp-alert').remove();
            });

        }
    );

}


function removeFromWishlist(user, post, textArea) {

    var iconArea = textArea.parentElement.parentElement.getElementsByClassName('fa-close');

    var alertArea = textArea.offsetParent.getElementsByClassName('post-alert-area')[0];


    const replacingElement = document.createElement('a');

    replacingElement.innerHTML = '<p class="user-add-wishlist text-center" style="color: var(--primary-color);" onclick="addToWishlist('+ user + ', ' + post + ', this)">Add to Wishlist</p>';



    $.post('wishlisted.php',
        {
            wishlistRemovingUser: user,
            wishlistRemovingPost: post,
        }, function (data, status) {

            textArea.parentElement.parentElement.replaceChild(replacingElement, textArea.parentElement);

            iconArea[0].classList.add('fa-shopping-basket');
            iconArea[0].classList.remove('fa-close');
            // textArea.innerHTML = 'Add to Wishlist';
            $('#left-sidebar-wishlisted-count').text(data);
            $('#right-sidebar-wishlisted-count').text(data);


            $(alertArea).append('<div class="custom-alert alert-success temp-alert text-center" style="text-decoration: white; font-size: 15px; font-weight: 600; height: 25px; line-height: 25px;">Removed from Wishlist</div>').slideDown(1000).delay(8000).slideUp(500, function () {
                $('.temp-alert').remove();
            });

        }
    );


}

// Post wishlist alert starts here


$(document).ready(function () {

    $('.login-to-wishlist').click(function () {

        var alertArea = event.target.offsetParent.getElementsByClassName('post-alert-area')[0];

        $(alertArea).append('<div class="custom-alert alert-danger temp-alert text-center" style="text-decoration: white; font-size: 15px; font-weight: 600; height: 25px; line-height: 25px;">Please Log in to wishlist this book</div>').slideDown(1000).delay(2000).slideUp(500, function () {
            $('.temp-alert').remove();
        });

    });


});

// Post wishlist alert ends here


// Post wishlist ends here



// Post reply alert starts here

// Send reply starts here

$(document).ready(function () {

    const commentForm = document.querySelector("#post-comment-form");

    // var commentBtn = document.querySelector("#comment-reply-button");

    // postId = commentForm.querySelector('#commentPostId');

    postId = $('#commentPostId');


    commentBody = commentForm.querySelector("#replyBody");
    commentBtn = commentForm.querySelector("#comment-reply-button");

    const commentArea = $('#comment-alert-area');


    commentForm.onsubmit = (e) => {
        e.preventDefault();
    }

    commentBtn.onclick = () => {
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "post.php", true);
        $.post('post.php', {
            commentPostId: postId.value,
            commentBody: commentBody.value,
        }, function (data, status) {

            $('.cke_editable').innerHTML = '';
            // document.getElementsByClassName('cke_editable').innerHTML = '';

            // commentBody.value = '';
            // commentArea.append(data);
            // $('#comment-alert-area').append('<div class="custom-alert alert-danger temp-alert text-center" style="text-decoration: white; font-size: 15px; font-weight: 600; height: 25px; line-height: 25px;">Please Log in to wishlist this book</div>').slideDown(1000).delay(2000).slideUp(500, function() {
            //     $('.temp-alert').remove();
            // });

        });

        let formData = new FormData(commentForm);
        xhr.send(formData);

    }


    // Send reply ends here


    // Receive reply starts here

    // setInterval(() =>{
    //     let xhr = new XMLHttpRequest();
    //     xhr.open("POST", "chat.php", true);
    //     xhr.onload = ()=>{
    //       if(xhr.readyState === XMLHttpRequest.DONE){
    //           if(xhr.status === 200){
    //             let data = xhr.response;
    //             chatMessageBox.innerHTML = data;
    //             if(!chatMessageBox.classList.contains("active")){
    //                 scrollToBottom();
    //               }
    //           }
    //       }
    //     }
    //     xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    //     xhr.send("sender_id="+sender+"&receiver_id="+receiver);
    // }, 1500);

    // function scrollToBottom(){
    //     chatMessageBox.scrollTop = chatMessageBox.scrollHeight;
    //   }

});

  // Receive reply ends here

// Post reply alert ends here