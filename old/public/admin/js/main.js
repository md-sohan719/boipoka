// ==========================================
// MAIN JAVASCRIPT - ADMIN PANEL
// ==========================================

class AdminPanel {
    constructor() {
        this.init();
    }

    init() {
        this.setupSidebar();
        this.setupSearch();
        this.setupDropdowns();
        this.setupModals();
        this.setupAnimations();
        this.setupTheme();
        this.setupNotifications();
    }

    // ==========================================
    // SIDEBAR FUNCTIONALITY
    // ==========================================
    setupSidebar() {
        const sidebar = document.querySelector('.sidebar');
        const sidebarToggle = document.querySelector('.sidebar-toggle');
        const navItems = document.querySelectorAll('.nav-item');
        
        // Mobile toggle
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', () => {
                sidebar.classList.toggle('open');
                document.body.classList.toggle('sidebar-open');
            });
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', (e) => {
            if (window.innerWidth <= 768) {
                if (!sidebar.contains(e.target) && !e.target.closest('.sidebar-toggle')) {
                    sidebar.classList.remove('open');
                    document.body.classList.remove('sidebar-open');
                }
            }
        });

        // Submenu toggle
        navItems.forEach(item => {
            const hasSubmenu = item.querySelector('.submenu');
            if (hasSubmenu) {
                item.addEventListener('click', (e) => {
                    if (e.target.closest('.nav-item') === item) {
                        e.preventDefault();
                        item.classList.toggle('submenu-open');
                        
                        // Close other submenus
                        navItems.forEach(otherItem => {
                            if (otherItem !== item && otherItem.classList.contains('submenu-open')) {
                                otherItem.classList.remove('submenu-open');
                            }
                        });
                    }
                });
            }
        });

        // Set active page
        this.setActivePage();
    }

    setActivePage() {
        const currentPage = window.location.pathname.split('/').pop() || 'dashboard.html';
        const navLinks = document.querySelectorAll('.nav-item, .submenu-item');
        
        navLinks.forEach(link => {
            const href = link.getAttribute('href');
            if (href && href.includes(currentPage)) {
                link.classList.add('active');
                // Open parent submenu if exists
                const parentSubmenu = link.closest('.submenu');
                if (parentSubmenu) {
                    parentSubmenu.closest('.nav-item').classList.add('submenu-open');
                }
            }
        });
    }

    // ==========================================
    // SEARCH FUNCTIONALITY
    // ==========================================
    setupSearch() {
        const searchInput = document.querySelector('.search-box input');
        const searchResults = document.createElement('div');
        searchResults.className = 'search-suggestions';
        
        if (searchInput) {
            searchInput.parentElement.appendChild(searchResults);

            // Sample search data
            const searchData = [
                { title: 'Dashboard', url: 'dashboard.html', icon: 'dashboard', category: 'Pages' },
                { title: 'Analytics', url: 'analytics.html', icon: 'analytics', category: 'Pages' },
                { title: 'Reports', url: 'reports.html', icon: 'description', category: 'Pages' },
                { title: 'Companies', url: 'companies.html', icon: 'business', category: 'Pages' },
                { title: 'People', url: 'people.html', icon: 'people', category: 'Pages' },
                { title: 'Settings', url: 'settings.html', icon: 'settings', category: 'Pages' },
                { title: 'Profile Settings', url: 'settings.html#profile', icon: 'account_circle', category: 'Settings' },
                { title: 'User Management', url: 'people.html', icon: 'group', category: 'Management' },
                { title: 'Financial Reports', url: 'reports.html#financial', icon: 'account_balance', category: 'Reports' },
                { title: 'Sales Analytics', url: 'analytics.html#sales', icon: 'trending_up', category: 'Analytics' },
            ];

            let searchTimeout;
            searchInput.addEventListener('input', (e) => {
                clearTimeout(searchTimeout);
                const query = e.target.value.toLowerCase().trim();

                if (query.length === 0) {
                    searchResults.classList.remove('active');
                    this.resetMenuFilter();
                    return;
                }

                // Filter menu items in real-time
                this.filterMenuItems(query);

                if (query.length < 2) {
                    searchResults.classList.remove('active');
                    return;
                }

                searchTimeout = setTimeout(() => {
                    const results = searchData.filter(item => 
                        item.title.toLowerCase().includes(query) ||
                        item.category.toLowerCase().includes(query)
                    );

                    this.renderSearchResults(results, searchResults, query);
                }, 300);
            });

            // Close search results when clicking outside
            document.addEventListener('click', (e) => {
                if (!e.target.closest('.search-box')) {
                    searchResults.classList.remove('active');
                }
            });

            // Keyboard navigation
            searchInput.addEventListener('keydown', (e) => {
                const items = searchResults.querySelectorAll('.search-item');
                const activeItem = searchResults.querySelector('.search-item.active');
                let currentIndex = Array.from(items).indexOf(activeItem);

                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    currentIndex = Math.min(currentIndex + 1, items.length - 1);
                    this.highlightSearchItem(items, currentIndex);
                } else if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    currentIndex = Math.max(currentIndex - 1, 0);
                    this.highlightSearchItem(items, currentIndex);
                } else if (e.key === 'Enter' && activeItem) {
                    e.preventDefault();
                    activeItem.click();
                }
            });
        }
    }

    renderSearchResults(results, container, query) {
        if (results.length === 0) {
            container.innerHTML = '<div class="search-empty">No results found</div>';
            container.classList.add('active');
            return;
        }

        const groupedResults = results.reduce((acc, item) => {
            if (!acc[item.category]) acc[item.category] = [];
            acc[item.category].push(item);
            return acc;
        }, {});

        let html = '';
        Object.keys(groupedResults).forEach(category => {
            html += `<div class="search-category">${category}</div>`;
            groupedResults[category].forEach(item => {
                const highlightedTitle = item.title.replace(
                    new RegExp(query, 'gi'),
                    match => `<strong>${match}</strong>`
                );
                html += `
                    <a href="${item.url}" class="search-item">
                        <span class="material-icons">${item.icon}</span>
                        <span>${highlightedTitle}</span>
                    </a>
                `;
            });
        });

        container.innerHTML = html;
        container.classList.add('active');
    }

    highlightSearchItem(items, index) {
        items.forEach((item, i) => {
            item.classList.toggle('active', i === index);
        });
        if (items[index]) {
            items[index].scrollIntoView({ block: 'nearest' });
        }
    }

    // ==========================================
    // MENU/SUBMENU FILTER FUNCTIONALITY
    // ==========================================
    filterMenuItems(query) {
        const navItems = document.querySelectorAll('.nav-item');
        const submenuItems = document.querySelectorAll('.submenu-item');
        let hasVisibleItems = false;

        // Filter main menu items
        navItems.forEach(item => {
            const text = item.textContent.toLowerCase();
            const matches = text.includes(query);
            
            if (matches) {
                item.style.display = 'flex';
                item.classList.add('search-highlight');
                hasVisibleItems = true;
                
                // If item has submenu, show it
                if (item.classList.contains('has-submenu')) {
                    item.classList.add('submenu-open');
                }
            } else {
                // Check if any submenu items match
                const submenu = item.querySelector('.submenu');
                if (submenu) {
                    const submenuMatches = Array.from(submenu.querySelectorAll('.submenu-item'))
                        .some(subItem => subItem.textContent.toLowerCase().includes(query));
                    
                    if (submenuMatches) {
                        item.style.display = 'flex';
                        item.classList.add('submenu-open');
                        hasVisibleItems = true;
                    } else {
                        item.style.display = 'none';
                        item.classList.remove('search-highlight');
                    }
                } else {
                    item.style.display = 'none';
                    item.classList.remove('search-highlight');
                }
            }
        });

        // Filter submenu items
        submenuItems.forEach(item => {
            const text = item.textContent.toLowerCase();
            const matches = text.includes(query);
            
            if (matches) {
                item.style.display = 'flex';
                item.classList.add('search-highlight');
                hasVisibleItems = true;
            } else {
                item.style.display = 'none';
                item.classList.remove('search-highlight');
            }
        });

        // Show "no results" message if nothing matches
        this.toggleNoResultsMessage(!hasVisibleItems);
    }

    resetMenuFilter() {
        const navItems = document.querySelectorAll('.nav-item');
        const submenuItems = document.querySelectorAll('.submenu-item');
        
        navItems.forEach(item => {
            item.style.display = 'flex';
            item.classList.remove('search-highlight');
        });

        submenuItems.forEach(item => {
            item.style.display = 'flex';
            item.classList.remove('search-highlight');
        });

        this.toggleNoResultsMessage(false);
    }

    toggleNoResultsMessage(show) {
        let noResults = document.querySelector('.menu-no-results');
        
        if (show && !noResults) {
            noResults = document.createElement('div');
            noResults.className = 'menu-no-results';
            noResults.innerHTML = `
                <span class="material-icons">search_off</span>
                <p>No menu items found</p>
            `;
            document.querySelector('.sidebar-nav').appendChild(noResults);
        } else if (!show && noResults) {
            noResults.remove();
        }
    }

    // ==========================================
    // DROPDOWN FUNCTIONALITY
    // ==========================================
    setupDropdowns() {
        const dropdownTriggers = document.querySelectorAll('[data-dropdown]');
        
        dropdownTriggers.forEach(trigger => {
            trigger.addEventListener('click', (e) => {
                e.stopPropagation();
                const dropdownId = trigger.getAttribute('data-dropdown');
                const dropdown = document.getElementById(dropdownId);
                
                if (dropdown) {
                    // Close other dropdowns
                    document.querySelectorAll('.dropdown-menu.active').forEach(menu => {
                        if (menu !== dropdown) {
                            menu.classList.remove('active');
                        }
                    });
                    
                    dropdown.classList.toggle('active');
                    this.positionDropdown(trigger, dropdown);
                }
            });
        });

        // Close dropdowns when clicking outside
        document.addEventListener('click', () => {
            document.querySelectorAll('.dropdown-menu.active').forEach(menu => {
                menu.classList.remove('active');
            });
        });

        // Prevent dropdown from closing when clicking inside
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
            menu.addEventListener('click', (e) => {
                e.stopPropagation();
            });
        });
    }

    positionDropdown(trigger, dropdown) {
        const triggerRect = trigger.getBoundingClientRect();
        const dropdownRect = dropdown.getBoundingClientRect();
        
        // Position below trigger
        dropdown.style.top = `${triggerRect.bottom + 5}px`;
        dropdown.style.left = `${triggerRect.left}px`;
        
        // Adjust if dropdown goes off screen
        if (triggerRect.left + dropdownRect.width > window.innerWidth) {
            dropdown.style.left = `${window.innerWidth - dropdownRect.width - 10}px`;
        }
    }

    // ==========================================
    // MODAL FUNCTIONALITY
    // ==========================================
    setupModals() {
        const modalTriggers = document.querySelectorAll('[data-modal]');
        const modals = document.querySelectorAll('.modal');
        
        modalTriggers.forEach(trigger => {
            trigger.addEventListener('click', (e) => {
                e.preventDefault();
                const modalId = trigger.getAttribute('data-modal');
                const modal = document.getElementById(modalId);
                if (modal) {
                    modal.classList.add('active');
                    document.body.style.overflow = 'hidden';
                }
            });
        });

        modals.forEach(modal => {
            const closeBtn = modal.querySelector('.modal-close');
            const overlay = modal.querySelector('.modal-overlay');
            
            if (closeBtn) {
                closeBtn.addEventListener('click', () => {
                    modal.classList.remove('active');
                    document.body.style.overflow = '';
                });
            }
            
            if (overlay) {
                overlay.addEventListener('click', () => {
                    modal.classList.remove('active');
                    document.body.style.overflow = '';
                });
            }
        });

        // Close modal on ESC key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                modals.forEach(modal => {
                    modal.classList.remove('active');
                    document.body.style.overflow = '';
                });
            }
        });
    }

    // ==========================================
    // ANIMATIONS
    // ==========================================
    setupAnimations() {
        // Fade in elements on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animated');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.fade-in-up').forEach(el => {
            observer.observe(el);
        });

        // Number counter animation
        this.animateCounters();
    }

    animateCounters() {
        const counters = document.querySelectorAll('[data-count]');
        
        counters.forEach(counter => {
            const target = parseFloat(counter.getAttribute('data-count'));
            const duration = 2000;
            const step = target / (duration / 16);
            let current = 0;

            const updateCounter = () => {
                current += step;
                if (current < target) {
                    counter.textContent = Math.floor(current).toLocaleString();
                    requestAnimationFrame(updateCounter);
                } else {
                    counter.textContent = target.toLocaleString();
                }
            };

            // Start animation when element is visible
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting && !counter.classList.contains('counted')) {
                        counter.classList.add('counted');
                        updateCounter();
                        observer.unobserve(counter);
                    }
                });
            });

            observer.observe(counter);
        });
    }

    // ==========================================
    // THEME TOGGLE
    // ==========================================
    setupTheme() {
        const themeToggle = document.querySelector('.theme-toggle');
        const currentTheme = localStorage.getItem('theme') || 'light';
        
        document.documentElement.setAttribute('data-theme', currentTheme);
        
        if (themeToggle) {
            themeToggle.addEventListener('click', () => {
                const theme = document.documentElement.getAttribute('data-theme');
                const newTheme = theme === 'light' ? 'dark' : 'light';
                
                document.documentElement.setAttribute('data-theme', newTheme);
                localStorage.setItem('theme', newTheme);
                
                // Update icon
                const icon = themeToggle.querySelector('.material-icons');
                if (icon) {
                    icon.textContent = newTheme === 'light' ? 'dark_mode' : 'light_mode';
                }
            });
        }
    }

    // ==========================================
    // NOTIFICATIONS
    // ==========================================
    setupNotifications() {
        const notificationBtn = document.querySelector('.notification-btn');
        
        if (notificationBtn) {
            notificationBtn.addEventListener('click', () => {
                this.showNotification('You have 3 new notifications', 'info');
            });
        }
    }

    showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        
        const icons = {
            success: 'check_circle',
            error: 'error',
            warning: 'warning',
            info: 'info'
        };
        
        notification.innerHTML = `
            <span class="material-icons">${icons[type]}</span>
            <span>${message}</span>
            <button class="notification-close">
                <span class="material-icons">close</span>
            </button>
        `;
        
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => notification.classList.add('active'), 10);
        
        // Auto close
        const autoClose = setTimeout(() => {
            this.closeNotification(notification);
        }, 5000);
        
        // Manual close
        const closeBtn = notification.querySelector('.notification-close');
        closeBtn.addEventListener('click', () => {
            clearTimeout(autoClose);
            this.closeNotification(notification);
        });
    }

    closeNotification(notification) {
        notification.classList.remove('active');
        setTimeout(() => notification.remove(), 300);
    }
}

// ==========================================
// TABLE FUNCTIONALITY
// ==========================================
class TableManager {
    constructor(tableSelector) {
        this.table = document.querySelector(tableSelector);
        if (this.table) {
            this.init();
        }
    }

    init() {
        this.setupSorting();
        this.setupFiltering();
        this.setupSelection();
        this.setupPagination();
    }

    setupSorting() {
        const headers = this.table.querySelectorAll('th[data-sortable]');
        
        headers.forEach(header => {
            header.style.cursor = 'pointer';
            header.addEventListener('click', () => {
                const column = header.getAttribute('data-sortable');
                this.sortTable(column, header);
            });
        });
    }

    sortTable(column, header) {
        const tbody = this.table.querySelector('tbody');
        const rows = Array.from(tbody.querySelectorAll('tr'));
        const index = Array.from(header.parentElement.children).indexOf(header);
        const isAscending = header.classList.contains('sort-asc');
        
        rows.sort((a, b) => {
            const aValue = a.children[index].textContent.trim();
            const bValue = b.children[index].textContent.trim();
            
            if (!isNaN(aValue) && !isNaN(bValue)) {
                return isAscending ? bValue - aValue : aValue - bValue;
            }
            
            return isAscending 
                ? bValue.localeCompare(aValue)
                : aValue.localeCompare(bValue);
        });
        
        // Update header classes
        this.table.querySelectorAll('th').forEach(th => {
            th.classList.remove('sort-asc', 'sort-desc');
        });
        
        header.classList.add(isAscending ? 'sort-desc' : 'sort-asc');
        
        // Reorder rows
        rows.forEach(row => tbody.appendChild(row));
    }

    setupFiltering() {
        const searchInput = document.querySelector('.table-search input');
        
        if (searchInput) {
            searchInput.addEventListener('input', (e) => {
                this.filterTable(e.target.value);
            });
        }
    }

    filterTable(query) {
        const tbody = this.table.querySelector('tbody');
        const rows = tbody.querySelectorAll('tr');
        const lowerQuery = query.toLowerCase();
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(lowerQuery) ? '' : 'none';
        });
    }

    setupSelection() {
        const selectAll = this.table.querySelector('thead input[type="checkbox"]');
        const checkboxes = this.table.querySelectorAll('tbody input[type="checkbox"]');
        
        if (selectAll) {
            selectAll.addEventListener('change', () => {
                checkboxes.forEach(cb => {
                    cb.checked = selectAll.checked;
                    cb.closest('tr').classList.toggle('selected', selectAll.checked);
                });
            });
        }
        
        checkboxes.forEach(cb => {
            cb.addEventListener('change', () => {
                cb.closest('tr').classList.toggle('selected', cb.checked);
                
                // Update select all checkbox
                if (selectAll) {
                    const allChecked = Array.from(checkboxes).every(c => c.checked);
                    selectAll.checked = allChecked;
                }
            });
        });
    }

    setupPagination() {
        const pagination = document.querySelector('.pagination');
        if (!pagination) return;
        
        const buttons = pagination.querySelectorAll('.page-btn');
        buttons.forEach(btn => {
            btn.addEventListener('click', () => {
                buttons.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
            });
        });
    }
}

// ==========================================
// INITIALIZE
// ==========================================
document.addEventListener('DOMContentLoaded', () => {
    new AdminPanel();
    new TableManager('.data-table');
    
    // Add smooth scrolling
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href !== '#') {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            }
        });
    });
});

// ==========================================
// UTILITY FUNCTIONS
// ==========================================
function formatCurrency(amount) {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
    }).format(amount);
}

function formatDate(date) {
    return new Intl.DateTimeFormat('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    }).format(new Date(date));
}

function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}
