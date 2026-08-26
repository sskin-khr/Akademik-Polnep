

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

const setupNavigation = () => {
	const mobileMenuButton = document.querySelector('#mobile-menu-btn');
	const mobileMenu = document.querySelector('#mobile-menu');
	const profileButton = document.querySelector('#profile-dropdown-toggle');
	const profileMenu = document.querySelector('#profile-dropdown-menu');
	const accountButton = document.querySelector('#account-dropdown-toggle');
	const accountMenu = document.querySelector('#account-dropdown-menu');
	const mobileProfileButton = document.querySelector('.profile-mobile-toggle');
	const mobileProfileMenu = document.querySelector('.profile-mobile-panel');

	const toggleElement = (element, button) => {
		if (!element) {
			return;
		}

		const isHidden = element.classList.toggle('hidden');
		button?.setAttribute('aria-expanded', String(!isHidden));
	};

	mobileMenuButton?.addEventListener('click', () => {
		toggleElement(mobileMenu, mobileMenuButton);
	});

	profileButton?.addEventListener('click', (event) => {
		event.stopPropagation();
		toggleElement(profileMenu, profileButton);
	});

	accountButton?.addEventListener('click', (event) => {
		event.stopPropagation();
		toggleElement(accountMenu, accountButton);
	});

	mobileProfileButton?.addEventListener('click', () => {
		toggleElement(mobileProfileMenu, mobileProfileButton);
	});

	document.addEventListener('click', (event) => {
		if (profileMenu && !profileMenu.closest('.profile-dropdown')?.contains(event.target)) {
			profileMenu.classList.add('hidden');
			profileButton?.setAttribute('aria-expanded', 'false');
		}

		if (accountMenu && !accountMenu.closest('.account-dropdown')?.contains(event.target)) {
			accountMenu.classList.add('hidden');
			accountButton?.setAttribute('aria-expanded', 'false');
		}
	});

	document.addEventListener('keydown', (event) => {
		if (event.key !== 'Escape') {
			return;
		}

		profileMenu?.classList.add('hidden');
		accountMenu?.classList.add('hidden');
		mobileMenu?.classList.add('hidden');
		mobileProfileMenu?.classList.add('hidden');
		profileButton?.setAttribute('aria-expanded', 'false');
		accountButton?.setAttribute('aria-expanded', 'false');
		mobileMenuButton?.setAttribute('aria-expanded', 'false');
		mobileProfileButton?.setAttribute('aria-expanded', 'false');
	});
};

const setupInformationFilters = () => {
	const searchInput = document.querySelector('#informasi-search');
	const filterButtons = document.querySelectorAll('.filter-btn');
	const informationCards = document.querySelectorAll('[data-category]');
	const noResults = document.querySelector('#no-results');

	if (!filterButtons.length || !informationCards.length) {
		return;
	}

	let activeFilter = 'semua';

	const applyFilter = () => {
		const searchTerm = searchInput?.value.trim().toLowerCase() ?? '';
		let visibleCards = 0;

		informationCards.forEach((card) => {
			const category = card.dataset.category?.replaceAll('-', ' ') ?? '';
			const content = card.textContent?.toLowerCase() ?? '';
			const matchesFilter = activeFilter === 'semua' || category === activeFilter;
			const matchesSearch = !searchTerm || content.includes(searchTerm);
			const isVisible = matchesFilter && matchesSearch;

			card.classList.toggle('hidden', !isVisible);
			visibleCards += isVisible ? 1 : 0;
		});

		noResults?.classList.toggle('hidden', visibleCards > 0);
	};

	filterButtons.forEach((button) => {
		button.addEventListener('click', () => {
			activeFilter = button.dataset.filter ?? 'semua';
			filterButtons.forEach((filterButton) => {
				filterButton.classList.toggle('bg-sky-600', filterButton === button);
				filterButton.classList.toggle('text-white', filterButton === button);
			});
			applyFilter();
		});
	});

	searchInput?.addEventListener('input', applyFilter);
};

document.addEventListener('DOMContentLoaded', () => {
	setupNavigation();
	setupInformationFilters();
});
