jQuery(document).ready(function ($) {
    $(".dropbtn").click(function () {
        $("#myDropdown")[0].classList.toggle("show");
    });

    var countryData = window.intlTelInputGlobals.getCountryData();

    var preferedCountry = countryData.find(country => country.iso2 == 'kh');
    countryData = [preferedCountry].concat(countryData);
    var intputCountryCode = $("#myDropdown");
    $(".dropbtn").html('<div class="mr-2 iti__flag iti__' + preferedCountry.iso2 + '"></div> ' + '<div>+' + preferedCountry.dialCode + '</div>');

    for (var country of countryData) {
        var element = '<a class="dropdown-item" href="#"><div id="flag" class="mr-2 iti__flag iti__' + country.iso2 + '"></div><div class="flag-name">' + country.name + '</div><div><span class="dial-code text-muted"> +' + country.dialCode + '</span></div></a>';
        intputCountryCode.append(element);
    }

    $(".dropdown-item").click(function () {
        var selected = $(this).clone();
        selected.find('.flag-name').remove();
        $(".dropbtn").html(selected.html());
    });
    //Dimiss Dropdown
    window.onclick = function (event) {
        if (!event.target.matches('.dropbtn')) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            var i;
            for (i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }
}
);