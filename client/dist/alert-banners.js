class AlertBanners {
    /*
     * Adds listeners to all alert banner close buttons on the current page.
     */
    init() {
        const bannerButtons = document.querySelectorAll('.alertbanner__close');

        if (bannerButtons !== null) {
            var self = this
            for (let i = 0; i < bannerButtons.length; i++) {
                const button = bannerButtons[i];
                button.addEventListener('click', e => {
                        e.preventDefault();
                        const target = e.target,
                            bannerID = target.dataset['bannerId'],
                            cookieLength = target.dataset['cookieLength'],
                            banner = target.closest('.alertbanner');
                        self.setCookie(bannerID, cookieLength);
                        console.log(banner);
                        self.hideBanner(banner);
                    }
                );
            }
        }
    }

    /*
     * Sets a cookie to hide the alert banner next time the user visits the page
     */
    setCookie(bannerID, cookieLength){
        const days = cookieLength ? cookieLength : 30,
            millis = (days * 86400000), // number of days * milliseconds in a day
            date = new Date();
        date.setTime(date.getTime() + millis);
        document.cookie = 'hidealertbanner-' + bannerID + '=true;expires=' + date.toUTCString() + ';path=' + window.location.origin + ';';
    }

    /*
     * Slides the up out of view when a dismissed by the user
     */
    hideBanner(target) {
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
        window.setTimeout( () => {
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

document.addEventListener('readystatechange', () => {
    if (document.readyState === 'interactive') {
        const alerts = new AlertBanners();
        alerts.init();
    }
});
