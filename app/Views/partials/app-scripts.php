<!-- CSRF: sisipkan token (header X-CSRF-TOKEN) dan X-Requested-With pada fetch same-origin non-GET -->
<script>
    (function () {
        let csrfToken = '<?= csrf_hash() ?>';
        const nativeFetch = window.fetch.bind(window);

        window.fetch = function (input, init) {
            init = init || {};
            const url = typeof input === 'string' ? input : (input && input.url) || '';
            const method = String(init.method || (input && input.method) || 'GET').toUpperCase();
            const sameOrigin = url.startsWith('/') || url.startsWith(window.location.origin);

            if (sameOrigin) {
                const headers = new Headers(init.headers || (input && input.headers) || {});
                headers.set('X-Requested-With', 'XMLHttpRequest');
                if (!['GET', 'HEAD', 'OPTIONS'].includes(method)) {
                    headers.set('X-CSRF-TOKEN', csrfToken);
                }
                init.headers = headers;
            }

            return nativeFetch(input, init).then(function (response) {
                const fresh = response.headers.get('X-CSRF-TOKEN');
                if (fresh) csrfToken = fresh;
                return response;
            });
        };
    })();
</script>

<!-- Core scripts -->
<script src="/plugins/bootstrap/bootstrap.bundle.min.js"></script>
<script src="/scripts/core/smartNavigation.js"></script>
<script src="/scripts/core/smartFilter.js"></script>
<script src="/scripts/core/smartSlimscroll.js"></script>

<!-- Dependable scripts -->
<script src="/plugins/sortablejs/Sortable.min.js"></script>
<script src="/plugins/waves/waves.min.js"></script>

<!-- App.js -->
<script src="/scripts/core/smartApp.js"></script>