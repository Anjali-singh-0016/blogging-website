document.addEventListener("DOMContentLoaded", () => {
    const sidebarLinks = document.querySelectorAll(".sidebar ul li a");
    const creatBlogLinks = document.querySelectorAll(".actions-container a");
    const contentArea = document.getElementById("content-area");

    // Add event listeners to sidebar links
    sidebarLinks.forEach(link => {
        link.addEventListener("click", (e) => {
            e.preventDefault();
            // Remove the active class from all links
            sidebarLinks.forEach(l => l.classList.remove("active"));
            // Add the active class to the clicked link
            link.classList.add("active");
            const target = link.getAttribute("data-target");

            if (target) {
                // Load content dynamically
                fetch(target)
                    .then(response => {
                        if (!response.ok) throw new Error("Failed to load content");
                        return response.text();
                    })
                    .then(html => {
                        contentArea.innerHTML = html;
                    })
                    .catch(error => {
                        contentArea.innerHTML = "<p>Error loading content. Please try again later.</p>";
                        console.error(error);
                    });
            }
        });
    });

    // Add event listeners to the "Quick Actions" links
    creatBlogLinks.forEach(link => {
        link.addEventListener("click", (e) => {
            e.preventDefault();
            const target = link.getAttribute("href"); // Get the link's href attribute
            loadContent(target); // Load the content from the link's target URL
        });
    });

    // Function to load content dynamically into the content area
    function loadContent(url) {
        fetch(url)
            .then(response => {
                if (!response.ok) throw new Error("Failed to load content");
                return response.text();
            })
            .then(html => {
                contentArea.innerHTML = html; // Inject content into the content area
            })
            .catch(error => {
                contentArea.innerHTML = "<p>Error loading content. Please try again later.</p>";
                console.error(error);
            });
    }
});
