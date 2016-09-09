$('.fullScreen').on('click',function(){
  var elem = document.getElementById("mybody");
  if (!document.fullscreenElement &&    // alternative standard method
         !document.mozFullScreenElement && !document.webkitFullscreenElement) {  // current working methods
       if (document.documentElement.requestFullscreen) {
         document.documentElement.requestFullscreen();
       } else if (document.documentElement.mozRequestFullScreen) {
         document.documentElement.mozRequestFullScreen();
       } else if (document.documentElement.webkitRequestFullscreen) {
         document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
       }
   } else {
     if (document.cancelFullScreen) {
       document.cancelFullScreen();
     } else if (document.mozCancelFullScreen) {
       document.mozCancelFullScreen();
     } else if (document.webkitCancelFullScreen) {
       document.webkitCancelFullScreen();
     }
  }
});
