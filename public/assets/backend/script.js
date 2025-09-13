/**
 * Admin Panel JavaScript - jQuery Based
 * Handles all interactive functionality for the admin panel
 */

$(document).ready(function () {
    'use strict';

    // Initialize all admin panel functionality
    initAdminPanel();

    /**
     * Initialize all admin panel features
     */
    function initAdminPanel() {
        initSidebarNavigation();
        initResponsiveMenu();
        initSidebarCollapse();
    }

    /**
     * Sidebar Navigation
     */
    function initSidebarNavigation() {
        setActiveNavigation();
    }

    /**
     * Responsive Menu Toggle
     */
    function initResponsiveMenu() {
        // Mobile sidebar toggle - use the correct selector
        $('.sidebar-toggle-btn, #sidebarToggle').on('click', function (e) {
            e.preventDefault();
            if ($(window).width() <= 768) {
                $('.admin-sidebar').toggleClass('show');
                $('.admin-overlay').toggleClass('show');
                // Toggle active state for the button
                $(this).toggleClass('active');
            }
        });

        // Close sidebar when clicking overlay
        $('.admin-overlay').on('click', function () {
            $('.admin-sidebar').removeClass('show');
            $('.admin-overlay').removeClass('show');
            $('.sidebar-toggle-btn, #sidebarToggle').removeClass('active');
        });

        // Close sidebar when clicking outside on mobile
        $(document).on('click', function (e) {
            if ($(window).width() <= 768) {
                if (!$(e.target).closest('.admin-sidebar, .sidebar-toggle-btn, #sidebarToggle').length) {
                    $('.admin-sidebar').removeClass('show');
                    $('.admin-overlay').removeClass('show');
                    $('.sidebar-toggle-btn, #sidebarToggle').removeClass('active');
                }
            }
        });

        // Handle window resize
        $(window).on('resize', function () {
            if ($(window).width() > 768) {
                $('.admin-sidebar').removeClass('show');
                $('.admin-overlay').removeClass('show');
                $('.sidebar-toggle-btn, #sidebarToggle').removeClass('active');
            }
        });

        // Close sidebar on escape key press
        $(document).on('keydown', function (e) {
            if (e.key === 'Escape' && $(window).width() <= 768) {
                $('.admin-sidebar').removeClass('show');
                $('.admin-overlay').removeClass('show');
                $('.sidebar-toggle-btn, #sidebarToggle').removeClass('active');
            }
        });
    }

    /**
     * Sidebar Collapse Functionality
     */
    function initSidebarCollapse() {
        $('#sidebarToggle').on('click', function () {

            // Only collapse on desktop
            if ($(window).width() > 768) {
                const sidebar = $('.admin-sidebar');
                const logo = $('.admin-logo');

                sidebar.toggleClass('collapsed');
                logo.toggleClass('collapsed');

                // Store state in localStorage
                const isCollapsed = sidebar.hasClass('collapsed');
                localStorage.setItem('admin-sidebar-collapsed', isCollapsed);

            }
        });

        // Restore collapsed state on page load (desktop only)
        if ($(window).width() > 768) {
            const isCollapsed = localStorage.getItem('admin-sidebar-collapsed') === 'true';
            if (isCollapsed) {
                $('.admin-sidebar').addClass('collapsed');
                $('.admin-logo').addClass('collapsed');
            }
        }
    }

    /**
     * Set active navigation based on current URL
     */
    function setActiveNavigation() {
        const currentPath = window.location.pathname;
        $('.sidebar-nav-link').each(function () {
            const href = $(this).attr('href');
            if (href && currentPath.includes(href)) {
                $(this).addClass('active');
            }
        });
    }
});
