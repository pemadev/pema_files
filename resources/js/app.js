import "./admin-bootstrap";
import Alpine from "alpinejs";
import Splide from "@splidejs/splide";
import "@splidejs/splide/css";

window.Alpine = Alpine;

document.addEventListener("alpine:init", () => {
    Alpine.data("carousel", (total = 3) => ({
        active: 0,
        total: total,
        slides: Array.from({ length: total }, (_, i) => i),
        interval: null,

        init() {
            this.start();
        },

        start() {
            this.interval = setInterval(() => {
                this.next();
            }, 5000);
        },

        stop() {
            if (this.interval) {
                clearInterval(this.interval);
                this.interval = null;
            }
        },

        next() {
            this.active = (this.active + 1) % this.total;
        },

        prev() {
            this.active = (this.active - 1 + this.total) % this.total;
        },
    }));
});

Alpine.start();

document.addEventListener("DOMContentLoaded", () => {
    const splideConfig = {
        type: "loop",
        perPage: 4,
        autoplay: true,
        interval: 3000,
        pauseOnHover: true,
        gap: "1rem",
        arrows: true,
        pagination: true,
        breakpoints: {
            1024: {
                perPage: 3,
            },
            768: {
                perPage: 2,
            },
            640: {
                perPage: 1,
            },
        },
    };

    const partnerSplide = document.querySelector("#partner-splide");
    if (partnerSplide) {
        new Splide("#partner-splide", splideConfig).mount();
    }

    const kerjasamaSplide = document.querySelector("#kerjasama-splide");
    if (kerjasamaSplide) {
        new Splide("#kerjasama-splide", splideConfig).mount();
    }
});
