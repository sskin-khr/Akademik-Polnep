document.addEventListener('DOMContentLoaded', () => {
    const menuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');

    const closeMobileMenu = () => {
        if (mobileMenu) {
            mobileMenu.classList.add('hidden');
        }
        if (menuBtn) {
            menuBtn.setAttribute('aria-expanded', 'false');
        }
    };

    const openMobileMenu = () => {
        if (mobileMenu) {
            mobileMenu.classList.remove('hidden');
        }
        if (menuBtn) {
            menuBtn.setAttribute('aria-expanded', 'true');
        }
    };

    if (menuBtn && mobileMenu) {
        menuBtn.addEventListener('click', (event) => {
            event.stopPropagation();
            const isHidden = mobileMenu.classList.contains('hidden');
            if (isHidden) {
                openMobileMenu();
            } else {
                closeMobileMenu();
            }
        });

        document.addEventListener('click', (event) => {
            if (mobileMenu && !mobileMenu.contains(event.target) && menuBtn && !menuBtn.contains(event.target)) {
                closeMobileMenu();
            }
        });

        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                closeMobileMenu();
            }
        });
    }

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
