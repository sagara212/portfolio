document.addEventListener('DOMContentLoaded', function () {
    const sections = document.querySelectorAll('section');
    const navLinks = document.querySelectorAll('.nav-link');

    const options = {
        threshold: 0.7
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                navLinks.forEach(link => {
                    link.classList.remove('active');
                    if (link.getAttribute('href').substring(1) === entry.target.id) {
                        link.classList.add('active');
                    }
                });
            }
        });
    }, options);

    sections.forEach(section => {
        observer.observe(section);
    });

    // Image transition effect
    const images = document.querySelectorAll('.profileimage, .aboutimg, .cimg');
    
    function revealImages() {
        const windowHeight = window.innerHeight;
        images.forEach(image => {
            const imageTop = image.getBoundingClientRect().top;
            const imageBottom = image.getBoundingClientRect().bottom;
            if (imageTop < windowHeight && imageBottom > 0) {
                image.classList.add('show');
            } else {
                image.classList.remove('show');
            }
        });
    }

    // Dark/light mode toggle
    const body = document.body;
    const modeIcon = document.getElementById("mode-icon");
    const contactSection = document.getElementById("contact");

    function updateMode() {
        if (body.classList.contains("dark-mode")) {
            body.classList.remove("dark-mode");
            body.classList.add("light-mode");
            contactSection.classList.remove("dark-mode");
            contactSection.classList.add("light-mode");
            modeIcon.textContent = "☀️";
        } else {
            body.classList.remove("light-mode");
            body.classList.add("dark-mode");
            contactSection.classList.remove("light-mode");
            contactSection.classList.add("dark-mode");
            modeIcon.textContent = "🌙";
        }
    }

    modeIcon.addEventListener("click", updateMode);

    // Initialize mode
    updateMode();

    navLinks.forEach((link) => {
        link.addEventListener("click", function() {
            navLinks.forEach((l) => l.classList.remove("active"));
            this.classList.add("active");
        });
    });

    document.getElementById("contactForm").addEventListener("submit", function(event) {
        event.preventDefault();

        var formData = new FormData(this);

        fetch("send_email.php", {
            method: "POST",
            body: formData,
            headers: {
                "Accept": "application/json"
            }
        })
        .then((response) => {
            if (response.ok) {
                return response.json();
            } else {
                throw new Error("Failed to fetch");
            }
        })
        .then((responseJson) => {
            alert(responseJson.message);
        })
        .catch((error) => {
            alert("Error: " + error.message);
        });
    });

    // Scroll transition effect
    window.addEventListener('scroll', revealImages);
    revealImages(); // Initial check in case images are already in view
});
