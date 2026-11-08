<aside class="app-sidebar d-flex flex-column">

    <?= $this->include('partials/app-logo') ?>

    <nav id="js-primary-nav" class="primary-nav flex-grow-1 custom-scroll">

        <?= $this->include('partials/generated-navigation') ?>

    </nav>

    <div class="nav-footer">
        <svg class="sa-icon sa-thin">
            <use href="/icons/sprite.svg#wifi"></use>
        </svg>
    </div>
</aside>

<div class="backdrop" data-action="toggle-swap" data-toggleclass="app-mobile-menu-open"></div>


<!-- Sidebar Link Active Script -->
<script>
    const sideNavMenu = document.getElementById("js-nav-menu");
    const currentUrl = window.location.href.split(/[?#]/)[0];     // Match current URL
    const allLinks = sideNavMenu.querySelectorAll("a");
    const allCollapses = sideNavMenu.querySelectorAll("li [aria-expanded='true']");   // Ensure only one collapse is open at a time

    // Prevent default toggle behavior for toggle links
    sideNavMenu.querySelectorAll("li .has-ul").forEach((toggle) => { toggle.addEventListener("click", (e) => e.preventDefault()); });

    allCollapses.forEach((collapse) => {

        console.log(collapse)
        collapse.addEventListener("show.bs.collapse", (event) => {
            const currentCollapse = event.target;

            // Get all ancestor collapses of the current item
            const ancestors = [];
            let el = currentCollapse.parentElement;
            while (el && el !== sideNavMenu) {
                if (el.classList.contains("collapse")) {
                    ancestors.push(el);
                }
                el = el.parentElement;
            }

            allCollapses.forEach((other) => {
                if (other !== currentCollapse && !ancestors.includes(other)) {
                    new bootstrap.Collapse(other, { toggle: false }).hide();
                }
            });
        });
    });

    allLinks.forEach((link) => {
        if (link.href === currentUrl) {

            link.classList.add("active");

            // Traverse up to activate all parents and show collapses
            let currentElement = link.closest("li");
            while (currentElement && currentElement !== sideNavMenu) {
                currentElement.classList.add("active");

                // Show parent collapses
                const parentCollapse = currentElement.closest("[role='menu']");
                if (parentCollapse) {
                    new bootstrap.Collapse(parentCollapse, { toggle: false }).show();

                    // Also mark the <li> that contains the collapse as active
                    const collapseParentLi = parentCollapse.closest("li");
                    if (collapseParentLi) {
                        collapseParentLi.classList.add("active");
                    }

                    currentElement = collapseParentLi;
                } else {
                    currentElement = currentElement.parentElement;
                }
            }
        }
    });
</script>