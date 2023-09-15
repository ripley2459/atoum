let gallery = null;
let slide = 0;
let autoSlider;
let timer = 4000;

document.addEventListener("KeyUp", () => changeSpeed(500));
document.addEventListener("KeyDown", () => changeSpeed(-500));
document.addEventListener("KeyEscape", () => {
    if (gallery) closeGallery();
});
document.addEventListener("KeyLeft", () => {
    if (gallery) changeSlide(-1, gallery);
});
document.addEventListener("KeyRight", () => {
    if (gallery) changeSlide(1, gallery);
});

function closeGallery() {
    close();
    gallery = null;
    clearTimeout(autoSlider);
}

function showSlide(n, id) {
    open(id + "-modal");
    gallery = id;
    clearTimeout(autoSlider);
    setSlide(slide = n);
}

function changeSlide(n) {
    clearTimeout(autoSlider);
    setSlide(slide += n);
}

function changeSpeed(a) {
    timer += a;
    if (timer < 0) timer = 500;
}

function setSlide(n) {
    let i;
    const slides = document.getElementById(gallery + "-slideshow").getElementsByClassName("slide");
    const thumbnails = document.getElementById(gallery + "-thumbnails").getElementsByClassName("thumbnail");
    const feedbacks = document.getElementById(gallery + "-feedbacks");

    autoSlider = setTimeout(changeSlide, timer, 1, gallery);

    if (n > slides.length) slide = 1;
    if (n < 1) slide = slides.length

    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }

    feedbacks.innerHTML = slide + '/' + slides.length + " | " + timer + "ms";
    slides[slide - 1].style.display = "block";

    for (i = 0; i < slides.length; i++) {
        thumbnails[i].classList.remove("active");
    }

    function clamp(x) {
        if (x < 0) x = 0;
        else if (x > slides.length) x = slides.length;
        return x;
    }

    thumbnails[clamp(slide - 3)].classList.add("active");
    thumbnails[clamp(slide - 2)].classList.add("active");
    thumbnails[clamp(slide - 1)].classList.add("active");
    thumbnails[clamp(slide + 0)].classList.add("active");
    thumbnails[clamp(slide + 1)].classList.add("active");
}
