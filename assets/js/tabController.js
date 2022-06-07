let tabsContainer = document.querySelector("#tabs");

let tabTogglers = tabsContainer.querySelectorAll("#tabs li button");

tabTogglers.forEach(function (toggler) {
    toggler.addEventListener("click", function (e) {
        e.preventDefault();

        let tabName = this.getAttribute("data");

        let tabContents = document.querySelector("#tab-contents");

        for (let i = 0; i < tabContents.children.length; i++) {
            if (tabTogglers[i]) {
                tabTogglers[i].classList.remove("bg-neutral-300");
                tabTogglers[i].classList.remove("dark:text-black");
                tabTogglers[i].classList.add("dark:text-slate-400");
            }
            tabContents.children[i].classList.remove("hidden");

            if ("#" + tabContents.children[i].id === tabName) {
                continue;
            }
            tabContents.children[i].classList.add("hidden");
        }
        e.target.classList.add("bg-neutral-300");
        e.target.classList.add("dark:text-black");
    });
});