/**
 * SIDEBAR MODULAR STRUCTURE GUIDE
 * 
 * Struktur sidebar telah diubah menjadi modular dan mudah dikembangkan.
 * Berikut penjelasan cara kerjanya dan bagaimana menggunakannya.
 */

// ============================================================================
// 1. STRUKTUR MENU CONFIGURATION
// ============================================================================
// File: resources/js/Config/sidebarMenu.js
// 
// Menu disimpan dalam array sebagai data-driven configuration.
// Setiap item menu dapat berupa:
//
// A. SINGLE LINK MENU (Tanpa child)
// {
//     id: 'unique-id',
//     name: 'Menu Name',
//     href: '/route-path',
//     icon: 'iconKey',  // refer ke iconMap
//     type: 'link',
//     requiresAuth: true,
// }
//
// B. GROUP MENU (Dengan child)
// {
//     id: 'unique-id',
//     name: 'Parent Menu',
//     icon: 'iconKey',
//     type: 'group',
//     requiresAuth: true,
//     requiresRole: 'admin',  // optional, untuk role-based menu
//     defaultExpanded: true,   // true untuk expanded default, false untuk collapsed
//     children: [
//         {
//             id: 'child-id',
//             name: 'Child Menu',
//             href: '/route-path',
//             icon: 'childIconKey',
//         }
//     ]
// }

// ============================================================================
// 2. ICON MANAGEMENT
// ============================================================================
// File: resources/js/Config/sidebarMenu.js - iconMap
//
// Semua SVG icons disimpan dalam object `iconMap` dengan key unik.
// Ini memudahkan untuk:
// - Meng-update icon tanpa perlu akses component
// - Reuse icon di tempat lain
// - Menjaga code tetap clean dan organized
//
// Cara menambah icon baru:
// export const iconMap = {
//     myNewIcon: `<svg class="...">...</svg>`,
// }

// ============================================================================
// 3. COMPONENT STRUCTURE
// ============================================================================
// 
// A. Sidebar.vue (Parent Component)
//    - Mengontrol state sidebar (open/close untuk mobile)
//    - Import menu dari sidebarMenu.js
//    - Filter menu berdasarkan type (link vs group)
//    - Render SidebarMenuItem dan SidebarMenuGroup
//
// B. SidebarMenuItem.vue (Single Link Component)
//    - Menerima prop: item, onNavigate
//    - Render single link menu
//    - Handle active state berdasarkan current URL
//    - Emit navigate event untuk close sidebar di mobile
//
// C. SidebarMenuGroup.vue (Parent-Child Component)
//    - Menerima prop: item, defaultExpanded, onNavigate
//    - Manage expand/collapse state
//    - Auto-expand jika child menu aktif
//    - Render child items menggunakan SidebarMenuItem
//    - Smooth transition animation saat expand/collapse

// ============================================================================
// 4. HOW TO ADD NEW MENU
// ============================================================================
// 
// STEP 1: Tambahkan icon ke iconMap (di sidebarMenu.js)
//     export const iconMap = {
//         ...existing,
//         myIcon: `<svg>...</svg>`,
//     }
//
// STEP 2: Tambahkan menu ke sidebarMenu array (di sidebarMenu.js)
//     export const sidebarMenu = [
//         ...existing,
//         {
//             id: 'my-menu',
//             name: 'My Menu',
//             icon: 'myIcon',
//             type: 'link',  // atau 'group'
//             href: '/my-route',
//             requiresAuth: true,
//         }
//     ]
//
// STEP 3: Done! Sidebar akan otomatis render menu baru

// ============================================================================
// 5. HOW TO ADD SUBMENU (CHILD)
// ============================================================================
// 
// Ubah type menjadi 'group' dan tambahkan children array:
//
// {
//     id: 'my-group',
//     name: 'My Group',
//     icon: 'myIcon',
//     type: 'group',
//     defaultExpanded: false,
//     requiresAuth: true,
//     children: [
//         {
//             id: 'child-1',
//             name: 'Child Menu 1',
//             href: '/child-route-1',
//             icon: 'childIcon1',
//         },
//         {
//             id: 'child-2',
//             name: 'Child Menu 2',
//             href: '/child-route-2',
//             icon: 'childIcon2',
//         }
//     ]
// }

// ============================================================================
// 6. FEATURES
// ============================================================================
// 
// ✅ Modular Structure
//    - Menu configuration terpusat di sidebarMenu.js
//    - Icon management terpusat di iconMap
//    - Component untuk single link dan group terpisah
//
// ✅ Smart Expand/Collapse
//    - Parent menu otomatis expand jika child aktif
//    - Smooth animation transition
//    - Persistent state based on defaultExpanded property
//
// ✅ Active State Detection
//    - Automatic active state berdasarkan current URL
//    - Highlight both parent dan child jika aktif
//    - Work correctly dengan Inertia Link navigation
//
// ✅ Mobile Responsive
//    - Sidebar toggle untuk mobile
//    - Auto-close sidebar saat menu diklik
//    - Overlay saat sidebar dibuka
//
// ✅ Dark Mode Support
//    - Styling untuk light dan dark mode
//    - Seamless transition
//
// ✅ Future-Proof
//    - Mudah menambah menu tanpa edit component
//    - Mudah mengubah struktur yang ada
//    - Support untuk role-based menu (ready untuk implementasi)

// ============================================================================
// 7. ROLE-BASED MENU (Future Implementation)
// ============================================================================
// 
// Sudah ready di structure, tinggal implementasikan logic:
//
// {
//     id: 'admin-menu',
//     name: 'Admin Panel',
//     icon: 'admin',
//     type: 'group',
//     requiresAuth: true,
//     requiresRole: 'admin',  // <-- Role check
//     children: [...]
// }
//
// Di Sidebar.vue, filter menu berdasarkan auth dan role:
// const visibleMenus = computed(() => {
//     return sidebarMenu.filter(item => {
//         if (item.requiresAuth && !authUser.value) return false;
//         if (item.requiresRole && authUser.value?.role !== item.requiresRole) return false;
//         return true;
//     });
// });

// ============================================================================
