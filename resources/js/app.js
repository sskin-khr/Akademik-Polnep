document.addEventListener('DOMContentLoaded', () => {
    // 1. Mobile Menu Toggle
    const menuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    if (menuBtn && mobileMenu) {
        menuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    }

    // 2. FAQ Accordion Toggle
    const faqItems = document.querySelectorAll('.faq-item');
    faqItems.forEach(item => {
        const toggleBtn = item.querySelector('.faq-toggle');
        const content = item.querySelector('.faq-content');
        const icon = item.querySelector('.faq-icon');

        if (toggleBtn && content) {
            toggleBtn.addEventListener('click', () => {
                const isOpen = !content.classList.contains('hidden');
                
                // Close all other FAQs
                document.querySelectorAll('.faq-content').forEach(c => c.classList.add('hidden'));
                document.querySelectorAll('.faq-icon').forEach(i => i.classList.remove('rotate-180'));

                if (!isOpen) {
                    content.classList.remove('hidden');
                    if (icon) icon.classList.add('rotate-180');
                }
            });
        }
    });

    // 3. Program Studi Search Filter
    const searchInput = document.getElementById('prodi-search');
    const prodiCards = document.querySelectorAll('.prodi-card');

    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            const query = e.target.value.toLowerCase().trim();
            prodiCards.forEach(card => {
                const text = card.textContent.toLowerCase();
                card.style.display = text.includes(query) ? 'flex' : 'none';
            });
        });
    }

    // 4. Program Studi Tab Filter
    const filterTabs = document.querySelectorAll('.prodi-tab');
    filterTabs.forEach(tab => {
        tab.addEventListener('click', () => {
            filterTabs.forEach(t => {
                t.classList.remove('bg-sky-600', 'text-white');
                t.classList.add('bg-white', 'text-slate-700');
            });
            tab.classList.remove('bg-white', 'text-slate-700');
            tab.classList.add('bg-sky-600', 'text-white');

            const category = tab.getAttribute('data-category');
            prodiCards.forEach(card => {
                if (category === 'all' || card.getAttribute('data-jenjang') === category) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
});
