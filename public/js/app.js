document.addEventListener('click', function (e) {
    // Expand/collapse a stacked menu (mobile top nav or mobile rail)
    var navBtn = e.target.closest('[data-nav-toggle]');
    if (navBtn) {
        var menu = navBtn.closest('.topbar, .rail');
        if (menu) {
            menu.classList.toggle('open');
        }
        return;
    }

    // Collapse/expand the sidebar rail (desktop)
    var collapseBtn = e.target.closest('[data-rail-collapse]');
    if (collapseBtn) {
        var app = document.querySelector('.app');
        if (app) {
            app.classList.toggle('rail-collapsed');
        }
    }
});
