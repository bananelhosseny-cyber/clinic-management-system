const filterButtons = document.querySelectorAll(".filter-buttons button");
const cards = document.querySelectorAll(".card");

filterButtons.forEach(button => {
    button.addEventListener("click", () => {
        // Active button style
        filterButtons.forEach(btn => btn.classList.remove("active"));
        button.classList.add("active");
        const filterValue = button.getAttribute("data-filter");
        cards.forEach(card => {
            if (filterValue === "all" || 
                card.getAttribute("data-category") === filterValue) {
                card.style.display = "block";
                setTimeout(() => {
                    card.style.opacity = "1";
                    card.style.transform = "scale(1)";
                }, 100);
            } else {
                card.style.opacity = "0";
                card.style.transform = "scale(0.9)";
                setTimeout(() => {
                    card.style.display = "none";
                }, 300);
            }
        });
    });
});