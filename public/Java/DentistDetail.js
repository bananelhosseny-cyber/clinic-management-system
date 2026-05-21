const tabs = document.querySelectorAll(".tab");
const contents = document.querySelectorAll(".tab-content");

tabs.forEach(tab => {
    tab.addEventListener("click", () => {
        tabs.forEach(t => t.classList.remove("active"));
        contents.forEach(c => c.classList.remove("active"));
        tab.classList.add("active");
        document.getElementById(tab.dataset.tab).classList.add("active");
    });
});

let selectedRating = 0;
let reviews = JSON.parse(localStorage.getItem("doctorReviews")) || [];

const stars = document.querySelectorAll(".star-select i");
const averageBox = document.getElementById("averageRating");
const reviewsList = document.getElementById("reviewsList");

stars.forEach(star => {
    star.addEventListener("click", () => {
        selectedRating = Number(star.dataset.rate);
        stars.forEach(s => s.classList.remove("active"));
        for(let i = 0; i < selectedRating; i++){
            stars[i].classList.add("active");
        }
    });
});

document.getElementById("submitReview").addEventListener("click", () => {

    const name = document.getElementById("reviewName").value.trim();
    const comment = document.getElementById("reviewComment").value.trim();

    if(!name || !comment || selectedRating === 0){
        alert("Please fill all fields and select rating");
        return;
    }

    reviews.push({
        name,
        comment,
        rating: selectedRating
    });

    localStorage.setItem("doctorReviews", JSON.stringify(reviews));

    document.getElementById("reviewName").value = "";
    document.getElementById("reviewComment").value = "";
    selectedRating = 0;
    stars.forEach(s => s.classList.remove("active"));

    displayReviews();
});

function displayReviews(){

    reviewsList.innerHTML = "";

    if(reviews.length === 0){
        document.getElementById("averageNumber").innerText = "0.0";
        document.getElementById("averageStars").innerHTML = "";
        document.getElementById("totalReviews").innerText = "0 Reviews";
        document.getElementById("ratingBreakdown").innerHTML = "";
        return;
    }

    const total = reviews.reduce((sum,r) => sum + r.rating, 0);
    const avg = (total / reviews.length).toFixed(1);

    document.getElementById("averageNumber").innerText = avg;
    document.getElementById("totalReviews").innerText = `${reviews.length} Reviews`;

    document.getElementById("averageStars").innerHTML =
        "★".repeat(Math.round(avg)) +
        "☆".repeat(5 - Math.round(avg));

    const breakdown = [5,4,3,2,1].map(star => {
        const count = reviews.filter(r => r.rating === star).length;
        const percent = ((count / reviews.length) * 100).toFixed(0);

        return `
        <div class="rating-row">
            <span>${star} ★</span>
            <div class="progress">
                <div class="progress-bar" style="width:${percent}%"></div>
            </div>
            <span>${count}</span>
        </div>`;
    }).join("");

    document.getElementById("ratingBreakdown").innerHTML = breakdown;

    reviews.forEach(r => {

        const initials = r.name.charAt(0).toUpperCase();
        const date = new Date().toLocaleDateString();

        reviewsList.innerHTML += `
        <div class="review-card">
            <div class="review-avatar">${initials}</div>
            <div class="review-content">
                <h5>${r.name}</h5>
                <div class="review-stars">
                    ${"★".repeat(r.rating)}
                    ${"☆".repeat(5 - r.rating)}
                </div>
                <p>${r.comment}</p>
                <div class="review-date">${date}</div>
            </div>
        </div>`;
    });
}
displayReviews();