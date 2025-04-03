const backToTopButton = document.getElementById("toTop");

// Show the button when scrolled down a specific distance
window.onscroll = function () {
  if (document.documentElement.scrollTop > 200) {
    // Adjust the distance as needed
    backToTopButton.style.display = "block";
  } else {
    backToTopButton.style.display = "none";
  }
};
backToTopButton.addEventListener("click", function () {
  window.scrollTo({
    top: 0,
    behavior: "smooth",
  }); // Smooth scroll to the top
});

$(window).on('scroll', function() {
    if ($(window).scrollTop() > 200) {
        $('.navbar').addClass('navbar-scrolled');
    } else {
        $('.navbar').removeClass('navbar-scrolled');
    }
});