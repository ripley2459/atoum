/* ==================================================
 * Gallery
 */

let gallery = null;
let slide = 0;
let autoSlider;
let timer = 5000;

document.addEventListener("KeyUp", () => changeSpeed(1000));
document.addEventListener("KeyDown", () => changeSpeed(-1000));
document.addEventListener("KeyEscape", () => {
    if (gallery)
        closeGallery();
});
document.addEventListener("KeyLeft", () => {
    if (gallery)
        changeSlide(-1, gallery);
});
document.addEventListener("KeyRight", () => {
    if (gallery)
        changeSlide(1, gallery);
});

const closeGallery = () => {
    close();
    gallery = null;
    clearTimeout(autoSlider);
}

const showSlide = (n, id) => {
    open(id + "-modal");
    gallery = id;
    clearTimeout(autoSlider);
    setSlide(slide = n);
}

const changeSlide = (n) => {
    clearTimeout(autoSlider);
    setSlide(slide += n);
}

const changeSpeed = (a) => {
    timer += a;
    if (timer < 0)
        timer = 500;
}

const setSlide = (n) => {
    let i;
    const slides = document.getElementById(gallery + "-slides").getElementsByTagName("img");
    const thumbnails = document.getElementById(gallery + "-thumbnails").getElementsByTagName("img");
    const controls = document.getElementById(gallery + "-controls");

    autoSlider = setTimeout(changeSlide, timer, 1, gallery);

    if (n > slides.length)
        slide = 1;
    if (n < 1)
        slide = slides.length

    for (i = 0; i < slides.length; i++)
        slides[i].style.display = "none";

    controls.innerHTML = slide + '/' + slides.length + " | " + timer + "ms";
    slides[slide - 1].style.display = "block";

    for (i = 0; i < slides.length; i++)
        thumbnails[i].classList.remove("active");

    function clamp(x) {
        if (x < 0)
            x = 0;
        else if (x > slides.length)
            x = slides.length;
        return x;
    }

    thumbnails[clamp(slide - 3)].classList.add("active");
    thumbnails[clamp(slide - 2)].classList.add("active");
    thumbnails[clamp(slide - 1)].classList.add("active");
    thumbnails[clamp(slide + 0)].classList.add("active");
    thumbnails[clamp(slide + 1)].classList.add("active");
}
