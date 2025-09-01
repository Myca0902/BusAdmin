document.addEventListener("DOMContentLoaded", () => {
    const regionSelect   = document.getElementById("region");
    const provinceSelect = document.getElementById("province");
    const citySelect     = document.getElementById("city");
    const barangaySelect = document.getElementById("barangay");

    // Helper: clear and reset dropdown
    function resetSelect(select, placeholder) {
        select.innerHTML = "";
        const option = document.createElement("option");
        option.value = "";
        option.textContent = placeholder;
        select.appendChild(option);
        select.disabled = true;
    }

    // Load Regions
    fetch(regionUrl)
        .then(res => res.json())
        .then(data => {
            resetSelect(regionSelect, "Choose Region");
            data.forEach(region => {
                const opt = document.createElement("option");
                opt.value = region.reg_code;
                opt.textContent = region.name;
                regionSelect.appendChild(opt);
            });
            regionSelect.disabled = false;
        })
        .catch(err => console.error("Error loading regions:", err));

    // When Region changes → load Provinces
    regionSelect.addEventListener("change", () => {
        resetSelect(provinceSelect, "Choose Province");
        resetSelect(citySelect, "Choose City / Municipality");
        resetSelect(barangaySelect, "Choose Barangay");

        if (!regionSelect.value) return;

        fetch(provinceUrl)
            .then(res => res.json())
            .then(data => {
                const provinces = data.filter(p => p.reg_code === regionSelect.value);
                provinces.forEach(province => {
                    const opt = document.createElement("option");
                    opt.value = province.prov_code;
                    opt.textContent = province.name;
                    provinceSelect.appendChild(opt);
                });
                provinceSelect.disabled = false;
            })
            .catch(err => console.error("Error loading provinces:", err));
    });

    // Province → Cities
    provinceSelect.addEventListener("change", () => {
        resetSelect(citySelect, "Choose City / Municipality");
        resetSelect(barangaySelect, "Choose Barangay");

        if (!provinceSelect.value) return;

        fetch(cityUrl)
            .then(res => res.json())
            .then(data => {
                const cities = data.filter(c => c.prov_code === provinceSelect.value);
                cities.forEach(city => {
                    const opt = document.createElement("option");
                    opt.value = city.citymun_code;
                    opt.textContent = city.name;
                    citySelect.appendChild(opt);
                });
                citySelect.disabled = false;
            })
            .catch(err => console.error("Error loading cities:", err));
    });

    // City → Barangays
    citySelect.addEventListener("change", () => {
        resetSelect(barangaySelect, "Choose Barangay");

        if (!citySelect.value) return;

        fetch(barangayUrl)
            .then(res => res.json())
            .then(data => {
                const barangays = data.filter(b => b.citymun_code === citySelect.value);
                barangays.forEach(barangay => {
                    const opt = document.createElement("option");
                    opt.value = barangay.brgy_code;
                    opt.textContent = barangay.name;
                    barangaySelect.appendChild(opt);
                });
                barangaySelect.disabled = false;
            })
            .catch(err => console.error("Error loading barangays:", err));
    });
});
