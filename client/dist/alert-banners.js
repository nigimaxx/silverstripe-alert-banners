var AlertBanners = {
    /*
     * Adds listeners to all alert banner close buttons on the current page.
     */
    init: function() {
        var self = this;

        const bannerButtons = document.querySelectorAll('.alertbanner__close');

        bannerButtons.forEach(function(bannerClose) {
            const bannerID = bannerClose.dataset['bannerId'],
                banner = bannerClose.closest('.alertbanner');
            // Don't display banners which have been dismissed.
            if (!sessionStorage.getItem(self.getStorageKey(bannerID))) {
                banner.setAttribute('aria-hidden', 'false');
                banner.style.display = '';
                return;
            }
        });

        // Hide close button on banners if browser
        // does not support session storage
        if (!sessionStorage) {
            bannerButtons.forEach(function(button) {
                button.style.display = 'none';
            });
        } else if (bannerButtons !== null) {
            for (let i = 0; i < bannerButtons.length; i++) {
                const button = bannerButtons[i];
                button.addEventListener('click', function(e) {
                        e.preventDefault();
                        const target = e.target,
                            bannerID = target.dataset['bannerId'],
                            banner = target.closest('.alertbanner');
                        self.setStorage(bannerID);
                        self.hideBanner(banner);
                    }
                );
            }
        }
    },
    getStorageKey: function(id){
        return 'alertbanner_' + id + '_dismiss';
    },
    /*
     * Sets a sessionStorage to hide the alert banner next time the user visits the page
     */
    setStorage: function(bannerID){
        // Make sure the banner doesn't re-appear when the page is re-loaded.
        sessionStorage.setItem(this.getStorageKey(bannerID), 'true');
    },

    /*
     * Slides the up out of view when a dismissed by the user
     */
    hideBanner: function(target) {
        const duration = 500;
        target.style.transitionProperty = 'height, margin, padding';
        target.style.transitionDuration = duration + 'ms';
        target.style.boxSizing = 'border-box';
        target.style.height = target.offsetHeight + 'px';
        target.offsetHeight;
        target.style.overflow = 'hidden';
        target.style.height = 0;
        target.style.paddingTop = 0;
        target.style.paddingBottom = 0;
        target.style.marginTop = 0;
        target.style.marginBottom = 0;
        window.setTimeout( function(){
            target.style.display = 'none';
            target.style.removeProperty('height');
            target.style.removeProperty('padding-top');
            target.style.removeProperty('padding-bottom');
            target.style.removeProperty('margin-top');
            target.style.removeProperty('margin-bottom');
            target.style.removeProperty('overflow');
            target.style.removeProperty('transition-duration');
            target.style.removeProperty('transition-property');
        }, duration);
    }
}

document.addEventListener('readystatechange', function() {
    if (document.readyState === 'interactive') {
        AlertBanners.init();
    }
});
