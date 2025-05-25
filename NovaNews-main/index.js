document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchInput');

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            const keyword = this.value.toLowerCase();
            const sections = document.querySelectorAll('.container.my-5');

            let anyVisible = false;

            sections.forEach(section => {
                const cards = section.querySelectorAll('.card');
                let sectionHasMatches = false;

                cards.forEach(card => {
                    const text = card.innerText.toLowerCase();
                    const matches = text.includes(keyword);
                    card.style.display = matches ? 'block' : 'none';
                    if (matches) sectionHasMatches = true;
                });

                section.style.display = sectionHasMatches ? 'block' : 'none';
                if (sectionHasMatches) anyVisible = true;
            });

            const noResults = document.getElementById('noResults');
            if (noResults) {
                noResults.style.display = anyVisible ? 'none' : 'block';
            }
        });
    }
});

function likeArticle(button, articleId) {
    button.classList.toggle("btn-danger");
    button.classList.toggle("btn-outline-danger");
    const icon = button.querySelector("i");
    icon.classList.toggle("bi-heart");
    icon.classList.toggle("bi-heart-fill");

    fetch('update_likes.php?id=' + articleId, { method: 'POST' })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Like updated successfully');
            } else {
                console.error('Failed to update like');
            }
        })
        .catch(error => console.error('Error:', error));
}