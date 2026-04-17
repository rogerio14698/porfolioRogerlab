(function () {
    'use strict';

    var LINK_SELECTOR = 'a[data-partial-nav]';
    var CONTAINER_SELECTOR = '#dynamic-section';
    var ACTIVE_LINK_ATTR = 'aria-current';

    function getContainer(root) {
        return (root || document).querySelector(CONTAINER_SELECTOR);
    }

    function isModifiedEvent(event) {
        return event.metaKey || event.ctrlKey || event.shiftKey || event.altKey;
    }

    function isNavigableLink(link) {
        if (!link || !link.href) {
            return false;
        }

        if (link.target && link.target !== '_self') {
            return false;
        }

        if (link.hasAttribute('download')) {
            return false;
        }

        var targetUrl = new URL(link.href, window.location.origin);

        if (targetUrl.origin !== window.location.origin) {
            return false;
        }

        return true;
    }

    function updateActiveLinks() {
        var currentPath = window.location.pathname.replace(/\/$/, '') || '/';

        document.querySelectorAll(LINK_SELECTOR).forEach(function (link) {
            var linkPath = new URL(link.href, window.location.origin).pathname.replace(/\/$/, '') || '/';
            var isCurrent = linkPath === currentPath;

            if (isCurrent) {
                link.setAttribute(ACTIVE_LINK_ATTR, 'page');
                return;
            }

            link.removeAttribute(ACTIVE_LINK_ATTR);
        });
    }

    function dispatchNavigationLoaded(container) {
        document.dispatchEvent(new CustomEvent('partial:navigation:loaded', {
            detail: {
                container: container,
                section: container ? container.dataset.section : null,
                url: window.location.href
            }
        }));
    }

    async function fetchSection(url) {
        var response = await fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-Partial-Navigation': 'true'
            },
            credentials: 'same-origin'
        });

        if (!response.ok && response.status !== 404) {
            throw new Error('Navigation request failed with status ' + response.status);
        }

        return response.text();
    }

    function parseContainer(markup) {
        var parser = new DOMParser();
        var documentFragment = parser.parseFromString(markup, 'text/html');

        return getContainer(documentFragment);
    }

    async function navigate(url, options) {
        var settings = options || {};
        var currentContainer = getContainer(document);

        if (!currentContainer) {
            window.location.href = url;
            return;
        }

        document.body.setAttribute('data-navigation-loading', 'true');

        try {
            var markup = await fetchSection(url);
            var nextContainer = parseContainer(markup);

            if (!nextContainer) {
                window.location.href = url;
                return;
            }

            currentContainer.replaceWith(nextContainer);

            if (nextContainer.dataset.pageTitle) {
                document.title = nextContainer.dataset.pageTitle;
            }

            if (settings.pushState !== false) {
                window.history.pushState({ url: url }, '', url);
            }

            if (settings.scroll !== false) {
                window.scrollTo({ top: 0, behavior: 'auto' });
            }

            updateActiveLinks();
            dispatchNavigationLoaded(nextContainer);
        } catch (error) {
            window.location.href = url;
        } finally {
            document.body.removeAttribute('data-navigation-loading');
        }
    }

    function handleLinkClick(event) {
        if (event.defaultPrevented || event.button !== 0 || isModifiedEvent(event)) {
            return;
        }

        var link = event.target.closest(LINK_SELECTOR);

        if (!isNavigableLink(link)) {
            return;
        }

        var nextUrl = new URL(link.href, window.location.origin);
        var currentUrl = new URL(window.location.href);

        if (nextUrl.pathname === currentUrl.pathname && nextUrl.search === currentUrl.search) {
            event.preventDefault();
            return;
        }

        event.preventDefault();
        navigate(nextUrl.href);
    }

    function handleHistoryNavigation() {
        navigate(window.location.href, {
            pushState: false,
            scroll: false
        });
    }

    function init() {
        updateActiveLinks();
        document.addEventListener('click', handleLinkClick);
        window.addEventListener('popstate', handleHistoryNavigation);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
}());