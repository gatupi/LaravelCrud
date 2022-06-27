function fillFilterForm() {
    var paramStr = window.location.search;
    var params = new URLSearchParams(paramStr);
    document.getElementById('name').value = params.get('name');
    var activityOptions = document.getElementById('activity').getElementsByTagName('option');
    for(let opt of activityOptions) {
        if (opt.value == params.get('activity')) {
            opt.selected = true;
            break;
        }
    }
    var sexOptions = document.getElementById('sex').getElementsByTagName('option');
    for(let opt of sexOptions) {
        if (opt.value == params.get('sex')) {
            opt.selected = true;
            break;
        }
    }
    var ageFilter = document.getElementById('age_filter_opt');
    var ageFilterOptions = ageFilter.getElementsByTagName('option');
    for(let opt of ageFilterOptions) {
        if (opt.value == params.get('age_filter_opt')) {
            opt.selected = true;
            ageFilter.onchange();
            let age1 = document.getElementById('age1');
            let age2 = document.getElementById('age2');
            if (age1)
                age1.value = params.get('age1');
            if (age2)
                age2.value = params.get('age2');
            break;
        }
    }
    var birthFilter = document.getElementById('birth_filter_opt');
    var birthFilterOptions = birthFilter.getElementsByTagName('option');
    for(let opt of birthFilterOptions) {
        if (opt.value == params.get('birth_filter_opt')) {
            opt.selected = true;
            birthFilter.onchange();
            let birthDate = document.getElementById('birth_date');
            if (birthDate)
                birthDate.value = params.get('birth_date');
            let birthMonth = document.getElementById('birth_month');
            if (birthMonth) {
                let options = birthMonth.getElementsByTagName('option');
                for(let opt of options) {
                    if (opt.value == params.get('birth_month')) {
                        opt.selected = true;
                        break;
                    }
                }
            }
            let birthYear = document.getElementById('birth_year');
            if (birthYear)
                birthYear.value = params.get('birth_year');
            let birthdayOptions = document.getElementsByName('birthday_option');
            console.log(birthdayOptions);
            if (birthdayOptions?.length > 0) {
                for(let opt of birthdayOptions) {
                    if (opt.value == params.get('birthday_option')) {
                        opt.checked = true;
                        break;
                    }
                }
            }
            break;
        }
    }
}

fillFilterForm();