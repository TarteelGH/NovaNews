document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchInput');

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            const keyword = this.value.toLowerCase();
            const cards = document.querySelectorAll('.card');

            let anyVisible = false;

            cards.forEach(card => {
                const text = card.innerText.toLowerCase();
                const matches = text.includes(keyword);
                card.style.display = matches ? 'block' : 'none';
                if (matches) anyVisible = true;
            });

            const noResults = document.getElementById('noResults');
            if (noResults) {
                noResults.style.display = anyVisible ? 'none' : 'block';
            }
        });
    }
});
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchInput');

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            const keyword = this.value.toLowerCase();
            const cards = document.querySelectorAll('.card');

            let anyVisible = false;

            cards.forEach(card => {
                const text = card.innerText.toLowerCase();
                const matches = text.includes(keyword);
                card.style.display = matches ? 'block' : 'none';
                if (matches) anyVisible = true;
            });

            const noResults = document.getElementById('noResults');
            if (noResults) {
                noResults.style.display = anyVisible ? 'none' : 'block';
            }
        });
    }
});
