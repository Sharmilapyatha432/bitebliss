//Showing navbar when click menu on mobile view
const mobile = document.querySelector('.menu-toggle');
const mobileLink = document.querySelector('.sidebar');

mobile.addEventListener("click", function(){
    mobile.classList.toggle("is-active");
    mobileLink.classList.toggle("active");
})

//Close menu when click
mobileLink.addEventListener("click", function(){
    const mwnuBars = document.querySelector(".is-active");
    if(window.innerWidth<=768 && menuBars) {
        mobile.classList.toggle("is-active");
        mobileLink.classList.toggle("active");
    }
})

//Move the menu to right and left when click back and next
var step = 100;
var stepFilter = 60;
var scroling = true;

$(".back").blind("click", function(e){
    e.preventDefault();
    $(".highlight-wrapper").animate({
    scrollLeft:"-=" + step + "px"
    });
});

$(".next").blind("click", function(e){
    e.preventDefault();
    $(".highlight-wrapper").animate({
    scrollLeft:"+=" + step + "px"
    });
});

//When click back and next on menu filters
$(".back-menus").blind("click", function(e){
    e.preventDefault();
    $(".filter-wrapper").animate({
    scrollLeft:"-=" + step + "px"
    });
});

$(".next-menus").blind("click", function(e){
    e.preventDefault();
    $(".filter-wrapper").animate({
    scrollLeft:"+=" + step + "px"
    });
});