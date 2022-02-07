// Follow / Unfollow User Starts Here


$(document).ready(function () {
  const searchList = new URLSearchParams(window.location.search);
  const postId = searchList.get("post");

  followIcon = document.getElementsByClassName('follow-user-icon');
  unfollowIcon = document.getElementsByClassName('unfollow-user-icon');

  // $('.follow-user-btn').click(function(){

  //   const content = $('.follow-user-btn').text();
  //   const userName = content.split(' ')[1];

  //   follower = document.getElementById('followerId');
  //   beingFollowed = document.getElementById('followedId');

  //   $.post('post.php?post=' + postId,
  //   {
  //     followerId: follower.value,
  //     followedId: beingFollowed.value
  //   }, function(data, status){
  //     $('.user-followers-count-text').text(data);
  //     $('.follow-user-btn').text('Unfollow' + ' ' + userName);
  //     $('.follow-user-icon').removeClass('fa-user-plus').addClass('fa-user-times');
  //     $('.follow-user-icon').addClass('unfollow-user-icon').removeClass('follow-user-icon');
  //     $('#follow-user-btn').removeClass('follow-user-btn').addClass('unfollow-user-btn');
  //     $('#follow-user-btn').attr("id", "unfollow-user-btn");
  //     // if(status === 'success'){
  //       // <div class="alert alert-success text-center">Your're now following this user</div>;
  //     // }
  //     // else
  //     // {
  //       // <div class="alert alert-danger text-center">Something went wrong</div>;
  //     // }
  //   });

  // });

  // $("#follow-user-btn").click(function () {

  //   const content = $(".follow-user-btn").text();
  //   const userName = content.split(" ")[1];

  //   follower = document.getElementById("followerId");
  //   beingFollowed = document.getElementById("followedId");

  //   const replacingElement = document.createElement("div");

  //   replacingElement.innerHTML = '<div class="follow-user d-flex flex-column align-items-center sidebar-item-red text-center"><input id="followerId" type="text" value="' + follower.value+ '" hidden><input id="followedId" type="text" value="'+ beingFollowed.value + '" hidden><i class="follow-user-icon fa fa-user-plus" aria-hidden="true"></i><a><p id="follow-user-btn" class="follow-user-btn">Follow ' + userName + '</p></a></div>';


  //   $.post(
  //     "post.php?post=" + postId,
  //     {
  //       followerId: follower.value,
  //       followedId: beingFollowed.value,
  //     },
  //     function (data, status) {
  //       $(".user-followers-count-text").text(data);
  //       // $('.follow-user-btn').text('Unfollow' + ' ' + userName);
  //       // $(".follow-user-icon").removeClass("fa-user-plus").addClass("fa-user-times");
  //       // $(".follow-user-icon").addClass("unfollow-user-icon").removeClass("follow-user-icon");

  //       // document.getElementsByClassName('unfollow-user-icon')[0].parentElement.parentElement.replaceChild(replacingElement, document.getElementsByClassName('unfollow-user-icon')[0].parentElement);

  //       followIcon[0].parentElement.parentElement.replaceChild(replacingElement, followIcon[0].parentElement);

  //     }
  //   );
  // });

  // $(".unfollow-user-btn").click(function () {
  //   const content = $(".unfollow-user-btn").text();
  //   const userName = content.split(" ")[1];

  //   $unfollower = document.getElementById("unfollowerId");
  //   $beingUnFollowed = document.getElementById("unfollowedId");

  //   $.post(
  //     "post.php?post=" + postId,
  //     {
  //       unfollowerId: $unfollower.value,
  //       unfollowedId: $beingUnFollowed.value,
  //     },
  //     function (data, status) {
  //       $(".user-followers-count-text").text(data);
  //       $(".unfollow-user-btn").text("Follow" + " " + userName);
  //       $(".unfollow-user-icon")
  //         .removeClass("fa-user-times")
  //         .addClass("fa-user-plus");
  //       $("#unfollow-user-btn")
  //         .removeClass("unfollow-user-btn")
  //         .addClass("follow-user-btn");
  //       // if(status === 'success'){
  //       // <div class="alert alert-success text-center">Your're now following this user</div>;
  //       // }
  //       // else
  //       // {
  //       // <div class="alert alert-danger text-center">Something went wrong</div>;
  //       // }
  //     }
  //   );
  // });

  // $("#unfollow-user-btn").click(function () {
  //   const content = $(".unfollow-user-btn").text();
  //   const userName = content.split(" ")[1];

  //   unfollower = document.getElementById("unfollowerId");
  //   beingUnFollowed = document.getElementById("unfollowedId");

  //   const replacingElement = document.createElement("div");

  //   // replacingElement.innerHTML = '<div class="follow-user d-flex flex-column align-items-center sidebar-item-red text-center"><input id="followerId" type="text" value="' + follower.value+ '" hidden><input id="followedId" type="text" value="'+ beingFollowed.value + '" hidden><i class="follow-user-icon fa fa-user-plus" aria-hidden="true"></i><a><p id="follow-user-btn" class="follow-user-btn">Follow ' + userName + ' ?></p></a></div>';

  //   replacingElement.innerHTML = '<div class="follow-user d-flex flex-column align-items-center sidebar-item-red text-center"><input id="followerId" type="text" value="' + unfollower.value+ '" hidden><input id="followedId" type="text" value="' + beingUnFollowed.value+ '" hidden><i class="follow-user-icon fa fa-user-plus" aria-hidden="true"></i><a><p id="follow-user-btn" class="follow-user-btn">Follow ' + userName + '</p></a></div>';

  //   $.post(
  //     "post.php?post=" + postId,
  //     {
  //       unfollowerId: unfollower.value,
  //       unfollowedId: beingUnFollowed.value,
  //     },
  //     function (data, status) {
  //       $(".user-followers-count-text").text(data);
  //       // $(".unfollow-user-btn").text("Follow" + " " + userName);
  //       // $(".unfollow-user-icon").removeClass("fa-user-times").addClass("fa-user-plus");
  //       // $("#unfollow-user-btn").removeClass("unfollow-user-btn").addClass("follow-user-btn");

  //       unfollowIcon[0].parentElement.parentElement.replaceChild(replacingElement, unfollowIcon[0].parentElement);

  //     }
  //   );
  // });


});


function addFollower(follower, beingFollowed, textArea) {

  const searchList = new URLSearchParams(window.location.search);
  const postId = searchList.get("post");

  const content = $('.follow-user-btn').text();
  const userName = content.split(' ')[1];

  var iconArea = textArea.parentElement.parentElement.getElementsByClassName('fa-user-plus');

  // var alertArea = textArea.offsetParent.getElementsByClassName('post-alert-area')[0];

  const replacingElement = document.createElement("div");

    replacingElement.innerHTML = '<div class="unfollow-user d-flex flex-column align-items-center sidebar-item-red text-center"><input id="unfollowerId" type="text" value="' + follower.value+ '" hidden><input id="unfollowedId" type="text" value="'+ beingFollowed.value + '" hidden><i class="unfollow-user-icon fa fa-user-times" aria-hidden="true"></i><a><p id="unfollow-user-btn" class="unfollow-user-btn" onclick="removeFollower('+follower+', '+beingFollowed+', this)">Unfollow ' + userName + '</p></a></div>';

  // replacingElement.innerHTML = '<p id="unfollow-user-btn" class="unfollow-user-btn" onclick="removeFollower('+follower+', '+beingFollowed+', this)">UnFollow ' + userName + '</p>';


  $.post(
        // "post.php?post=" + postId,
        "user.php",
      {
        followerId: follower.value,
        followedId: beingFollowed.value,
      }, function (data, status) {

          // $(".user-followers-count-text").text(data);
          console.log(data);
          // textArea.parentElement.parentElement.replaceChild(replacingElement, textArea.parentElement);

          textArea.parentElement.parentElement.parentElement.replaceChild(replacingElement, textArea.parentElement.parentElement);

          // iconArea[0].classList.add('fa-user-times');
          // iconArea[0].classList.remove('fa-user-plus');

          console.log('followed user');
          // $('#left-sidebar-wishlisted-count').text(data);
          // $('#right-sidebar-wishlisted-count').text(data);


          // $(alertArea).append('<div class="custom-alert alert-success temp-alert text-center" style="text-decoration: white; font-size: 15px; font-weight: 600; height: 25px; line-height: 25px;">Added to Wishlist</div>').slideDown(1000).delay(8000).slideUp(500, function () {
          //     $('.temp-alert').remove();
          // });

      }
  );

}



function removeFollower(unfollower, beingUnfollowed, textArea) {

  const searchList = new URLSearchParams(window.location.search);
  const postId = searchList.get("post");

  const content = $('.follow-user-btn').text();
  const userName = content.split(' ')[1];

  var iconArea = textArea.parentElement.parentElement.getElementsByClassName('fa-user-plus');

  // var alertArea = textArea.offsetParent.getElementsByClassName('post-alert-area')[0];

  const replacingElement = document.createElement('a');

  // replacingElement.innerHTML = '<p class="remove-from-wishist text-center" style="color: var(--primary-color);" onclick="removeFromWishlist(' + user + ',' + post + ', this)">Remove from Wishlist</p>';

  replacingElement.innerHTML = '<p id="follow-user-btn" class="follow-user-btn" onclick="addFollower('+unfollower+', '+beingUnfollowed+', this)">Follow ' + userName + '</p>';


  $.post(
    // "post.php?post=" + postId,
    "user.php",
      {
          unfollowerId: unfollower,
          unfollowedId: beingUnfollowed,
      }, function (data, status) {

          textArea.parentElement.parentElement.replaceChild(replacingElement, textArea.parentElement);

          console.log(data);

          iconArea[0].classList.add('fa-user-plus');
          iconArea[0].classList.remove('fa-user-times');
          // $('#left-sidebar-wishlisted-count').text(data);
          // $('#right-sidebar-wishlisted-count').text(data);


          // $(alertArea).append('<div class="custom-alert alert-success temp-alert text-center" style="text-decoration: white; font-size: 15px; font-weight: 600; height: 25px; line-height: 25px;">Added to Wishlist</div>').slideDown(1000).delay(8000).slideUp(500, function () {
          //     $('.temp-alert').remove();
          // });

      }
  );

}






// Follow / Unfollow User Ends Here
