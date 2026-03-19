document.addEventListener("DOMContentLoaded", function () {
    const links = document.querySelectorAll(".dashboard-menu .dashboard-link");
    const currentPath = window.location.pathname.replace(/\/+$/, "");

    links.forEach((link) => {
        const rawHref = link.getAttribute("href");

        // Ignore placeholder links like "#"
        if (!rawHref || rawHref === "#") return;

        const linkPath = new URL(link.href, window.location.origin).pathname.replace(/\/+$/, "");

        let isActive = currentPath === linkPath;

        // Optional: treat request-details as part of My Requests
        if (currentPath.startsWith("/request-details") && linkPath.endsWith("/my-requests")) {
            isActive = true;
        }

        if (isActive) {
            links.forEach((l) => l.classList.remove("active"));
            link.classList.add("active");
        }
    });
});