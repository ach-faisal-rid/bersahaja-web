/**
 * Konfigurasi Menu Sidebar
 * 
 * Format:
 * - type: 'link' untuk single menu
 * - type: 'group' untuk parent-child menu
 * 
 * Mudah untuk menambah/mengurangi menu tanpa edit component
 */

export const sidebarMenu = [
    {
        id: 'dashboard',
        name: 'Dashboard',
        href: '/dashboard',
        icon: 'dashboard',
        type: 'link',
        requiresAuth: true,
    },
    {
        id: 'shalat',
        name: 'Shalat',
        icon: 'shalat',
        type: 'group',
        defaultExpanded: true,
        children: [
            {
                id: 'tata-cara',
                name: 'Tata Cara',
                href: '/tata-cara',
                icon: 'tataCara',
            },
            {
                id: 'gerakan-shalat',
                name: 'Gerakan',
                href: '/gerakan-shalat',
                icon: 'gerakan',
            },
            {
                id: 'bacaan',
                name: 'Bacaan',
                href: '/bacaan',
                icon: 'bacaan',
            },
            {
                id: 'adzan',
                name: 'Adzan',
                href: '/adzan',
                icon: 'adzan',
            },
            {
                id: 'iqamat',
                name: 'Iqamat',
                href: '/iqamat',
                icon: 'iqamat',
            },
            {
                id: 'khutbah',
                name: 'Khutbah',
                href: '/khutbah',
                icon: 'khutbah',
            },
            {
                id: 'doa-setelah-sholat',
                name: 'Doa Setelah Sholat',
                href: '/doa-setelah-sholat',
                icon: 'doaSetelahSholat',
            },
            {
                id: 'wudu',
                name: 'Wudu',
                href: '/wudu',
                icon: 'wudu',
            },
        ],
    },
    {
        id: 'content',
        name: 'Content',
        icon: 'content',
        type: 'group',
        defaultExpanded: true,
        children: [
            {
                id: 'categories',
                name: 'Kategori',
                href: '/categories',
                icon: 'kategori',
                requiresAuth: true,
            },
            {
                id: 'tags',
                name: 'Tag',
                href: '/tags',
                icon: 'tag',
                requiresAuth: true,
            },
            {
                id: 'repositories',
                name: 'Repositori',
                href: '/repositories',
                icon: 'repositori',
                requiresAuth: true,
            },
            {
                id: 'doas',
                name: 'Doa',
                href: '/doas',
                icon: 'doa',
            },
            {
                id: 'hadists',
                name: 'Hadist',
                href: '/hadists',
                icon: 'hadist',
            },
        ],
    },
    {
        id: 'favorit',
        name: 'Favorit',
        href: '/favorit',
        icon: 'favorit',
        type: 'link',
        requiresAuth: true,
    },
    {
        id: 'calendar',
        name: 'Kalender',
        icon: 'calendar',
        type: 'group',
        defaultExpanded: false,
        children: [
            {
                id: 'hijri',
                name: 'Hijri',
                href: '/hijri',
                icon: 'hijri',
            },
        ],
    },
    {
        id: 'admin',
        name: 'Admin',
        icon: 'admin',
        type: 'group',
        requiresAuth: true,
        requiresRole: 'admin',
        defaultExpanded: false,
        children: [
            {
                id: 'users',
                name: 'Users',
                href: '/users',
                icon: 'users',
            },
            {
                id: 'legal-content',
                name: 'Legal Content',
                href: '/admin/legal-content',
                icon: 'tag',
            },
        ],
    },
    {
        id: 'profile',
        name: 'Profile',
        icon: 'profile',
        type: 'group',
        requiresAuth: true,
        defaultExpanded: false,
        children: [
            {
                id: 'edit-profile',
                name: 'Edit Profile',
                href: '/profile',
                icon: 'editProfile',
            },
        ],
    },
];

/**
 * Icon mapping untuk SVG icons
 * Separated untuk mudah di-share antar component
 */
export const iconMap = {
    dashboard: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>`,
    shalat: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12.066 11.2a1 1 0 000 1.6l5.5 4.4a1 1 0 001.334-.832l2.126-13.286A1 1 0 0020.537 0s-4.571 1.6-5.559 7.41c-.243 1.688-.645 4.595-.819 6.79zm0 0L4.75 4.6a1 1 0 00-1.334.832l-2.126 13.286A1 1 0 003.463 24c4.571-1.6 5.559-7.41 5.559-7.41" /></svg>`,
    tataCara: `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>`,
    gerakan: `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h-2M14 8h-2m4 6h-2m4-2h-2M6 10H4m0 2H4m12-8a2 2 0 110 4 2 2 0 010-4zM4 8a2 2 0 110 4 2 2 0 010-4z" /></svg>`,
    bacaan: `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747 0-6.002-4.5-10.747-10-10.747z" /></svg>`,
    adzan: `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" /></svg>`,
    iqamat: `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" /></svg>`,
    khutbah: `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>`,
    doaSetelahSholat: `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>`,
    wudu: `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2s4 3 4 6a4 4 0 11-8 0c0-3 4-6 4-6zM12 12v10" /></svg>`,
    content: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" /></svg>`,
    kategori: `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" /></svg>`,
    tag: `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" /></svg>`,
    repositori: `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" /></svg>`,
    doa: `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" /></svg>`,
    hadist: `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" /></svg>`,
    favorit: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" /></svg>`,
    calendar: `<svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1M4.2 6.2l.7.7M19.1 17.1l.7.7M3 12h1m16 0h1M4.2 17.8l.7-.7M19.1 6.9l.7-.7" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8a4 4 0 100 8 4 4 0 000-8z" /></svg>`,
    hijri: `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>`,
    admin: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>`,
    users: `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>`,
    profile: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>`,
    editProfile: `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>`,
    chevronRight: `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>`,
};
